<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'full_name'   => $this->full_name,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'cv_url'      => $this->cv_path ? asset('storage/' . $this->cv_path) : null,
            'cover_letter'=> $this->cover_letter,
            'status'      => $this->status,
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
