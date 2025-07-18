<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'link' => $this->link,
            'location' => $this->location,
            'start_date' => $this->start_date?->toDateString(),
            'end_date' => $this->end_date?->toDateString(),
            'deadline' => $this->deadline?->toDateString(),
            'description' => $this->description,
            'author' => new AuthorResource($this->whenLoaded('user')),
            'rewards' => RewardResource::collection($this->whenLoaded('rewards')),
            'participants' => ParticipantResource::collection($this->whenLoaded('participants')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
