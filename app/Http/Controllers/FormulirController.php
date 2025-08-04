<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Formulir;
use Illuminate\Support\Facades\Auth;

class FormulirController extends Controller
{
    /**
     * Menampilkan halaman formulir pendaftaran.
     */
    public function create(): View
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();
        // Kirim data user ke view
        return view('formulir', compact('user'));
    }

    /**
     * Menyimpan data formulir pendaftaran baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'], 
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'kategori_pendaftaran' => ['required', 'in:Reguler,Non-Reguler'],
            'no_ijazah' => ['nullable', 'string', 'max:255'],
            'no_telp_orang_tua' => ['required', 'string', 'max:255'],
        ]);

        $validated['user_id'] = Auth::id();
        Formulir::create($validated);

        return redirect()->route('dashboard')->with('status', 'formulir-saved');
    }
}
