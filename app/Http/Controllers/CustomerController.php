<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan;
use App\Models\sayuran;
use App\Models\customer;
use PDF;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\File;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Http;
// use Notify;

class CustomerController extends Controller
{
    //
    // cust
    public function cust()
    {
        $customers = customer::orderBy('created_at','desc')->paginate(5);
        return view('Pelanggan.cust', [
            'customers' => $customers
        ]);
    }


    // tambah
    public function tambah($id)
    {
        $custs = customer::with('pesanan')->find($id);
            // dd($pesanans);
        return view('Pelanggan.cust-create',['custs' => $custs]);
    }

    public function invoice($id)
    {
        $customers = customer::with('pesanan')->where('id', $id)->first();
        $pdf = PDF::loadView('Pesanan.invoice', ['customers' => $customers]);

        // Tentukan path untuk menyimpan file PDF
        $savePath = public_path('Struk Pesanan');

        // Pastikan direktori Struk Pesanan ada, jika tidak, buat direktori baru
        if (!File::isDirectory($savePath)) {
            File::makeDirectory($savePath, 0777, true, true);
        }

        $namafile = "Struk Pesanan " . $customers->nama . ".pdf";

        // Simpan file PDF ke dalam folder
        $pdf->save($savePath . '/' . $namafile);

        /// Return URL lengkap ke file PDF yang telah disimpan
        $pdfUrl = asset('Struk Pesanan/' . $namafile);
        return view('tampilkan_pdf', compact('pdfUrl'));

                // Sekarang, kirim respons untuk mengunduh file PDF
                // return $pdf->download($namafile);
    }

// save
    public function save(Request $request)
    {
        // dd($request->tanggal);
            $request->validate([
                'nama' => 'required|regex:/^[\pL\s]+$/u|max:255',
                // 'telp' => 'required|numeric|digits_between:10,12|unique:customers,telp',
                'tgl' => 'required|date|after_or_equal:yesterday|after:yesterday|after_or_equal:today|before_or_equal:'.Carbon::now()->addWeek()->toDateString(),
                        // 'sayurs' => 'required|array',
                'sayurs.*.berat' => 'required|numeric',
                'catatan' => 'max:255',
            ],[
                'sayurs.*.berat.numeric' => 'Berat harus berupa angka.',
                // 'sayurs.*.berat.min' => 'Berat minimal 0.25 kg.',
                'sayurs.*.berat.required' => 'Berat harus di isi.',
            
                'nama.required' => 'nama harus diisi.',
                'nama.alpha' => 'nama harus berupa huruf.',
                // 'telp.required' => 'telepon harus diisi.',
                // 'telp.numeric' => 'telepon harus berupa angka.',
                // 'telp.digits_between' => 'Kolom telepon harus memiliki panjang antara :min dan :max digit.',
                // 'telp.unique' => 'Nomor telepon sudah digunakan.',
            
                'tgl.required' => 'tanggal harus diisi.',
                'tgl.after_or_equal' => 'Tanggal tidak bisa hari kemarin atau bulan/tahun kemarin.',
                'tgl.after' => 'Tanggal tidak bisa hari kemarin.',
                'tgl.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
                'tgl.before_or_equal' => 'Tanggal tidak bisa lebih dari seminggu dari sekarang.',
            
            ]
            
            );
        
            $id = $request->customer_id;
            $cust = customer::find($id);
            $cust->pesanan()->delete();
            // $data = $request->all();

                // update customer
            $cust = customer::with('pesanan')->find($id);
            $cust->update([
                'nama' => $request->nama,
                // 'telp' => $request->telp,
                'tanggal' => $request->tgl,
                'status' => 0,

            ]
            );
            
            $sayurs = $request->input('sayurs');
            foreach ($sayurs as $nama => $detail) {
                $pesanan = new pesanan();
                $pesanan->pesanan = $detail['nama'];;
                $pesanan->berat = $detail['berat'];
                $pesanan->harga = $detail['harga'];
                $pesanan->total = $detail['total'];
                $pesanan->Bayar = $detail['Bayar'];
            $pesanan->Kembalian = $detail['Kembalian'];
            $pesanan->catatan = $request->input('catatan');

                    $pesanan->customer_id = $cust->id; // Hubungkan dengan pesanan
                    $pesanan->sayuran_id = $detail['sayurid']; // Hubungkan dengan pesanan
                    $pesanan->save();
                }

                $this->invoice($cust->id);
                $namaHari = date('w', strtotime($cust->tanggal)); // Mendapatkan indeks hari (0-6) dari tanggal yang diberikan
                $namaHariIndonesia = [
                    'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
                ];

                $hariIndonesia = $namaHariIndonesia[$namaHari]; // Mengambil nama hari dalam Bahasa Indonesia

                $pesan = "Pesanan baru diterima!\nNama Pemesan: " . $cust->nama . "\nNomor Telepon: " . $cust->telp . "\nTanggal pesanan: " . $cust->tanggal . " (" . $hariIndonesia . ")";
                // Kirim pesan ke Telegram
                // $this->sendMessageToTelegram($pesan);
                $pdfUrl = url('/cust/invoice/' . $cust->id); // URL dari file PDF
                $this->sendDocumentToTelegram($cust->id,$pesan);
                return response()->json(['message' => 'Pesanan berhasil disimpan', 'pdfUrl' => $pdfUrl], 200);

            
    }

    public function cari(Request $request)
    {
                // menangkap data pencarian
                $cari = $request->cari;
                $customers = customer::with('pesanan')->where('nama','like',"%".$cari."%")->paginate(5);

                    // mengirim data pegawai ke view index
                if ($customers->isEmpty()) {
                    // return redirect()->route('pesanan')->with('error', 'Tidak ada customer ditemukan.');
                    return redirect('/cust')->with('errors', 'Tidak ada customer ditemukan.');

                } else {
                    foreach ($customers as $cust) {
                $tanggal = Date::parse($cust->tanggal)->locale('id'); // Menggunakan package jenssegers/date
                $cust->hari = ucfirst($tanggal->format('l'));
                $cust->bulan = ucfirst($tanggal->format('F'));
            }
            return view('Pelanggan.cust', ['customers' => $customers ]);
        }

    }

    // Fungsi untuk mengirim dokumen (PDF) ke Telegram
    public function sendDocumentToTelegram($id,$pesan)
    {
        set_time_limit(120); // Atur batas waktu eksekusi menjadi 120 detik (2 menit)
        $token = '6345242238:AAFOqBINL8c10f3-IbliMuxTqgQWAaMmIdk'; // Ganti dengan token bot Anda
        $url = "https://api.telegram.org/bot{$token}/sendDocument";
        $chatId = '1964563690';

        // cari cust berdsarkan id
        $customers = customer::with('pesanan')->where('id', $id)->first();
        if ($customers) {
        $nama = $customers->nama; // Mengambil nama pelanggan dari data yang ada di database

        // Membuat nama file PDF berdasarkan nama pelanggan
        $namafile = "Struk Pesanan " . $nama . ".pdf";

        // Path ke file PDF berdasarkan nama file yang sudah dibuat
        $pdfPath = public_path('Struk Pesanan/' . $namafile);

        // Kirim PDF ke Telegram
        try {
            $response = Http::attach(
                'document', file_get_contents($pdfPath), $namafile
            )->post($url, [
                'chat_id' => $chatId,
                'caption' => $pesan,
            ]);

            // ...
        } catch (Exception $e) {
            // ...
        }
        }


    }



}
