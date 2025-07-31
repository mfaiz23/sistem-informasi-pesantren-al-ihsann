<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class FormulirController extends Controller
{
    /**
     * Menampilkan halaman formulir pendaftaran.
     */
    public function create(): View
    {
        return view('formulir');
    }
}