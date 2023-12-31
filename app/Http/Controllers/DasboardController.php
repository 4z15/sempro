<?php

namespace App\Http\Controllers;
use App\Models\pesanan;
use App\Models\customer;
use App\Models\sayuran;
use App\Charts\CustBulanChart;
// use app/Charts/CustBulanChart;





use Illuminate\Http\Request;

class DasboardController extends Controller
{
     public function index(CustBulanChart $CustBulanChart)
    {

      $customers = customer::with('pesanan')->get();
      $customersu = customer::with('pesanan')->where('status',1)->get();
      $customersb = customer::with('pesanan')->where('status',0)->get();



  
      return view('index', [
        'customers' => $customers,
        'customersu' => $customersu,
        'customersb' => $customersb,
        'CustBulanChart' => $CustBulanChart->build()
      ]);
    }

    public function test(){
      // $sayurans = sayuran::all();
      // notify()->success('Laravel Notify is awesome!');
      
      return view('test');
      // return view('invoice.invoice');
    }
}
