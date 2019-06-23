<?php

namespace App\Http\Controllers\API\Auth;

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
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'superadmin');
        })->where('name', 'like', "%{$keyword}%")->orderBy('name', 'asc')->paginate(25);
        return UserResource::collection($users);
    }
}
