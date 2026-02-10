<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'guru');

        if ($request->filled('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }

        $gurus = $query->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nip' => 'required|unique:users,nip',
            'status_kepegawaian' => 'required|in:pns,pppk,honor',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'status_kepegawaian' => $request->status_kepegawaian,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'nip' => 'required|unique:users,nip,' . $id,
            'status_kepegawaian' => 'required|in:pns,pppk,honor',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'status_kepegawaian' => $request->status_kepegawaian,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        
        // Prevent deleting own account if admin is also a guru (edge case)
        if ($guru->id === auth()->id()) {
            return redirect()->route('admin.guru.index')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil dihapus');
    }
}
