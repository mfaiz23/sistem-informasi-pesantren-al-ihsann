<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beritas = Berita::where('status', 'published')
            ->latest('published_at')
            ->paginate(6);

        return view('berita.berita', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $berita = Berita::where('status', 'published')->findOrFail($id);

        $beritaLainnya = Berita::where('status', 'published')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('berita.berita-selengkapnya', compact('berita', 'beritaLainnya'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
