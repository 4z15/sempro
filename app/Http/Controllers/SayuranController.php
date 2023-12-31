<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sayuran;
use Illuminate\Support\Facades\DB;

class SayuranController extends Controller
{
    //index
     public function index()
    {
      $sayurans = sayuran::paginate(5);
  
      return view('Sayur.index', ['sayurans' => $sayurans]);
    }
    // tambah_pesanan
     public function insert()
    {
  
      return view('Sayur.create');
    }

    public function insertwModel(Request $request)
    {
      $request->validate([
        'nama' => 'required|max:20',
        'harga_kg' => 'required|max:20',
        'harga_satuan' => 'required|max:20',
        'stok' => 'required|max:20',

      ]);
  
      $sayuran = new sayuran();
      $sayuran->nama = $request->input('nama');
      $sayuran->harga_kg = $request->input('harga_kg');
      $sayuran->harga_satuan = $request->input('harga_satuan');
      $sayuran->stok = $request->input('stok');

      $sayuran->save();
  
      return redirect('/sayuran')->with('success', 'Data created!');
    }

    // cari sayuran
    public function cari(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;
    
        // mengambil data dari table pegawai sesuai pencarian data
        $sayurans = DB::table('sayurans')
        ->where('nama','like',"%".$cari."%")
        ->paginate();
    
            // mengirim data pegawai ke view index
        return view('Sayur.index',['sayurans' => $sayurans]);
 
    }

 // update_sayuran
    public function edit($id)
    {
        // mengambil data pegawai berdasarkan id yang dipilih
        $sayurans = DB::table('sayurans')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('Sayur.edit',['sayurans' => $sayurans]);
    
    }

    public function update(Request $request)
    {
        // update data pegawai
        // cara 1
        // DB::table('pesanans')->where('id',$request->id)->update([
        //     'nama' => $request->nama,
        //     'pesanan' => $request->pesanan,
        //     'berat' => $request->berat,
        //     // 'pegawai_alamat' => $request->alamat
        // ]);

        // cara 2
        $sayuran = sayuran::where('id',$request->id);
        $sayuran->update([
            'nama' => $request->nama,
            'harga_kg' => $request->harga_kg,
            'harga_satuan' => $request->harga_satuan,
            'stok' => $request->stok,

        ]
        );
        // alihkan halaman ke halaman pegawai
        return redirect('/sayuran');
    }

// detail sayuran
    public function getbyid($id)
    {
      $sayuran = sayuran::find($id);
  
      return view('Sayur.detail', ['sayuran' => $sayuran]);
    }

// delete sayuran
    public function delete($id)
    {
        $sayuran = sayuran::find($id);
        $sayuran->delete();
        return redirect('/sayuran')->with('success','data sayur terhapus');
    }


    public function calculate(Request $request)
    {
        $operand1 = $request->input('operand1');
        $operand2 = $request->input('operand2');
        $operator = $request->input('operator');

        switch ($operator) {
            case 'add':
                $result = $operand1 + $operand2;
                break;
            case 'subtract':
                $result = $operand1 - $operand2;
                break;
            case 'multiply':
                $result = $operand1 * $operand2;
                break;
            case 'divide':
                $result = $operand1 / $operand2;
                break;
            default:
                $result = 'Invalid operator';
        }

        return view('calculator', ['result' => $result]);
    }
     public function clc()
    {
        return view('calculator');
    }
}
