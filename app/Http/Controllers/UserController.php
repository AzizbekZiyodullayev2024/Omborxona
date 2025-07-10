<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }
    public function show($id)
    {
        $user = User::with('role')->find($id);
        if (!$user) {
            return response()->json(['message' => 'Foydalanuvchi topilmadi'], 404);
        }
        return response()->json($user);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password_hash' => 'required|string|min:6',
        ]);

        $user = User::create($validatedData);
        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Foydalanuvchi topilmadi'], 404);
        }
        $validatedData = $request->validate([
            'role_id' => 'sometimes|required|exists:roles,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $id,
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password_hash' => 'sometimes|required|string|min:6',
        ]);

        $user->update($validatedData);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Foydalanuvchi topilmadi'], 404);
        }
        $user->delete();
        return response()->json(null, 204);
    }
}
