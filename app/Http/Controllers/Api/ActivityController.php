<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['user', 'rewards', 'participants'])
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now()->toDateString());
            })
            ->latest()
            ->get();

        $stats = [
            'activities' => $activities->count(),
            'event' => $activities->where('type', 'event')->count(),
            'competition' => $activities->where('type', 'competition')->count(),
            'survey' => $activities->where('type', 'survey')->count(),
        ];

        return ActivityResource::collection($activities)
            ->additional(['stats' => $stats]);
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
