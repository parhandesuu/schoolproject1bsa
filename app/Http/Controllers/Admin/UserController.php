<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('users.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola pengguna.');
        }

        $query = User::with('roles');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->can('users.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah pengguna.');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('users.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah pengguna.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => 'required|in:admin,editor,staff',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        $user = User::create($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dibuat.');
    }

    public function show(User $user)
    {
        if (!auth()->user()->can('users.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat pengguna.');
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->can('users.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah pengguna.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->can('users.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah pengguna.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role'     => 'required|in:admin,editor,staff',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->can('users.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus pengguna.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }
}
