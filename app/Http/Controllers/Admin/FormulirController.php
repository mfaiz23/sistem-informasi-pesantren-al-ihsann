<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\DokumenRejected;
use App\Mail\DokumenVerified;
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
        $formulir = Formulir::with('kipDocument')->findOrFail($id);

        // Cek Status Semua Dokumen
        $dokumenCheck = [
            'KTP' => $formulir->status_dokumen_ktp,
            'KK' => $formulir->status_dokumen_kk,
            'Ijazah' => $formulir->status_dokumen_ijazah,
        ];

        // Tambah cek KIP jika Non-Reguler
        if ($formulir->kategori_pendaftaran === 'Non-Reguler' && $formulir->kipDocument) {
            $statusKip = $formulir->kipDocument->status_verifikasi;
            // Normalisasi status kip agar seragam
            $dokumenCheck['KIP'] = ($statusKip == 'tidak_valid') ? 'invalid' : ($statusKip ?? 'pending');
        }

        // Cari dokumen yang bermasalah
        $pending = array_keys(array_filter($dokumenCheck, fn ($s) => $s === 'pending'));
        $invalid = array_keys(array_filter($dokumenCheck, fn ($s) => $s === 'invalid'));

        // LOGIKA PERINGATAN / BLOKIR
        if (! empty($pending)) {
            return redirect()->back()->with('error', 'Gagal Verifikasi: Dokumen berikut BELUM diperiksa: '.implode(', ', $pending).'. Harap periksa dokumen terlebih dahulu.');
        }

        if (! empty($invalid)) {
            return redirect()->back()->with('error', 'Gagal Verifikasi: Ada dokumen yang statusnya DITOLAK ('.implode(', ', $invalid).'). Mohon perbaiki status dokumen atau tolak formulir pendaftaran.');
        }

        // Jika semua aman, lanjut verifikasi
        if ($formulir->status_pendaftaran != 'menunggu_verifikasi') {
            return redirect()->back()->with('error', 'Formulir sudah diproses sebelumnya.');
        }

        $formulir->status_pendaftaran = 'diverifikasi';
        $formulir->save();

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

    public function updateDocumentStatus(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'formulir_id' => 'required|exists:formulirs,id',
            'jenis_dokumen' => 'required|in:ktp,kk,ijazah,kip',
            'status' => 'required|in:valid,invalid',
            'alasan' => 'nullable|string',
        ]);

        // 2. Ambil Data Formulir & User
        $formulir = Formulir::with('user', 'kipDocument')->findOrFail($request->formulir_id);
        $jenis = $request->jenis_dokumen;
        $status = $request->status;
        $alasan = $request->alasan;

        // 3. Buat Label Dokumen yang Rapi untuk Email
        // (Agar di email tertulis "Kartu Keluarga", bukan "kk")
        $labelDokumen = match ($jenis) {
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga',
            'ijazah' => 'Ijazah Terakhir',
            'kip' => 'Kartu Indonesia Pintar',
            default => strtoupper($jenis),
        };

        // 4. Update Database (Logika Simpan)
        if ($jenis === 'kip') {
            if (! $formulir->kipDocument) {
                return redirect()->back()->with('error', 'Dokumen KIP tidak ditemukan.');
            }
            $formulir->kipDocument->update([
                'status_verifikasi' => $status == 'valid' ? 'valid' : 'tidak_valid',
                'alasan_penolakan' => $status == 'invalid' ? $alasan : null,
            ]);
        } else {
            $colStatus = "status_dokumen_{$jenis}";
            $colAlasan = "alasan_tolak_{$jenis}";

            $formulir->$colStatus = $status;
            $formulir->$colAlasan = $status == 'invalid' ? $alasan : null;
            $formulir->save();
        }

        // 5. KIRIM EMAIL (Logic Baru)
        if ($formulir->user && $formulir->user->email) {
            try {
                if ($status == 'valid') {
                    // Kirim Email Valid
                    Mail::to($formulir->user->email)
                        ->send(new DokumenVerified($formulir->user, $labelDokumen));
                } else {
                    // Kirim Email Ditolak (Sertakan alasan)
                    Mail::to($formulir->user->email)
                        ->send(new DokumenRejected($formulir->user, $labelDokumen, $alasan));
                }
            } catch (\Exception $e) {
                // Log error jika email gagal, tapi jangan hentikan proses controller
                Log::error('Gagal kirim email dokumen: '.$e->getMessage());
            }
        }

        return redirect()->back()->with('success', "Status dokumen $labelDokumen berhasil diperbarui.");
    }

    public function verifyAllDocuments(Request $request, $id)
    {
        // Gunakan Eager Loading untuk efisiensi
        $formulir = Formulir::with(['user', 'kipDocument'])->findOrFail($id);
        $user = $formulir->user;

        // Daftar dokumen yang akan divalidasi
        $documentsToUpdate = [
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga',
            'ijazah' => 'Ijazah Terakhir',
        ];

        // 1. Update Dokumen Utama
        $formulir->status_dokumen_ktp = 'valid';
        $formulir->alasan_tolak_ktp = null;

        $formulir->status_dokumen_kk = 'valid';
        $formulir->alasan_tolak_kk = null;

        $formulir->status_dokumen_ijazah = 'valid';
        $formulir->alasan_tolak_ijazah = null;

        $formulir->save(); // Simpan perubahan formulir utama

        // Kirim email notifikasi untuk dokumen utama
        if ($user && $user->email) {
            foreach ($documentsToUpdate as $key => $label) {
                try {
                    Mail::to($user->email)->send(new DokumenVerified($user, $label));
                } catch (\Exception $e) {
                    Log::error("Gagal kirim email bulk verify ($label): ".$e->getMessage());
                }
            }
        }

        // 2. Update KIP (Jika Ada)
        if ($formulir->kipDocument) {
            $formulir->kipDocument->update([
                'status_verifikasi' => 'valid',
                'alasan_penolakan' => null,
            ]);

            // Kirim email notifikasi KIP
            if ($user && $user->email) {
                try {
                    Mail::to($user->email)->send(new DokumenVerified($user, 'Kartu Indonesia Pintar'));
                } catch (\Exception $e) {
                    Log::error('Gagal kirim email bulk verify (KIP): '.$e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', 'Semua dokumen berhasil ditandai sebagai VALID dan notifikasi telah dikirim.');
    }
}
