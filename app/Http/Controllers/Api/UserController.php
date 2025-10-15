<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Simulasi data pengguna (in-memory)
    private $users = [
        ['id' => 1, 'name' => 'Alif', 'email' => 'alif@example.com'],
        ['id' => 2, 'name' => 'Naufal', 'email' => 'naufal@example.com'],
        ['id' => 3, 'name' => 'Maulana', 'email' => 'maulana@example.com'],
    ];

    // GET /api/users
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Daftar Pengguna',
            'data' => $this->users
        ]);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = collect($this->users)->firstWhere('id', $id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Pengguna',
            'data' => $user
        ]);
    }

    // POST /api/users
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email'
        ]);

        // Buat ID baru
        $newId = count($this->users) + 1;

        $newUser = [
            'id' => $newId,
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Simulasikan penambahan ke array (tidak persist)
        $this->users[] = $newUser;

        return response()->json([
            'success' => true,
            'message' => 'Data User berhasil ditambahkan',
            'data' => $newUser
        ], 201);
    }
}
