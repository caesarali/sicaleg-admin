<?php

namespace App\Http\Controllers\API\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = request()->user()->id;
        $profile = Volunteer::where('user_id', $userId)->firstOrFail();
        $profile->load('user.roles');

        $contribution = $profile->supporters->count();
        $supporters = DB::table('supporters')->count();

        $data['profile'] = $profile;
        $data['contribution'] = ($contribution / $supporters) * 100;
        $data['information'] = "$contribution Pendukung dari total $supporters.";

        return response()->json($data);
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $request->user()->id,
            'password' => 'required|string|min:5'
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $profile = Volunteer::where('user_id', $user->id)->firstOrFail();
        $profile->name = $user->name;
        $profile->save();
        $profile->load('user.roles');

        return response()->json(['data' => $profile, 'message' => 'Perubahan disimpan.'], 200);
    }
}
