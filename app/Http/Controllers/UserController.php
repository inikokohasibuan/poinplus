<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lokasi = Lokasi::all();
        return view('user.create', compact('lokasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'level' => 'required|in:admin,owner,penjaga_toko',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'level' => $request->level,
    ]);

    return redirect()->route('user.index')->with('success', 'User created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $lokasi = Lokasi::all();
        return view('user.edit', compact('user', 'lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Mengabaikan unique constraint untuk user saat ini
            'password' => 'nullable|string|min:8|confirmed',
            'level' => 'required|in:admin,owner,penjaga_toko',
            'id_lokasi' => 'required_if:level,penjaga_toko|exists:lokasi,id_lokasi', // Validasi id_lokasi jika level = penjaga_toko
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;

        // Jika level adalah 'penjaga_toko', simpan id_lokasi
        if ($request->level === 'penjaga_toko') {
            $user->id_lokasi = $request->id_lokasi;
        } else {
            // Jika bukan penjaga_toko, id_lokasi di-null-kan (opsional tergantung kebutuhan)
            $user->id_lokasi = null;
        }

        // Jika password diisi, maka lakukan hash dan simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

        // Redirect ke halaman index user dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
