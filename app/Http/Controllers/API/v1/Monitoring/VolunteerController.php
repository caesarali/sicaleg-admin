<?php

namespace App\Http\Controllers\API\v1\Monitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supporter;
use App\Models\Volunteer;
use App\Http\Resources\Monitoring\LastAcitivitiesResource;
use App\Models\Voter;

class VolunteerController extends Controller
{
    public function index()
    {
        $voter = Voter::count();
        $supporters = Supporter::count();
        $volunteers = Volunteer::withCount('supporters')->orderBy('supporters_count', 'desc')->get();
        $volunteers->load('locationable', 'user.roles');
        $data['top_volunteers'] = $volunteers->where('supporters_count', '>', 0)->take(5);
        $data['total_volunteers'] = $volunteers->count();
        $data['uncontributed_volunteers'] = $volunteers->where('supporters_count', 0)->count();
        $data['total_supporters'] = $supporters;
        $data['target_supporters'] = round($voter * 20 / 100);
        return response()->json($data);
    }

    public function activities(Request $request)
    {
        $page = $request->page;
        if ($request->user) {
            $volunteer = Volunteer::where('id', $request->user)->orWhere('nik', $request->user)->firstOrFail();
        } else {
            $volunteer = null;
        }
        $lastActivities = Supporter::when($volunteer,  function($q, $volunteer) {
            $q->where('created_by', $volunteer->user_id);
        })->with(['createdBy.volunteer.locationable', 'voter']);
        $lastActivities = $page && $page > 0 ? $lastActivities->paginate(10) : $lastActivities->get();

        return LastAcitivitiesResource::collection($lastActivities);
    }

    public function topVolunteers()
    {
        $volunteers = Volunteer::whereHas('supporters')->withCount('supporters')->orderBy('supporters_count', 'desc')->take(5)->get();
        $volunteers->load('locationable', 'user.roles');
        return response()->json($volunteers);
    }
}
