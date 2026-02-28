<?php

namespace App\Controllers;

class HasilController extends BaseController
{
    public function index()
    {
        
        $hasil = session()->get('hasil_peramalan');

        $data = [
            'page_title' => 'Hasil Peramalan Ekspor',
            'hasil'      => $hasil, 
        ];

        
        return view('hasil/index', $data);
    }
}
