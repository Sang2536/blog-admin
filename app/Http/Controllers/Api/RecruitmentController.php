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
        $recruitments = Recruitment::with('user')
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->paginate(10);

        return RecruitmentResource::collection($recruitments);
    }

    // Lấy chi tiết một đợt tuyển dụng
    public function show(Recruitment $recruitment)
    {
        $recruitment->load(['user', 'applications']);

        return new RecruitmentResource($recruitment);
    }
}
