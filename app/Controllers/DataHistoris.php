<?php

namespace App\Controllers;

use App\Models\DataHistorisModel;
use App\Models\ProdukModel;

class DataHistoris extends BaseController
{
    protected $dataHistorisModel;
    protected $produkModel;

    public function __construct()
    {
        $this->dataHistorisModel = new DataHistorisModel();
        $this->produkModel = new ProdukModel();
    }

    // Menampilkan semua data DAN grafik
    public function index()
    {
        $allData = $this->dataHistorisModel->getAllData();

        // --- KODE BARU UNTUK MENYIAPKAN DATA GRAFIK ---
        $chartData = [];
        foreach ($allData as $item) {
            $productName = $item['nama_produk'];
            $period = $item['tahun'] . '-' . str_pad($item['bulan'], 2, '0', STR_PAD_LEFT);
            $value = $item['jumlah_ekspor'];

            if (!isset($chartData[$productName])) {
                $chartData[$productName] = [
                    'labels' => [],
                    'values' => [],
                ];
            }
            $chartData[$productName]['labels'][] = $period;
            $chartData[$productName]['values'][] = $value;
        }
        // --- AKHIR KODE BARU ---

        $data = [
            'page_title'    => 'Manajemen Data Historis',
            'data_historis' => $allData,
            'chartData'     => json_encode($chartData) // Kirim data grafik sebagai JSON
        ];
        return view('data_historis/index', $data);
    }

    // ... (method create, store, edit, update, delete tidak berubah) ...
    
    public function create()
    {
        $data = [
            'page_title' => 'Tambah Data Historis',
            'produk' => $this->produkModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('data_historis/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'id_produk' => 'required',
            'tahun' => 'required|numeric',
            'bulan' => 'required|numeric',
            'jumlah_ekspor' => 'required|numeric'
        ])) {
            return redirect()->to('/data-historis/new')->withInput();
        }

        $this->dataHistorisModel->save([
            'id_produk' => $this->request->getVar('id_produk'),
            'tahun' => $this->request->getVar('tahun'),
            'bulan' => $this->request->getVar('bulan'),
            'jumlah_ekspor' => $this->request->getVar('jumlah_ekspor'),
        ]);

        session()->setFlashdata('success', 'Data berhasil ditambahkan.');
        return redirect()->to('/data-historis');
    }
    
    public function edit($id)
    {
        $data = [
            'page_title' => 'Edit Data Historis',
            'produk' => $this->produkModel->findAll(),
            'data_historis' => $this->dataHistorisModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        if (empty($data['data_historis'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan.');
        }
        return view('data_historis/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'id_produk' => 'required',
            'tahun' => 'required|numeric',
            'bulan' => 'required|numeric',
            'jumlah_ekspor' => 'required|numeric'
        ])) {
            return redirect()->to('/data-historis/edit/' . $id)->withInput();
        }

        $this->dataHistorisModel->update($id, [
            'id_produk' => $this->request->getVar('id_produk'),
            'tahun' => $this->request->getVar('tahun'),
            'bulan' => $this->request->getVar('bulan'),
            'jumlah_ekspor' => $this->request->getVar('jumlah_ekspor'),
        ]);

        session()->setFlashdata('success', 'Data berhasil diperbarui.');
        return redirect()->to('/data-historis');
    }

    public function delete($id)
    {
        $this->dataHistorisModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('/data-historis');
    }
}
