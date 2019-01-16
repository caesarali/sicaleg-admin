<?php

namespace App\Http\Controllers\API\Laravolt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Indonesia;

class ProvinceController extends Controller
{
    public function index()
    {
        return Indonesia::allProvinces();
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
