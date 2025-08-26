<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai query builder
        $query = User::query();

        // 1. Proses Filter Pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('email', 'like', '%'.$searchTerm.'%');
            });
        }

        // 2. Proses Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // 3. Proses Filter Status
        if ($request->filled('status')) {
            if ($request->input('status') == 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->input('status') == 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // 4. Proses Filter Sorting
        if ($request->filled('sort')) {
            $sortOption = $request->input('sort');
            switch ($sortOption) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                    // -- OPSI BARU DITAMBAHKAN DI SINI --
                case 'id_asc':
                    $query->orderBy('id', 'asc');
                    break;
                case 'id_desc':
                    $query->orderBy('id', 'desc');
                    break;
                    // -- AKHIR PENAMBAHAN --
                    // case 'date_desc' ditangani oleh default
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting jika tidak ada pilihan
            $query->latest(); // Sama dengan orderBy('created_at', 'desc')
        }

        // Eksekusi query dengan pagination
        $users = $query->paginate(10);

        // Tambahkan parameter filter ke link pagination
        $users->appends($request->query());

        return view('admin.management-users', compact('users'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telp' => ['required', 'numeric', 'digits_between:10,15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'role' => 'calon_mahasiswa',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.management-users')->with('success', 'Pengguna berhasil ditambahkan.');
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Cek apakah user yang akan dihapus bukan admin yang sedang login
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.management-users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.management-users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
