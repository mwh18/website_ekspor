<?php

namespace App\Models;

use CodeIgniter\Model;

class DataHistorisModel extends Model
{
    protected $table            = 'data_historis';
    protected $primaryKey       = 'id_data';
    protected $allowedFields    = ['id_produk', 'tahun', 'bulan', 'jumlah_ekspor'];

    // Fungsi untuk mengambil semua data dengan nama produknya (JOIN)
    public function getAllData()
    {
        return $this->db->table('data_historis')
            ->join('produk', 'produk.id_produk = data_historis.id_produk')
            ->orderBy('tahun', 'DESC')
            ->orderBy('bulan', 'DESC')
            ->get()
            ->getResultArray();
    }
}