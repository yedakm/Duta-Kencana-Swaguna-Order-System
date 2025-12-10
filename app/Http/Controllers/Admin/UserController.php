<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'member')->withCount('orders')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'member') {
            abort(404);
        }

        $orders = $user->orders()->latest()->get();
        return view('admin.users.show', compact('user', 'orders'));
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'member') {
            abort(403);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
