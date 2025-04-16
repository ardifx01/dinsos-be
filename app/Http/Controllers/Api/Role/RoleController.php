<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::allowInteraction()
            ->orderBy('id', 'desc')
            ->fetch();
        return response()->json([
            'message' => 'Successully get all roles',
            'data' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'required|string|max:255',
        ]);

        $role = Role::create($request->all());
        return response()->json([
            'message' => 'Successully create role',
            'data' => $role
        ]);
    }

    public function show($id)
    {
        $role = Role::find($id);
        return response()->json([
            'message' => 'Successully get role',
            'data' => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'guard_name' => 'required|string|max:255',
        ]);

        $role = Role::find($id)->update($request->all());
        return response()->json([
            'message' => 'Successully update role',
            'data' => $role
        ]);
    }

    public function destroy($id)
    {
        $role = Role::find($id)->delete();
        return response()->json([
            'message' => 'Successully delete role',
            'data' => $role
        ]);
    }
}
