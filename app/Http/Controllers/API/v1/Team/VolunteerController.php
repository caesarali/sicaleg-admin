<?php

namespace App\Http\Controllers\API\v1\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Team\DapilResource;
use App\Http\Resources\Team\TpsResource;
use App\Http\Resources\Team\VolunteerResource;

use App\Models\CandidateArea;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\VotingPlace;
use App\Models\Volunteer;
use App\Models\VolunteerLocation;
use App\Models\User;
use App\Models\Supporter;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    public function index(Request $request)
    {
        $dapil = CandidateArea::all();

        if ($request->has('city_id')) {
            $dapil = District::where('city_id', $request->city_id)->get();
        }
        if ($request->has('district_id')) {
            $dapil = Village::where('district_id', $request->district_id)->get();
        }
        if ($request->has('village_id')) {
            $tps = VotingPlace::where('village_id', $request->village_id)->orderBy('name', 'asc')->get();
            $volunteers = Volunteer::whereIn('locationable_id', $tps->pluck('id'))->get();
            return VolunteerResource::collection($volunteers)->additional([
                'tps' => TpsResource::collection($tps)
            ]);
        }

        return DapilResource::collection($dapil);
    }

    public function store(Request $request)
    {
        $request->validate([
            'locationable_id' => 'required|integer',
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'nik' => 'required|numeric|digits:16',
            'phone' => 'required|numeric|digits_between:10,12',
            'information' => 'nullable|string',
            'username' =>  'required|string|min:6|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole('volunteer');

        $request->request->add([
            'locationable_type' => VotingPlace::class,
            'user_id' => $user->id
        ]);
        $volunteer = Volunteer::create($request->all());
        return (new VolunteerResource($volunteer))->additional(['message' => 'Relawan ditambahkan.'], 200);
    }

    public function show(Request $request, $id)
    {
        $volunteer = Volunteer::withCount('supporters')->where('id', $id)->orWhere('nik', $id)->firstOrFail();
        $supporters = DB::table('supporters')->count();
        $volunteer->load('locationable', 'user.role');
        $volunteer['contribution'] = ($volunteer->supporters_count / $supporters) * 100;
        $volunteer['others'] = $supporters - $volunteer->supporters_count;
        return response()->json($volunteer);
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $request->validate([
            'locationable_id' => 'required|integer',
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'nik' => 'required|numeric|digits:16',
            'phone' => 'required|numeric|digits_between:10,12',
            'information' => 'nullable|string',
        ]);
        $volunteer->update($request->all());
        $volunteer->user->update(['name' => $request->name]);
        return (new VolunteerResource($volunteer))->additional(['message' => 'Perubahan disimpan.'], 200);
    }

    public function destroy(Volunteer $volunteer)
    {
        $volunteer->user->delete();
        $volunteer->delete();
        return response()->json(['message', 'Data Pemilih dihapus'], 200);
    }
}
