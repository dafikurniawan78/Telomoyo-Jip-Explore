<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketWisata;

class BerandaController extends Controller
{
    public function index()
    {
        $paket_wisatas = PaketWisata::orderBy('id', 'asc')->take(3)->get();

        return view('pages.beranda', compact('paket_wisatas'));
    }

    public function paket()
    {
        $paket_wisatas = PaketWisata::orderBy('id', 'asc')->get();

        return view('pages.paket', compact('paket_wisatas'));
    }
}
