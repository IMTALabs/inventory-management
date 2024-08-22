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
            ->paginate(5)->withQueryString();

        return view('users.index', compact('users', 'q', 'role'));
    }
}
