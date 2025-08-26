<?php

namespace App\Traits;

use App\Models\FormulirLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsChanges
{
    /**
     * Boot the trait.
     * Secara otomatis mendaftarkan event listener saat model di-boot.
     */
    public static function bootLogsChanges()
    {
        static::updating(function (Model $model) {
            // Hanya jalankan jika ada user yang login (untuk menghindari error di seeder/tinker)
            if (! Auth::check()) {
                return;
            }

            // Dapatkan ID formulir utama
            // Jika model ini adalah Formulir, gunakan ID-nya.
            // Jika model ini adalah Alamat/ParentData, gunakan formulir_id-nya.
            $formulirId = $model->formulir_id ?? $model->id;

            // Loop melalui setiap field yang berubah
            foreach ($model->getDirty() as $field => $newValue) {
                // Abaikan kolom 'updated_at' agar tidak ikut tercatat
                if ($field === 'updated_at') {
                    continue;
                }

                $oldValue = $model->getOriginal($field);

                // Simpan ke tabel formulir_logs
                FormulirLog::create([
                    'formulir_id' => $formulirId,
                    'user_id' => Auth::id(),
                    'field_name' => class_basename($model).'->'.$field, // e.g., "Alamat->provinsi"
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'edited_at' => now(),
                ]);
            }
        });
    }
}
