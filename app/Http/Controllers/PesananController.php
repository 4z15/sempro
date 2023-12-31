<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan;
use App\Models\sayuran;
use App\Models\customer;
use PDF;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
// use Notify;
// use McKenziearts\Notify\Facades\Notify;



// Illuminate\Database\Eloquent\Collection::paginate


class PesananController extends Controller
{
    // cari sayur
    public function cari_sayur($kataKunci) 
    {
        $sayur = sayuran::where('nama', 'like', '%'.$kataKunci.'%')->get();

        return response()->json($sayur);
    }

    // print pesanan jadi pdf
    public function ubah_pesanan_pdf($id)
    {
        $customers = customer::with('pesanan')->where('id', $id)->first();
        $pdf = PDF::loadView('Pesanan.invoice', ['customers' => $customers])->setPaper('a5', 'portrait');
        // Di sini, 'a4' adalah ukuran kertas 
        // dan 'portrait' adalah  (portrait/landscape).


        //  path untuk menyimpan file PDF(public/Struk Pesanan)
        $savePath = public_path('Struk Pesanan');

        // kondisi direktori Struk Pesanan ada, jika tidak, buat direktori baru
        if (!File::isDirectory($savePath)) {
            File::makeDirectory($savePath, 0777, true, true);
        }

        $namafile = "Struk Pesanan " . $customers->nama . ".pdf";

        // Simpan file PDF ke dalam folder
        $pdf->save($savePath . '/' . $namafile);

        /// Return URL lengkap ke file PDF yang telah disimpan
        $pdfUrl = asset('Struk Pesanan/' . $namafile);
        
        return view('tampilkan_pdf', compact('pdfUrl'));

    }

    // Fungsi untuk mengirim dokumen (PDF) ke Telegram
    public function Kirim_pesanan_telegram($id,$pesan)
    {
        set_time_limit(120); // Atur batas waktu eksekusi menjadi 120 detik (2 menit)
        $token = '6345242238:AAFOqBINL8c10f3-IbliMuxTqgQWAaMmIdk'; //  token bot telegram
        $url = "https://api.telegram.org/bot{$token}/sendDocument";
        $chatId = '1964563690'; //ID obrolan  

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

    // Simpan Pesanan
    public function simpan_pesanan(Request $request)
    { 
        // validasi 
        $request->validate([
            'nama' => 'required|regex:/^[\pL\s]+$/u|max:255',
            // 'telp' => 'required|numeric|digits_between:10,12|unique:customers,telp',
            'tgl' => 'required|date|after_or_equal:yesterday|after:yesterday|after_or_equal:tomorrow|before_or_equal:'.Carbon::now()->addWeek()->toDateString(),
            'sayurs' => 'required|array',
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
            // 'tgl.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
            'tgl.after_or_equal' => 'Tanggal harus setelah hari ini.',
            'tgl.before_or_equal' => 'Tanggal tidak bisa lebih dari seminggu dari sekarang.',

        ]

        );

        // Simpan data pesanan
        $cust = new customer();
        $cust->nama = $request->input('nama');
        //  $cust->telp = $request->input('telp');
        $cust->tanggal = $request->input('tgl');
        $cust->save();

        // Simpan detail pesanan sayur
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
                
                // buat pesanan jadi pdf
                $this->ubah_pesanan_pdf($cust->id);
                $namaHari = date('w', strtotime($cust->tanggal)); // Mendapatkan indeks hari (0-6) dari tanggal yang diberikan
                $namaHariIndonesia = [
                    'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
                ];

                $hariIndonesia = $namaHariIndonesia[$namaHari]; // Mengambil nama hari dalam Bahasa Indonesia

                // pesan untuk pesanan
                $pesan = "Pesanan baru diterima!\nNama Pemesan: " . $cust->nama . "\nNomor Telepon: " . $cust->telp . "\nTanggal pesanan: " . $cust->tanggal . " (" . $hariIndonesia . ")";



                // Kirim pesan ke Telegram
                $this->Kirim_pesanan_telegram($cust->id,$pesan);

                return response()->json(['message' => 'Pesanan berhasil disimpan'], 200);
    }



        

  
       








}
