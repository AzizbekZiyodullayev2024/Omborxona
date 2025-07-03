<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Rol topilmadi'], 404);
        }
        return response()->json($role);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'nullable',
        ]);

        $role = Role::create($validatedData);
        return response()->json($role, 201);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Rol topilmadi'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|unique:roles,name,' . $id,
            'description' => 'nullable',
        ]);

        $role->update($validatedData);
        return response()->json($role);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Rol topilmadi'], 404);
        }
        $role->delete();
        return response()->json(null, 204);
    }
}
