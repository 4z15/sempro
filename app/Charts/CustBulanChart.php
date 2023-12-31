<?php

namespace App\Charts;
use App\Models\customer;
use App\Models\pesanan;



use ArielMejiaDev\LarapexCharts\LarapexChart;

class CustBulanChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
    //     Grafik Jumlah Pesanan per Produk:

    // Jenis: Grafik Batang Horizontal atau Donat
    // Deskripsi: Menampilkan produk-produk yang paling banyak dipesan, memberikan wawasan tentang preferensi pelanggan.
        
        $pesanans = pesanan::get();
        $data = [
            $pesanans->where('pesanan' ,'waluh')->count(),
            $pesanans->where('pesanan' ,'kol')->count(),
            $pesanans->where('pesanan', 'buncis')->count(),
            $pesanans->where('pesanan', 'cumi')->count(),
            $pesanans->where('pesanan' ,'bayam')->count(),

        ];
        // dd($data);
        $label = [
            'waluh',
            'kol',
            'buncis',
            'cumi',
            'bayam',
        ];

        return $this->chart->pieChart()
            ->setTitle('Top item yg sering dipesan ')
            ->setSubtitle(date('M-Y'))
            ->addData($data)
            ->setHeight(400)
            ->setWidth(400)
            ->setLabels($label);
    }
}
