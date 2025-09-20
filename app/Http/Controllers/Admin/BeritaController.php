<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Berita::with('user');

        if ($request->filled('search')) {
            $searchTerm = '%'.$request->search.'%';
            $query->where('judul', 'like', $searchTerm);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $beritas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.berita', compact('beritas'));
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
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('storage/berita'), $imageName);
            $path = 'berita/'.$imageName;
        }

        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $path,
            'status' => $request->status,
            'users_id' => Auth::id(),
            'published_at' => $request->status == 'published' ? now() : null,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return response()->json($berita);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        $path = $berita->gambar;
        if ($request->hasFile('gambar')) {
            if ($berita->gambar && File::exists(public_path('storage/'.$berita->gambar))) {
                File::delete(public_path('storage/'.$berita->gambar));
            }
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('storage/berita'), $imageName);
            $path = 'berita/'.$imageName;
        }

        $berita->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $path,
            'status' => $request->status,
            'published_at' => $request->status == 'published' && ! $berita->published_at ? now() : $berita->published_at,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        if ($berita->gambar && File::exists(public_path('storage/'.$berita->gambar))) {
            File::delete(public_path('storage/'.$berita->gambar));
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function updateStatus(Request $request, Berita $berita)
    {
        $request->validate(['status' => 'required|in:published,draft']);

        $berita->update([
            'status' => $request->status,
            'published_at' => $request->status == 'published' ? now() : $berita->published_at,
        ]);

        return redirect()->back()->with('success', 'Status berita berhasil diperbarui.');
    }
}
