<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $take = $request->query('take', 10);
        $skip = $request->query('skip', 0);
        $search = $request->query('search', '');
        $withTrashed = $request->query('with_trashed', false);

        $query = User::where('name', 'like', "%{$search}%");

        if ($withTrashed) {
            $query = $query->withTrashed();
        }

        $users = $query->skip($skip)->take($take)->get();

        return response()->json([
            'code' => 200,
            'message' => 'User list retrieved successfully',
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return response()->json([
            'code' => 201,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User not found',
                'data' => null
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'User retrieved successfully',
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User not found',
                'data' => null
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'string|min:6',
            'role' => 'in:admin,user'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ]);
        }

        $user->update($request->all());

        return response()->json([
            'code' => 200,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User not found',
                'data' => null
            ]);
        }

        $user->delete();

        return response()->json([
            'code' => 200,
            'message' => 'User deleted successfully',
            'data' => null
        ]);
    }

    public function restore(string $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User not found',
                'data' => null
            ]);
        }

        $user->restore();

        return response()->json([
            'code' => 200,
            'message' => 'User restored successfully',
            'data' => $user
        ]);
    }

    public function forceDelete(string $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User not found',
                'data' => null
            ]);
        }

        $user->forceDelete();

        return response()->json([
            'code' => 200,
            'message' => 'User permanently deleted',
            'data' => null
        ]);
    }
}
