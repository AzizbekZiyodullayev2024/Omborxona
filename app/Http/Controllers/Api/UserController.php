<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::with('role')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password_hash' => 'required|string|min:8',
            'warehouse_id' => 'nullable|exists:warehouses,id',
        ]);

        $validated['password_hash'] = Hash::make($validated['password_hash']);
        $user = User::create($validated);
        return new UserResource($user->load('role'));
    }

    public function show(User $user)
    {
        return new UserResource($user->load('role'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'username' => 'required|string|unique:users,username,' . $user->id,
            ' email' => 'required|email|unique:users,email,' . $user->id,
            'password_hash' => 'nullable|string|min:8',
            'warehouse_id' => 'nullable|exists:warehouses,id',
        ]);

        if (isset($validated['password_hash'])) {
            $validated['password_hash'] = Hash::make($validated['password_hash']);
        } else {
            unset($validated['password_hash']);
        }

        $user->update($validated);
        return new UserResource($user->load('role'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}