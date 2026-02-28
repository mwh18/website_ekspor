<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\DataHistorisModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Periksa peran pengguna dari session
        if (session()->get('role') == 'admin') {
            // --- LOGIKA HANYA UNTUK ADMIN ---
            $produkModel = new ProdukModel();
            $dataHistorisModel = new DataHistorisModel();

            // Ambil data untuk kartu statistik
            $totalProduk = $produkModel->countAllResults();
            $totalData = $dataHistorisModel->countAllResults();
            
            // Ambil data periode terakhir
            $latestData = $dataHistorisModel->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->first();
            $periodeTerakhir = $latestData ? date('F Y', strtotime($latestData['tahun'].'-'.$latestData['bulan'].'-01')) : 'N/A';

            // Ambil data untuk grafik tren 12 bulan terakhir
            $chartData = $dataHistorisModel
                ->select("CONCAT(tahun, '-', LPAD(bulan, 2, '0')) as periode, SUM(jumlah_ekspor) as total_nilai")
                ->groupBy('tahun, bulan')
                ->orderBy('tahun, bulan', 'DESC')
                ->limit(12)
                ->get()
                ->getResultArray();
            
            // Balik urutan array agar urutan waktunya benar (dari lama ke baru)
            $chartData = array_reverse($chartData);

            $data = [
                'page_title'        => 'Dashboard Admin',
                'totalProduk'       => $totalProduk,
                'totalData'         => $totalData,
                'periodeTerakhir'   => $periodeTerakhir,
                'chartLabels'       => json_encode(array_column($chartData, 'periode')),
                'chartValues'       => json_encode(array_column($chartData, 'total_nilai')),
            ];

            return view('dashboard_view', $data); // Tampilkan view admin

        } else {
            // --- LOGIKA UNTUK PENGGUNA BIASA ---
            $data = [
                'page_title' => 'Dashboard',
            ];

            // Tampilkan view pengguna yang modern tanpa query yang tidak perlu
            return view('user_dashboard_view', $data);
        }
    }
}
