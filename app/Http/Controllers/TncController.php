<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TncController extends Controller
{
    /**
     * Handle user acceptance of Terms and Conditions.
     */
    public function accept(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user) {
            // Tandai bahwa user telah menyetujui T&C dengan mencatat waktu saat ini
            $user->accepted_tnc_at = now();
            $user->save();
        }

        // Arahkan kembali ke halaman pembayaran
        return redirect()->route('payment.create');
    }
}
