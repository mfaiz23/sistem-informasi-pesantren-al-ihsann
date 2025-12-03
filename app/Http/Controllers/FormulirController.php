<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\KipDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FormulirController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran kosong.
     */
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $invoice = $user->invoices()
            ->where('type', 'formulir')
            ->where('status', 'paid')
            ->exists();

        if (! $invoice) {
            $pending = $user->invoices()
                ->where('type', 'formulir')
                ->where('status', 'pending')
                ->latest('id')
                ->first();

            if ($pending) {
                try {
                    $resp = \Midtrans\Transaction::status($pending->invoice_number);
                    $ts = $resp->transaction_status ?? null;
                    $paymentType = $resp->payment_type ?? null;
                    $fraud = $resp->fraud_status ?? null;

                    if ($ts === 'settlement' || ($ts === 'capture' && $paymentType === 'credit_card' && $fraud === 'accept')) {
                        DB::transaction(function () use ($user, $pending, $resp, $paymentType) {
                            \App\Models\Payment::updateOrCreate(
                                ['invoice_id' => $pending->id],
                                [
                                    'amount' => $pending->amount,
                                    'status' => 'success',
                                    'payment_method' => $paymentType,
                                    'midtrans_order_id' => $pending->invoice_number,
                                    'midtrans_transaction_id' => (string) ($resp->transaction_id ?? \Illuminate\Support\Str::uuid()),
                                    'raw_response' => json_encode($resp),
                                ]
                            );
                            $pending->update(['status' => 'paid', 'completed_at' => now()]);

                            \App\Models\Invoice::where('user_id', $user->id)
                                ->where('type', 'formulir')
                                ->where('status', 'pending')
                                ->where('id', '!=', $pending->id)
                                ->update(['status' => 'failed']);
                        });

                        $invoice = true;
                    } elseif (in_array($ts, ['expire', 'cancel', 'deny'])) {
                        $pending->update(['status' => 'failed']);
                    }
                } catch (\Throwable $e) {
                }
            }
        }

        if (! $invoice) {
            return redirect()->route('dashboard')->with('error', 'Anda harus menyelesaikan pembayaran terlebih dahulu sebelum mengisi formulir.');
        }

        $formulir = $user->formulir ? $user->formulir->load(['alamat', 'parent']) : null;
        if ($formulir) {
            return view('formulir.show', [
                'user' => $user,
                'formulir' => $formulir,
            ]);
        }

        return view('formulir', [
            'user' => $user,
            'formulir' => null,
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

        $dokumenUmumPaths = [];
        $dokumenFields = ['dokumen_ktp', 'dokumen_kk', 'dokumen_ijazah'];

        foreach ($dokumenFields as $field) {
            if ($request->hasFile($field)) {
                $dokumenUmumPaths[$field] = $request->file($field)->store('dokumen-umum', 'public');
            }
        }

        DB::transaction(function () use ($validatedData, $kipDocumentPath, $dokumenUmumPaths) {
            $formulirData = collect($validatedData)
                ->except(['dokumen_kip', 'no_kip', 'dokumen_ktp', 'dokumen_kk', 'dokumen_ijazah'])
                ->toArray();

            $createData = array_merge($formulirData, $dokumenUmumPaths, ['user_id' => Auth::id()]);

            $formulir = Formulir::create($createData);

            $formulir->alamat()->create($validatedData);
            $formulir->parent()->create($validatedData);

            if ($kipDocumentPath) {
                KipDocument::create([
                    'formulir_id' => $formulir->id,
                    'dokumen_path' => $kipDocumentPath,
                    'no_kip' => $validatedData['no_kip'],
                ]);
            }
        });

        return redirect()->route('dashboard')->with('status', 'formulir-berhasil-disimpan');
    }

    /**
     * Menampilkan halaman profil yang berisi data formulir untuk diedit.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        $formulir = $user->formulir()->with(['alamat', 'parent', 'kipDocument'])->first();
        if (! $formulir) {
            return redirect()->route('formulir.create')->with('info', 'Mohon lengkapi formulir pendaftaran Anda terlebih dahulu.');
        }

        $this->authorize('update', $formulir);

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
            if ($formulir->kipDocument && $formulir->kipDocument->dokumen_path) {
                Storage::disk('public')->delete($formulir->kipDocument->dokumen_path);
            }
            $kipDocumentPath = $request->file('dokumen_kip')->store('dokumen-kip', 'public');
            $formulir->kipDocument()->updateOrCreate(
                ['formulir_id' => $formulir->id],
                [
                    'dokumen_path' => $kipDocumentPath,
                    'no_kip' => $validatedData['no_kip'],
                ]
            );
        } elseif ($request->kategori_pendaftaran === 'Non-Reguler') {
            if ($formulir->kipDocument) {
                $formulir->kipDocument->update(['no_kip' => $validatedData['no_kip']]);
            }
        }

        DB::transaction(function () use ($formulir, $validatedData, $request) {
            $formulirData = collect($validatedData)
                ->except(['dokumen_kip', 'no_kip', 'dokumen_ktp', 'dokumen_kk', 'dokumen_ijazah'])
                ->toArray();

            $dokumenFields = ['dokumen_ktp', 'dokumen_kk', 'dokumen_ijazah'];

            foreach ($dokumenFields as $field) {
                if ($request->hasFile($field)) {
                    // Hapus file lama jika ada
                    if ($formulir->$field) {
                        Storage::disk('public')->delete($formulir->$field);
                    }
                    $formulirData[$field] = $request->file($field)->store('dokumen-umum', 'public');
                }
            }

            if ($formulir->status_pendaftaran === 'ditolak') {
                $formulirData['status_pendaftaran'] = 'menunggu_verifikasi';
                $formulirData['alasan_penolakan'] = null;
            }

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
            'nik' => [
                'required',
                'numeric',
                'digits:16',
                Rule::unique('formulirs', 'nik')->ignore(optional($request->user()->formulir)->id),
            ],
            'kategori_pendaftaran' => 'required|in:Reguler,Non-Reguler',
            'no_kip' => [
                Rule::requiredIf($request->kategori_pendaftaran === 'Non-Reguler'),
                'nullable',
                'numeric',
                'digits:14',
                Rule::unique('kip_documents', 'no_kip')->ignore(optional($request->user()->formulir?->kipDocument)->id),
            ],
            'asal_sd' => 'nullable|string|max:255',
            'tahun_lulus_sd' => 'nullable|date_format:Y|after_or_equal:1950|before_or_equal:'.date('Y'),
            'asal_smp' => 'nullable|string|max:255',
            'tahun_lulus_smp' => 'nullable|date_format:Y|after_or_equal:1950|before_or_equal:'.date('Y'),
            'asal_sma' => 'nullable|string|max:255',
            'tahun_lulus_sma' => 'nullable|date_format:Y|after_or_equal:1950|before_or_equal:'.date('Y'),
            'asal_universitas' => 'nullable|string|max:255',
            'jurusan' => ['required_with:asal_universitas', 'nullable', 'string', 'max:255'],
            'fakultas' => ['required_with:asal_universitas', 'nullable', 'string', 'max:255'],
            'semester' => ['required_with:asal_universitas', 'nullable', 'string', 'max:255'],
            'angkatan' => ['required_with:asal_universitas', 'nullable', 'string', 'max:255'],
            'negara' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa_kelurahan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'hubungan_keluarga' => 'required|string|max:255',

            'dokumen_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dokumen_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dokumen_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];

        $rules['dokumen_kip'] = $isUpdate
            ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
            : 'required_if:kategori_pendaftaran,Non-Reguler|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';

        return $request->validate($rules);
    }

    /**
     * Download dokumen pendukung (KTP, KK, Ijazah).
     */
    public function downloadDokumen($id, $type)
    {
        try {
            $formulir = Formulir::findOrFail($id);
            $filePath = null;

            // Tentukan file mana yang mau diambil
            switch ($type) {
                case 'ktp':
                    $filePath = $formulir->dokumen_ktp;
                    break;
                case 'kk':
                    $filePath = $formulir->dokumen_kk;
                    break;
                case 'ijazah':
                    $filePath = $formulir->dokumen_ijazah;
                    break;
                default:
                    return redirect()->back()->with('error', 'Jenis dokumen tidak valid.');
            }

            // Cek fisik file di storage
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                $absolutePath = Storage::disk('public')->path($filePath);

                return response()->download($absolutePath);
            }

            return redirect()->back()->with('error', 'File dokumen tidak ditemukan di server.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh dokumen.');
        }
    }
}
