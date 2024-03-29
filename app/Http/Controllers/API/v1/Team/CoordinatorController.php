<?php

namespace App\Http\Controllers\API\v1\Team;

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
        $page = $request->page;
        $keyword = $request->keyword;
        $coordinators = Volunteer::when($keyword, function($q, $keyword){
            return $q->where('name', 'like', "%$keyword%")->orWhere('nik', 'like', "%$keyword%");
        })
        ->with(['user', 'locationable'])
        ->withCount('supporters')
        ->where('locationable_type', '!=', VotingPlace::class);
        $coordinators = $page && $page > 0 ? $coordinators->paginate() : $coordinators->get();

        $roleList = ['district-co', 'village-co'];
        if (env('CALEG_LEVEL') == 'dpr') {
            $roleList[] = 'city-co';
        }
        $roles = Role::whereIn('name', $roleList)->get();
        $dapil = CandidateArea::all();

        return CoordinatorResource::collection($coordinators)->additional([
            'dapil' => DapilResource::collection($dapil),
            'roles' => RoleResource::collection($roles)
        ]);
    }

    public function store(CoordinatorRequest $request)
    {
        switch ($request->role) {
            case 'city-co':
                $request->validate([
                    'city_id' => 'required|integer'
                ]);
                $locationable = City::find($request->city_id);
                break;
            case 'district-co':
                $request->validate([
                    'district_id' => 'required|integer'
                ]);
                $locationable = District::find($request->district_id);
                break;
            case 'village-co':
                $request->validate([
                    'village_id' => 'required|integer'
                ]);
                $locationable = Village::find($request->village_id);
                break;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole($request->role);

        $request->merge([
            'user_id' => $user->id,
            'locationable_type' => get_class($locationable),
            'locationable_id' => $locationable->id
        ]);

        $coordinator = Volunteer::create($request->all());
        return (new CoordinatorResource($coordinator))->additional(['message' => 'Relawan ditambahkan.'], 200);
    }

    public function update(CoordinatorRequest $request, Volunteer $coordinator)
    {
        switch ($request->role) {
            case 'city-co':
                $request->validate([
                    'city_id' => 'required|integer'
                ]);
                $locationable = City::find($request->city_id);
                break;
            case 'district-co':
                $request->validate([
                    'district_id' => 'required|integer'
                ]);
                $locationable = District::find($request->district_id);
                break;
            case 'village-co':
                $request->validate([
                    'village_id' => 'required|integer'
                ]);
                $locationable = Village::find($request->village_id);
                break;
        }

        $request->merge([
            'locationable_type' => get_class($locationable),
            'locationable_id' => $locationable->id
        ]);

        $coordinator->update($request->all());
        $coordinator->user->update(['name' => $request->name]);
        $coordinator->user->syncRole($request->role);

        return (new CoordinatorResource($coordinator))->additional(['message' => 'Perubahan Disimpan.'], 200);
    }

    public function destroy(Volunteer $coordinator)
    {
        $coordinator->user->delete();
        $coordinator->delete();
        return response()->json(['message' => 'Data Relawan dihapus'], 200);
    }
}
