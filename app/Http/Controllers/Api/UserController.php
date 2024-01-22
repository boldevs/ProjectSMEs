<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['roles'])->where(function ($query) use ($request) {
            if (isset($query->id)) {
                $query->where('id', $request->id);
            }
            if (isset($request->name))
            {
                $query->where('name', 'like', $request->name);
            }
            if (isset($query->email)) {
                $query->where('email', 'like', $request->name);
            }
        })->get();

        if ($users->count() > 0) {
            return response()->json([
                'status' => '200',
                'users' => $users
            ]);
        }

        return response()->json([
            'status' => '404',
            'users' => 'No Record Fonud!'
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (isset($request->role)) {
            $user->assignRole($request->role);
        }

        if (isset($user)) {
            return response()->json([
                'status' => '200',
                'messages' => 'User Created Successfully!'
            ], 200);
        }

        return response()->json([
            'status' => '500',
            'messages' => 'Something went wrong!'
        ], 500);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();

        if (isset($user)) {
            return response()->json([
                'status' => '200',
                'user' => $user
            ], 200);
        }

        return response()->json([
            'status' => '500',
            'messages' => 'Something went wrong!'
        ], 500);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:users,name,' . $id],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        }

        $user = User::where('id', $id)->first();

        if (!isset($user)) {
            return response()->json([
                'status' => '404',
                'users' => 'No Record Fonud!'
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $user->roles()->detach();
        if (isset($request->role)) {
            $user->assignRole($request->role);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User updated successfully!',
            'user' => $user // Optionally, you can return the updated item
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => '200',
                'messages' => 'User Deleted Successfully!'
            ], 200);
        }
        return response()->json([
            'status' => '404',
            'purchases' => 'No Record Fonud!'
        ]);
    }
}
