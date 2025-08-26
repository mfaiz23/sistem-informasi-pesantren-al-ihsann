<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\KipDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FormulirController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran kosong.
     */
    public function create(): View
    {
        $user = Auth::user();

        // Jika user sudah punya data formulir...
        $formulir = $user->formulir ? $user->formulir->load(['alamat', 'parent']) : null;
        if ($formulir) {
            // ...tampilkan halaman 'show' (read-only).
            return view('formulir.show', [
                'user' => $user,
                'formulir' => $formulir,
            ]);
        }

        // Jika belum, tampilkan formulir kosong untuk diisi.
        return view('formulir', [
            'user' => $user,
        ]);
    }

    /**
     * Menyimpan data formulir yang baru dibuat.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateForm($request);

        $kipDocumentPath = null;
        if ($request->hasFile('dokumen_kip')) {
            $kipDocumentPath = $request->file('dokumen_kip')->store('dokumen-kip', 'public');
        }

        DB::transaction(function () use ($validatedData, $kipDocumentPath) {
            $formulirData = collect($validatedData)->except('dokumen_kip')->toArray();
            $formulir = Formulir::create(array_merge($formulirData, ['user_id' => Auth::id()]));

            $formulir->alamat()->create($validatedData);
            $formulir->parent()->create($validatedData);

            if ($kipDocumentPath) {
                KipDocument::create([
                    'formulir_id' => $formulir->id,
                    'dokumen_path' => $kipDocumentPath,
                ]);
            }
        });

        return redirect()->route('dashboard')->with('status', 'formulir-berhasil-disimpan');
    }

    /**
     * Menampilkan halaman profil yang berisi data formulir untuk diedit.
     */
    public function edit(Request $request): View|RedirectResponse // Sesuaikan return type
    {
        $user = $request->user();

        // Ganti firstOrFail() menjadi first()
        $formulir = $user->formulir()->with(['alamat', 'parent', 'kipDocument'])->first();

        // Tambahkan kondisi ini: Jika formulir tidak ditemukan...
        if (! $formulir) {
            // ...arahkan pengguna ke halaman untuk membuat formulir.
            return redirect()->route('formulir.create')->with('info', 'Mohon lengkapi formulir pendaftaran Anda terlebih dahulu.');
        }

        // Panggil Policy untuk keamanan
        $this->authorize('update', $formulir);

        // Jika formulir ditemukan, tampilkan halaman edit profil
        return view('profile.edit', [
            'user' => $user,
            'formulir' => $formulir,
        ]);
    }

    /**
     * Memperbarui data formulir dari halaman profil.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $formulir = $user->formulir;

        if (! $formulir) {
            return back()->with('error', 'Data formulir tidak ditemukan.');
        }

        $validatedData = $this->validateForm($request, true);

        if ($request->hasFile('dokumen_kip')) {
            $kipDocumentPath = $request->file('dokumen_kip')->store('dokumen-kip', 'public');
            $formulir->kipDocument()->updateOrCreate(
                ['formulir_id' => $formulir->id],
                ['dokumen_path' => $kipDocumentPath]
            );
        }

        DB::transaction(function () use ($formulir, $validatedData) {
            $formulirData = collect($validatedData)->except('dokumen_kip')->toArray();
            $formulir->update($formulirData);

            if ($formulir->alamat) {
                $formulir->alamat->update($validatedData);
            }

            if ($formulir->parent) {
                $formulir->parent->update($validatedData);
            }
        });

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Helper method untuk sentralisasi aturan validasi.
     */
    private function validateForm(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nama_panggilan' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date_format:Y-m-d|before_or_equal:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nik' => 'required|string|size:16',
            'kategori_pendaftaran' => 'required|in:Reguler,Non-Reguler',
            'no_kip' => 'required_if:kategori_pendaftaran,Non-Reguler|nullable|string|max:255',

            'asal_sd' => 'nullable|string|max:255',
            'tahun_lulus_sd' => 'nullable|string|size:4',
            'asal_smp' => 'nullable|string|max:255',
            'tahun_lulus_smp' => 'nullable|string|size:4',
            'asal_sma' => 'nullable|string|max:255',
            'tahun_lulus_sma' => 'nullable|string|size:4',
            'asal_universitas' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'fakultas' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string|max:255',

            'negara' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa_kelurahan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',

            'nama_ayah' => 'required|string|max:255',
            'no_telp_ayah' => 'required|string|max:15',
            'nama_ibu' => 'required|string|max:255',
            'no_telp_ibu' => 'required|string|max:15',
            'nama_wali' => 'nullable|string|max:255',
            'no_telp_wali' => 'nullable|string|max:15',
        ];

        $rules['dokumen_kip'] = $isUpdate
            ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
            : 'required_if:kategori_pendaftaran,Non-Reguler|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';

        return $request->validate($rules);
    }
}
