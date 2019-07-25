<?php

namespace App\Http\Controllers\API\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Election\SupporterResource;
use App\Models\Supporter;
use App\Models\Voter;
use App\Models\Village;

class SupporterController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->q;
        $page = $request->page;
        $supporters = Supporter::with(['voter.tps', 'createdBy'])->when($keyword, function($q, $keyword){
            $q->whereHas('voter',function ($q) use ($keyword) {
                return $q->where('name', 'like', "%{$keyword}%")->orWhere('nik', 'like', "%{$keyword}%");
            });
        })->orderBy('created_at', 'desc');
        $supporters = $page && $page > 0 ? $supporters->paginate() : $supporters->get();
        return SupporterResource::collection($supporters);
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $voter = Voter::where('nik', 'like', "%{$nik}%")->first();
        if ($voter) {
            Supporter::create([
                'voter_id' => $voter->id,
                'locationable_type' => Village::class,
                'locationable_id' => $voter->tps->village_id
            ]);
        }
        return response()->json(['data' => $voter, 'message' => 'Pemilih ditambahkan sebagai Pendukung.'], 200);
    }

    public function destroy(Request $request, Supporter $supporter)
    {
        $user = $request->user();
        if ($user->hasRole(['superadmin', 'admin']) || $supporter->created_by == $user->id) {
            $supporter->forceDelete();
            return response()->json(['message' => 'Data ini dihapus dari daftar Pendukung.'], 200);
        }
        return response()->json(['message' => 'Kamu tidak tidak memiliki akses untuk ini.'], 401);
    }

    public function monitor()
    {
        $supporters = Supporter::count();
        $voters = Voter::count();
        $data['supporters'] = $supporters;
        $data['target'] = round($voters * 20 / 100);
        return response()->json($data);
    }
}
