<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|min:3',
            'role' => 'nullable|in:' . implode(',', array_column(RoleEnum::cases(), 'value')),
        ]);

        $q = $request->query('q');
        $role = $request->query('role');

        $users = User::query()
            ->when($q, fn ($query, $q) => $query->where(
                fn ($orQuery) => $orQuery->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%")
            ))
            ->when($role, fn ($query, $role) => $query->where('role', $role))
            ->orderBy('id', 'desc')
            ->paginate(10)->withQueryString();

        return view('users.index', compact('users', 'q', 'role'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:' . implode(',', array_column(RoleEnum::cases(), 'value')),
        ]);

        $user = User::create($request->only('name', 'email', 'password', 'role'));

        return redirect()->route('users.show', ['user' => $user])->with('status', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', array_column(RoleEnum::cases(), 'value')),
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('users.show', ['user' => $user])->with('status', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('status', 'User deleted successfully.');
    }
}
