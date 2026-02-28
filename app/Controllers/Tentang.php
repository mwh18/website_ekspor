<?php

namespace App\Controllers;

class Tentang extends BaseController
{
    public function index()
    {
        $data = [
            'page_title' => 'Tentang Sistem',
        ];
        return view('tentang/index', $data);
    }
}