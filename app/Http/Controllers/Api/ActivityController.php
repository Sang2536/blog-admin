<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {

        // Lấy thông tin phân trang từ query
        $limit = $request->input('limit', 50);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        // Tổng số hoạt động
        $countActivities = Activity::whereNull('end_date')
            ->orWhereDate('end_date', '>=', now()->toDateString())
            ->count();

        $activities = Activity::with(['user', 'rewards', 'participants'])
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now()->toDateString());
            })
            ->orderByDesc('start_date')
            ->offset($offset)
            ->paginate($limit, ['*'], 'page', $page);;;

        $stats = [
            'activities' => $activities->count(),
            'event' => $activities->where('type', 'event')->count(),
            'competition' => $activities->where('type', 'competition')->count(),
            'survey' => $activities->where('type', 'survey')->count(),
        ];

        // Tạo meta
        $meta = [
            "total" => $countActivities,
            "per_page" => $limit,
            "current_page" => $page,
            "last_page" => ceil($countActivities / $limit),
        ];

        return ActivityResource::collection($activities)
            ->additional(['stats' => $stats, 'meta' => $meta]);;;
    }

    public function show($activity)
    {
        $activityFirst = Activity::with(['participants', 'user', 'rewards'])
            ->where('id', $activity)
            ->orWhere('slug', $activity)
            ->first();

        if (!$activityFirst) {
            return response()->json([
                'message' => 'Không có hoạt động.'
            ], 404);
        }

        $stats = [
            'participants' => $activityFirst->participants->count(),
        ];

        return (new ActivityResource($activityFirst))
            ->additional(['stats' => $stats]);
    }
}
