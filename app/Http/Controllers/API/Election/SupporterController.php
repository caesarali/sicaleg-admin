<?php

namespace App\Http\Controllers\API\Election;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supporter;
use App\Http\Resources\Election\SupporterResource;
use App\Models\VotingPlace;
use App\Models\CandidateArea;

class SupporterController extends Controller
{
    public function index(Request $request)
    {
        $chart = $request->chartBy;
        switch ($chart) {
            case 'age':
                return $this->chartByAge($request);

            case 'gender':
                return $this->chartByGender($request);

            default:
                $page = $request->page;
                $keyword = $request->keyword;
                $supporters = Supporter::with(['voter', 'createdBy'])->when($keyword, function($q, $keyword){
                    $q->whereHas('voter',function ($q) use ($keyword) {
                        return $q->where('name', 'like', "%{$keyword}%")->orWhere('nik', 'like', "%{$keyword}%");
                    });
                })->orderBy('created_at', 'desc');
                $supporters = $page && $page > 0 ? $supporters->paginate() : $supporters->get();
                return SupporterResource::collection($supporters);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['voter_id' => 'required|integer|unique:supporters,voter_id']);

        $supporter = Supporter::create($request->all());
        $supporter->load('voter');

        return response()->json([
            'message' => 'Pemilih ditambakan dalam daftar pendukung.',
            'data' => $supporter
        ], 200);
    }

    public function destroy(Request $request, Supporter $supporter)
    {
        $user = $request->user();
        if ($user->hasRole(['superadmin', 'admin']) || $supporter->created_by == $user->id) {
            $supporter->forceDelete();
            return response()->json(['message' => 'Pemilih dihilangkan dari daftar pendukung.'], 200);
        }
        return response()->json(['message' => 'Kamu tidak tidak memiliki akses untuk ini.'], 401);
    }

    private function chartByAge($request)
    {
        $supporters = Supporter::with(['voter'])->get();
        $supporters = $supporters->map(function ($item) {
            $voter = $item->voter;
            $voter['village_id'] = $voter->village->id;
            $voter['district_id'] = $voter->district->id;
            $voter['city_id'] = $voter->city->id;
            $voter['province_id'] = $voter->province->id;
            return $voter;
        });


        $dapil = CandidateArea::with(['locationable'])->get();
        $dapil = $dapil->map(function ($item) {
            return $item->locationable;
        });

        if ($request->key && $request->id) {
            $modelName = ucfirst(substr($request->key, 0, -3));
            $model = app("App\Models\\$modelName");
            $model = $model->where('id', $request->id)->first();
            $locations = $model->childs;
        } else {
            $locations = $dapil;
        }

        foreach ($locations as $item) {
            $data = $supporters->where($item->alias, $item->id);
            $datasets['labels'][] = $item->name;
            $datasets['young'][] = $data->where('age', '<=', 20)->count();
            $datasets['mid'][] = $data->where('age', '>', 20)->where('age', '<=', 40)->count();
            $datasets['old'][] = $data->where('age', '>', 40)->count();
        }

        $data = [
            'locations' => $dapil,
            'chart' => $datasets
        ];

        return response()->json($data);
    }

    private function chartByGender($request)
    {
        $supporters = Supporter::with(['voter'])->get();
        $supporters = $supporters->map(function ($item) {
            $voter = $item->voter;
            $voter['village_id'] = $voter->village->id;
            $voter['district_id'] = $voter->district->id;
            $voter['city_id'] = $voter->city->id;
            $voter['province_id'] = $voter->province->id;
            return $voter;
        });


        $dapil = CandidateArea::with(['locationable'])->get();
        $dapil = $dapil->map(function ($item) {
            return $item->locationable;
        });

        if ($request->key && $request->id) {
            $modelName = ucfirst(substr($request->key, 0, -3));
            $model = app("App\Models\\$modelName");
            $model = $model->where('id', $request->id)->first();
            $locations = $model->childs;
        } else {
            $locations = $dapil;
        }

        foreach ($locations as $item) {
            $data = $supporters->where($item->alias, $item->id);
            $datasets['labels'][] = $item->name;
            $datasets['male'][] = $data->where('gender', 'l')->count();
            $datasets['female'][] = $data->where('gender', 'p')->count();
        }

        $data = [
            'locations' => $dapil,
            'chart' => $datasets
        ];

        return response()->json($data);
    }
}
