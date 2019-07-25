<?php

namespace App\Http\Controllers\API\v1\Election;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supporter;
use App\Http\Resources\Election\SupporterResource;
use App\Models\VotingPlace;
use App\Models\CandidateArea;
use Illuminate\Support\Facades\DB;

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
                $supporters = Supporter::with(['voter.tps', 'createdBy'])->when($keyword, function($q, $keyword){
                    $q->whereHas('voter',function ($q) use ($keyword) {
                        return $q->where('name', 'like', "%{$keyword}%")->orWhere('nik', 'like', "%{$keyword}%");
                    });
                })->orderBy('created_at', 'desc');
                $supporters = $page && $page > 0 ? $supporters->paginate() : $supporters->get();
                return SupporterResource::collection($supporters);
        }
    }

    public function destroy(Request $request, Supporter $supporter)
    {
        $user = $request->user();
        if ($user->hasRole(['superadmin', 'admin']) || $supporter->created_by == $user->id) {
            $supporter->forceDelete();
            return response()->json(['message' => 'Pemilih dihapus dari daftar pendukung.'], 200);
        }
        return response()->json(['message' => 'Kamu tidak tidak memiliki akses untuk ini.'], 401);
    }

    private function chartByAge($request)
    {
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
            $data = Supporter::where('locationable_id', 'LIKE', "%$item->id%")->with(['voter'])->get();
            $data = $data->map(function ($item) {
                return $item->voter;
            });
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
            $data = Supporter::where('locationable_id', 'LIKE', "%$item->id%")->with(['voter'])->get();
            $data = $data->map(function ($item) {
                return $item->voter;
            });
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
