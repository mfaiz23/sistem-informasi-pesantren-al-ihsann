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
                        \DB::transaction(function () use ($user, $pending, $resp, $paymentType) {
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

                            // Tutup pending lain (sisa race)
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
            'nik' => 'required|numeric|digits:16',
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

            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'hubungan_keluarga' => 'required|string|max:255',
        ];

        $rules['dokumen_kip'] = $isUpdate
            ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
            : 'required_if:kategori_pendaftaran,Non-Reguler|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';

        return $request->validate($rules);
    }
}
