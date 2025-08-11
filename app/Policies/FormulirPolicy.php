<?php

namespace App\Policies;

use App\Models\Formulir;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FormulirPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Formulir $formulir): bool
    {
        // Izinkan jika ID user sama dengan user_id di formulir, ATAU jika role user adalah 'admin'.
        return $user->id === $formulir->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Formulir $formulir): bool
    {
        // Izinkan update HANYA jika ID user sama dengan user_id di formulir.
        return $user->id === $formulir->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Formulir $formulir): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Formulir $formulir): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Formulir $formulir): bool
    {
        return false;
    }
}
