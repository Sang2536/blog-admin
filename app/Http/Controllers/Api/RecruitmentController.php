<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Http\Resources\RecruitmentResource;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    // Lấy danh sách tuyển dụng đang active (phân trang)
    public function index(Request $request)
    {

        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 20);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        //  Tổng số recruitment

        $countRecruitments = Recruitment::with('user', 'applications')
            ->where('is_active', true)
            ->count();

        $recruitments = Recruitment::with('user', 'applications')
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->latest()
            ->paginate(20);

        $stats = [
            'recruitments' => $recruitments->count(),
            'active' => $recruitments->where('is_active', true)->count(),
            'inactive' => $recruitments->count() - $recruitments->where('is_active', true)->count(),
        ];

        // Tạo meta
        $meta = [
            "total" => $countRecruitments,
            "per_page" => $limit,
            "current_page" => $page,
            "last_page" => ceil($countRecruitments / $limit),
        ];


        return RecruitmentResource::collection($recruitments)
            ->additional(['stats' => $stats, 'meta' => $meta]);;
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

        $stats = [
            'apply_total' => $recruitmentFirst->applications->count(),
            'rejected' => $recruitmentFirst->applications->where('status', 'rejected')->count(),
            'accepted' => $recruitmentFirst->applications->where('status', 'accepted')->count(),
            'pending' => $recruitmentFirst->applications->where('status', 'pending')->count(),
        ];

        return (new RecruitmentResource($recruitment))
            ->additional(['stats' => $stats]);
    }
}
