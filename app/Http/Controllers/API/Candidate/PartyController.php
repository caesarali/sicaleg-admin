<?php

namespace App\Http\Controllers\API\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Candidate\PartyResource;
use App\Models\Party;

class PartyController extends Controller
{
    public function index()
    {
        $party = Party::all()->first();
        return new PartyResource($party);
    }

    public function update(Request $request, Party $party)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'fullname' => 'required|string',
            'number' => 'required|integer',
        ]);

        $party->update($request->all());
        return (new PartyResource($party))->additional(['message' => 'Partai diperbarui.'], 200);
    }
}
