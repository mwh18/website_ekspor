<?php

namespace App\Controllers;

use App\Models\DataHistorisModel;
use App\Models\ProdukModel;

class Peramalan extends BaseController
{
    protected $dataHistorisModel;
    protected $produkModel;
    protected $client; // Properti untuk HTTP client

    public function __construct()
    {
        $this->dataHistorisModel = new DataHistorisModel();
        $this->produkModel = new ProdukModel();
        
        // Inisialisasi HTTP Client di constructor agar lebih efisien
        $this->client = \Config\Services::curlrequest([
            'baseURI' => 'http://127.0.0.1:5000', // URL base API Python
            'timeout' => 300, // Timeout diperpanjang menjadi 5 menit untuk proses auto_arima yang mungkin lama
        ]);
    }

    public function index()
    {
        $data = [
            'page_title' => 'Lakukan Peramalan Ekspor',
            'produk'     => $this->produkModel->findAll(),
        ];
        return view('peramalan/index', $data);
    }

    public function proses()
    {
        // Validasi input
        if (!$this->validate([
            'id_produk' => 'required',
            'periode'   => 'required|numeric|greater_than[0]'
        ])) {
            return redirect()->to('/peramalan')->withInput()->with('error', 'Input tidak valid.');
        }

        $id_produk = $this->request->getPost('id_produk');
        $periode = $this->request->getPost('periode');

        // Ambil data historis dari database, diurutkan berdasarkan tanggal
        $dataHistoris = $this->dataHistorisModel
            ->where('id_produk', $id_produk)
            ->orderBy('tahun', 'ASC')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        // Cek jika data historis cukup (sesuai dengan kebutuhan API Python)
        if (count($dataHistoris) < 24) {
            session()->setFlashdata('error', 'Data historis tidak cukup untuk melakukan peramalan. Minimal dibutuhkan 24 bulan data.');
            return redirect()->to('/peramalan');
        }

        // Siapkan data untuk dikirim ke API
        $payload = [
            'data'    => $dataHistoris,
            'periods' => (int)$periode
        ];

        try {
            // Kirim request POST ke endpoint /predict
            $response = $this->client->post('predict', [
                'json' => $payload // Opsi 'json' otomatis mengatur header dan encoding
            ]);

            $body = $response->getBody();
            $result = json_decode($body, true);
            
            // Cek jika ada pesan error dari API Python
            if (isset($result['error'])) {
                session()->setFlashdata('error', 'Gagal melakukan peramalan dari API: ' . $result['error']);
                return redirect()->to('/peramalan');
            }

            // PERBAIKAN: Ekstrak hanya nilai prediksi dari array 'predictions'
            $prediksiValues = array_column($result['predictions'] ?? [], 'prediksi');

            // Simpan hasil ke session untuk ditampilkan di halaman hasil
            session()->set('hasil_peramalan', [ // Menggunakan nama session yang konsisten
                'data_historis' => $dataHistoris,
                'prediksi'      => $prediksiValues, // Menyimpan array nilai prediksi yang sudah bersih
                'mape'          => $result['mape'] ?? null,
                'mae'           => $result['mae'] ?? null, // Menambahkan MAE ke session
                'produk'        => $this->produkModel->find($id_produk)
            ]);

            // Arahkan ke halaman hasil (pastikan route Anda benar)
            return redirect()->to('/hasil-peramalan');

        } catch (\Exception $e) {
            // Tangani jika API tidak bisa dihubungi
            session()->setFlashdata('error', 'Tidak dapat terhubung ke server peramalan. Pastikan API Python sudah berjalan. Detail: ' . $e->getMessage());
            return redirect()->to('/peramalan');
        }
    }
}
