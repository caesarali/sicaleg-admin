<?php

namespace App\Http\Controllers\API\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Auth\RoleResource;
use App\Http\Resources\Team\CoordinatorResource;
use App\Http\Resources\Team\DapilResource;

use App\Http\Requests\API\Team\CoordinatorRequest;

use App\Models\CandidateArea;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\VotingPlace;
use App\Models\Volunteer;
use App\Models\VolunteerLocation;
use App\Models\User;
use App\Models\Role;

class CoordinatorController extends Controller
{
    public function index(Request $request)
    {
        $coordinators = Volunteer::where('locationable_type', '!=', VotingPlace::class)->get();
        $dapil = CandidateArea::all();
        $roles = Role::where('name', '!=', 'superadmin')
                        ->where('name', '!=', 'admin')
                        ->where('name', '!=', 'province-co')
                        ->where('name', '!=', 'volunteer')
                        ->get();

        return CoordinatorResource::collection($coordinators)->additional([
            'dapil' => DapilResource::collection($dapil),
            'roles' => RoleResource::collection($roles)
        ]);
    }

    public function store(CoordinatorRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'nik' => 'required|numeric|digits:16',
            'phone' => 'required|numeric|digits_between:10,12',
            'information' => 'nullable|string',
            'username' =>  'required|string|min:6|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'city_id' => 'required|integer',
        ]);

        if ($request->role == 'district-co') {
            $request->validate(['district_id' => 'required|integer']);
        }

        if ($request->role == 'village-co') {
            $request->validate(['district_id' => 'required|integer']);
            $request->validate(['village_id' => 'required|integer']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole($request->role);

        switch ($request->role) {
            case 'city-co':
                $locationable = City::find($request->city_id);
                break;
            case 'district-co':
                $locationable = District::find($request->district_id);
                break;
            case 'village-co':
                $locationable = Village::find($request->village_id);
                break;
        }
        $request->request->add([
            'user_id' => $user->id,
            'locationable_type' => get_class($locationable),
            'locationable_id' => $locationable->id
        ]);
        $coordinator = Volunteer::create($request->all());
        return (new CoordinatorResource($coordinator))->additional(['message' => 'Relawan ditambahkan.'], 200);
    }

    public function update(Request $request, Volunteer $coordinator)
    {

    }

    public function destroy(Volunteer $coordinator)
    {

    }
}
