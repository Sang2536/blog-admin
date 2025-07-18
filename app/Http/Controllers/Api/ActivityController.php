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

        return ActivityResource::collection($activities);
    }

    public function show(Activity $activity)
    {
        $activity->load(['user', 'rewards', 'participants']);
        return new ActivityResource($activity);
    }
}
