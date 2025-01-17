<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'food_id' => $this->id,
            'time_id' => (int) $this->time_id,
            'material' => $this->material,
            'unit' => $this->unit,
            'menu' => $this->menu

        ];
    }
}
