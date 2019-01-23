<?php

namespace App\Http\Controllers\API\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Candidate\ProfileResource as CandidateResource;

use App\Models\Candidate;

class ProfileController extends Controller
{
    public function index()
    {
        $candidate = Candidate::all()->first();
        return new CandidateResource($candidate);
    }

    public function update(Request $request, Candidate $profile)
    {
        $profile->update($request->all());
        return (new CandidateResource($profile))->additional(['message' => 'Profile diperbarui.'], 200);
    }
}
