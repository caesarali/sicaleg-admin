<?php

namespace App\Http\Controllers\API\v1\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Candidate\ProfileResource as CandidateResource;

use App\Models\Candidate;
use Indonesia;

class ProfileController extends Controller
{
    public function index()
    {
        $candidate = Candidate::all()->first();
        $locations = $candidate->level == 'dpr' ? Indonesia::allProvinces() : Indonesia::allCities();
        return (new CandidateResource($candidate))->additional([
            'locations' => $locations
        ]);
    }

    public function update(Request $request, Candidate $profile)
    {
        $profile->update($request->all());
        return (new CandidateResource($profile))->additional(['message' => 'Profile diperbarui.'], 200);
    }
}
