<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PartyResource as Resource;

use App\Models\Party;

class PartyController extends Controller
{
    public function index()
    {
        $party = Party::all()->first();
        return new Resource($party);
    }

    public function update(Request $request, Party $party)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'fullname' => 'required|string',
            'number' => 'required|integer',
        ]);

        $party->update($request->all());
        return (new Resource($party))->additional(['message' => 'Partai diperbarui.'], 200);
    }
}
