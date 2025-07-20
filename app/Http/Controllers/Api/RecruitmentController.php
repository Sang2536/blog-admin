<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Http\Resources\RecruitmentResource;

class RecruitmentController extends Controller
{
    // Lấy danh sách tuyển dụng đang active (phân trang)
    public function index()
    {
        $recruitments = Recruitment::with('user', 'applications')
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->get();

        $stats =[
            'recruitments' => $recruitments->count(),
            'active' => $recruitments->where('is_active', true)->count(),
            'inactive' => $recruitments->count() - $recruitments->where('is_active', true)->count(),

        ];

        return RecruitmentResource::collection($recruitments)
            ->additional(['stats' => $stats]);
    }

    // Lấy chi tiết một đợt tuyển dụng
    public function show($recruitment)
    {
        $recruitmentFirst = Recruitment::with(['user', 'applications'])
            ->where('id', $recruitment)
            ->orWhere('slug', $recruitment)
            ->first();

        if (!$recruitmentFirst) {
            return response()->json([
                'message' => 'Tuyển dụng này không tồn tại.'
            ], 404);
        }

        $stats =[
            'apply_total' => $recruitmentFirst->applications->count(),
            'rejected' => $recruitmentFirst->applications->where('status', 'rejected')->count(),
            'accepted' => $recruitmentFirst->applications->where('status', 'accepted')->count(),
            'pending' => $recruitmentFirst->applications->where('status', 'pending')->count(),
        ];

        return (new RecruitmentResource($recruitment))
            ->additional(['stats' => $stats]);
    }
}
