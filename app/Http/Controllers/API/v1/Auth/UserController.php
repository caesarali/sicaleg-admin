<?php

namespace App\Http\Controllers\API\v1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Auth\RoleResource;

use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $page = $request->page;
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'superadmin');
        })->where('name', 'like', "%{$keyword}%")->orderBy('name', 'asc');
        $users = $page && $page > 0 ? $users->paginate() : $users->get();
        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|string|min:6|unique:users',
            'email' => 'required|string|min:6|unique:users',
            'password' => 'required|string|min:5',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole('admin');

        return (new UserResource($user))->additional(['message' => 'Akun baru berhasil dibuat.'], 200);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|string|min:6|unique:users,username,'.$user->id,
            'email' => 'required|string|min:6|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:5',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return (new UserResource($user))->additional(['message' => 'Perubahan disimpan.'], 200);
    }

    public function reset(User $user)
    {
        $user->update(['password' => $user->username]);
        return response()->json(['message' => 'Password di-reset. Password saat ini sama dengan username.'], 200);
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();
        return response()->json(['message' => "$name telah dihapus"]);
    }
}
