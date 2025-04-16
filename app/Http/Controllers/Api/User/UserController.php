<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->AllowInteraction()
            ->filter()
            ->orderBy('id', 'desc')
            ->fetch();
        return response()->json([
            'message' => 'Successully get all users',
            'data' => $users,
        ]);
    }

    public function show($id)
    {
        $user = User::with('roles')->find($id);
        return response()->json([
            'message' => 'Successully get user',
            'data' => $user
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->assignRole($data['role']);

        return response()->json([
            'message' => 'Successully create user',
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|string|max:255|unique:users,email,' . $id,
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        $data = $request->except('password');
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::find($id);
        $user->update($data);
        $user->syncRoles($data['role']);

        return response()->json([
            'message' => 'Successully update user',
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json([
            'message' => 'Successully delete user',
            'data' => $user
        ]);
    }
}
