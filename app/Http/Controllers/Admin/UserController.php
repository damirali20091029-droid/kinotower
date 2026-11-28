<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'active');

        $query = User::with('gender');

        if ($status === 'deleted') {
            $query->onlyTrashed();
        } elseif ($status === 'all') {
            $query->withTrashed();
        }

        $users = $query->orderBy('id')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'status'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Пользователь удалён');
    }

    public function restore(User $user)
    {
        $user->restore();

        return back()->with('success', 'Пользователь восстановлен');
    }
}