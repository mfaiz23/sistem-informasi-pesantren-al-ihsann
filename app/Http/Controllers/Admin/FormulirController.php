<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FormulirRejected;
use App\Mail\FormulirVerified;
use App\Models\Formulir;
use App\Models\KipDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai kueri dengan eager loading
        $query = Formulir::with(['user', 'alamat', 'parent', 'kipDocument']);

        // Filter berdasarkan pencarian nama atau email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_panggilan', 'like', '%'.$search.'%')
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('email', 'like', '%'.$search.'%');
                });
        }

        // Filter berdasarkan tipe pendaftaran
        if ($request->filled('type')) {
            $query->where('kategori_pendaftaran', $request->input('type'));
        }

        // Filter berdasarkan status pendaftaran
        if ($request->filled('status')) {
            $query->where('status_pendaftaran', $request->input('status'));
        }

        // Ambil data yang sudah difilter dan gunakan paginate()
        $formulirs = $query->paginate(10);

        return view('admin.pendaftaran-santri', compact('formulirs'));
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
        // $this->authorize('viewAny', Formulir::class);
        // $formulir = Formulir::with(['user', 'alamat', 'parent', 'kipDocument'])->findOrFail($id);

        // return response()->json($formulir);
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
        try {
            $formulir = Formulir::findOrFail($id);

            // Hapus data terkait jika ada
            if ($formulir->alamat) {
                $formulir->alamat->delete();
            }

            if ($formulir->parent) {
                $formulir->parent->delete();
            }

            if ($formulir->kipDocument) {
                $formulir->kipDocument->delete();
            }

            $formulir->delete();

            return redirect()->back()->with('success', 'Data pendaftar berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pendaftar!');
        }
    }

    /**
     * Verify a specific form.
     */
    public function verifikasi($id)
    {
        $formulir = Formulir::findOrFail($id);

        // Validasi: hanya bisa verifikasi jika status masih 'menunggu_verifikasi'
        if ($formulir->status_pendaftaran != 'menunggu_verifikasi') {
            return redirect()->back()->with('error', 'Formulir sudah diverifikasi sebelumnya.');
        }

        // ubah status jadi diverifikasi
        $formulir->status_pendaftaran = 'diverifikasi';
        $formulir->save();

        if ($formulir->kipDocument) {
            // Jika ada, ubah status verifikasi dokumen KIP
            $kipDocument = $formulir->kipDocument;
            $kipDocument->status_verifikasi = 'valid';
            $kipDocument->save();
        }

        if ($formulir->user && $formulir->user->email) {
            Mail::to($formulir->user->email)->send(new FormulirVerified($formulir));
        }

        return redirect()->back()->with('success', 'Formulir berhasil diverifikasi.');
    }

    /**
     * Menolak formulir pendaftaran.
     */
    public function tolak(Request $request, $id)
    {
        // Validasi input dari modal
        $request->validate([
            'alasan_penolakan' => 'required|string|min:10|max:1000',
        ]);

        $formulir = Formulir::with('user', 'kipDocument')->findOrFail($id); // Eager load kipDocument

        // 1. Pemeriksaan Status yang Konsisten
        if ($formulir->status_pendaftaran !== 'menunggu_verifikasi') {
            return redirect()->back()->with('error', 'Formulir ini tidak dalam status "menunggu verifikasi" dan tidak dapat diproses.');
        }

        // 2. Ubah Status dan Simpan Alasan
        $formulir->status_pendaftaran = 'ditolak';
        $formulir->alasan_penolakan = $request->input('alasan_penolakan');
        $formulir->save();

        // Jika ada dokumen KIP, ubah juga status verifikasinya menjadi "tidak valid".
        if ($formulir->kipDocument) {
            $formulir->kipDocument->update(['status_verifikasi' => 'tidak_valid']);
        }

        // 3. Kirim Email Notifikasi dengan Penanganan Error yang Lebih Baik
        try {
            if ($formulir->user && $formulir->user->email) {
                Mail::to($formulir->user->email)->send(new FormulirRejected($formulir));
            }
        } catch (\Exception $e) {
            // Catat error ke log untuk developer
            Log::error('Gagal mengirim email penolakan untuk formulir ID '.$formulir->id.': '.$e->getMessage());

            // Berikan pesan error yang jelas kepada admin
            return redirect()->back()->with('error', 'Formulir ditolak, tetapi notifikasi email gagal dikirim. Silakan cek konfigurasi email Anda. Error: '.$e->getMessage());
        }

        return redirect()->back()->with('success', 'Formulir berhasil ditolak dan notifikasi telah dikirim ke pendaftar.');
    }

    /**
     * Download the specified KIP document.
     */
    public function downloadKipDocument($id)
    {
        try {
            // Cari dokumen KIP berdasarkan ID
            $kipDocument = KipDocument::findOrFail($id);

            // Buat path lengkap ke file
            $filePath = $kipDocument->dokumen_path;

            // Cek apakah file ada di storage
            if (Storage::disk('public')->exists($filePath)) {

                // Ambil path absolut dari file
                $absolutePath = Storage::disk('public')->path($filePath);

                // Periksa apakah path absolut valid
                if (! file_exists($absolutePath)) {
                    return redirect()->back()->with('error', 'Dokumen tidak dapat diakses.');
                }

                return response()->download($absolutePath);
            }

            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Dokumen pendaftar tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh dokumen.');
        }
    }
}
