<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Province;
use App\Models\City;
use App\Models\Candidate;
use App\Models\CandidateArea;
use App\Models\Group;

use Indonesia;

class HomeController extends Controller
{
    protected $level;

    public function __construct()
    {
        $this->level = env('CALEG_LEVEL', 'dpr');
        $this->middleware('auth');
        $this->middleware('installed')->only('index');
    }

    public function index()
    {
        return view('home');
    }

    public function setup()
    {
        $candidate = Candidate::all()->first();
        if (!$candidate) {
            $locations = $this->level == 'dpr' ? Indonesia::allProvinces() : Indonesia::allCities();
            return view('preinstall.caleg', compact('locations'));
        }

        $areas = CandidateArea::all();
        if ($areas->count() <= 0) {
            $locations = $candidate->locationable->childs;
            return view('preinstall.dapil', compact('locations'));
        }

        return redirect()->route('home');
    }
}
