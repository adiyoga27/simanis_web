<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeDietResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'time_id' => $this->id,
            'diet_id' => (int) $this->diet_id,
            'title' => $this->title,
            'food' => FoodResource::collection($this->food)
        ];
    }
}
