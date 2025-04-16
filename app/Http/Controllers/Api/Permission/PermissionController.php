<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::allowInteraction()->orderBy('id', 'desc')->fetch();
        return response()->json([
            'message' => 'Successully get all permissions',
            'data' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
        ]);

        $permission = Permission::create($request->all());
        return response()->json([
            'message' => 'Successully create permission',
            'data' => $permission
        ]);
    }

    public function show($id)
    {
        $permission = Permission::find($id);
        return response()->json([
            'message' => 'Successully get permission',
            'data' => $permission
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'guard_name' => 'required|string|max:255',
        ]);

        $permission = Permission::find($id)->update($request->all());
        return response()->json([
            'message' => 'Successully update permission',
            'data' => $permission
        ]);
    }

    public function destroy($id)
    {
        $permission = Permission::find($id)->delete();
        return response()->json([
            'message' => 'Successully delete permission',
            'data' => $permission
        ]);
    }
}
