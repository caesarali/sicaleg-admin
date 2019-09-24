<?php

namespace App\Http\Controllers\API\v2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;
use App\Http\Resources\Election\SupporterResource;
use App\Notifications\ContributionNotification;
use App\Models\Supporter;
use App\Models\Voter;
use App\Models\Village;
use App\Models\User;

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
        $supporters = $page && $page > 0 ? $supporters->paginate(50) : $supporters->get();
        return SupporterResource::collection($supporters);
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $voter = Voter::where('nik', 'like', "%$nik%")->firstOrFail();
        if ($voter && !$voter->is_supporter) {
            $user = $request->user();
            $users = User::whereHas('role', function ($query) {
                $query->where('name', 'superadmin')->orWhere('name', 'admin');
            })->get();
            Supporter::create([
                'voter_id' => $voter->id,
                'locationable_type' => Village::class,
                'locationable_id' => $voter->tps->village_id
            ]);
            Notification::send($users, new ContributionNotification($voter, $user));
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
        $data = [
            'supporters' => $supporters,
            'target' => [
                'total' => round($voters * 20 / 100),
                'percent' => 20
            ]
        ];
        return response()->json($data);
    }
}
