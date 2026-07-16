<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'all');

        $query = User::query();
        if ($role !== 'all') {
            $query->role($role);
        }

        $users = $query->withCount('orders')->latest()->paginate(15);

        return view('admin.users.index', compact('users', 'role'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => function ($q) {
            $q->with('service')->latest()->take(10);
        }, 'roles']);

        return view('admin.users.show', compact('user'));
    }
}
