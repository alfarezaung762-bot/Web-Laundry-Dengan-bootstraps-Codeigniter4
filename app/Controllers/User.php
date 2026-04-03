<?php

namespace App\Controllers;


class User extends BaseController
{

    public function index()
    {
        return view('user/home');
    }

    public function paket()
    {
        return view('user/paket');
    }

    public function pickup()
    {
        return view('user/pickup');
    }

    public function lokasi()
    {
        return view('user/lokasi');
    }
    public function tentang()
    {
        return view('user/tentang');
    }
}
