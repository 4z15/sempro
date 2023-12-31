<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan;
use App\Models\sayuran;
use App\Models\customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


// use Illuminate\Http\Request;


class AdminController extends Controller
{
    // index
    public function index()
    {
        return view("sesi.index");
    }
    // login
    public function login(Request $request)
    {       
            // return view("sesi");
        Session::flash('username',$request->username);
        $request->validate([
            'username' => 'required',
        // 'pesanan' => 'required|max:20',
            'password' => 'required',
        ],[
            "username.required" => "Username wajib di isi",
            "password.required" => "password wajib di isi",

        ]);

        $infologin = [
            'username' => $request->username,
            'password' => $request->password,

        ];

        if (Auth::attempt($infologin)) {
           // notify()->success('Laravel Notify is good!');
           return redirect('/')->with('success',"Selamat datang $request->username");

            // code...
       }
       else{
        $errors = "Username dan password salah";
        return redirect('/sesi')->withErrors($errors);
        }
    }   

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect("/admin/index")->with("success","Anda Berhasil Logout");
    }

    // tambah_pesanan
    public function insert_data_pesanan()
    {
            $sayurans = sayuran::all();
            return view('Pesanan.create',['sayurans' => $sayurans ]);
    }


    // delete_pesanan
    public function hapus_pesanan($id)
    {
                $cust = customer::find($id);
                    $cust->pesanan()->delete(); // Menghapus data di tabel Profile terlebih dahulu
                    $cust->delete();
            
                    return redirect('/pesanan')->with('success','data berhasil di hapus');
    }

    // detail pesanan
    public function detail_pesanan($id)
    {
                $customers = customer::with('pesanan')->where('id',$id)->first();
                        // dd($customers);
                return view('Pesanan.detail', ['customers' => $customers]);
    }

    // cari pesanan
    public function cari_pesanan(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;
        $customers = customer::with('pesanan')->where('nama','like',"%".$cari."%")->paginate(5);

                // mengirim data pegawai ke view index
        if ($customers->isEmpty()) {
                // return redirect()->route('pesanan')->with('error', 'Tidak ada customer ditemukan.');
            return redirect('/pesanan')->with('errors', 'Tidak ada customer ditemukan.');

        } else {
            return view('Pesanan.index', ['customers' => $customers ]);
        }

    }

     // index_pesanan
    public function lihat_data_pesanan()
    {
 
       $customers = customer::with('pesanan')->orderBy('created_at','desc')->paginate(5);
       return view('Pesanan.index', [
         'customers' => $customers
        ]);
    }

    // up_status
    public function Aktivasi_Pembayaran($id)
    {

        $data =  customer::where('id',$id)->first();
        $status_sekarang = $data->status;
        if($status_sekarang == 1){
            $data->update([
                'status' => 0,
            ]
        );
        }else{
            $data->update([
                'status' => 1,
            ]
        );
        }

        return redirect('/pesanan');


    }



}


