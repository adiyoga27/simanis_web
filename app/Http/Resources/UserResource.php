<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'username' => $this->username,
            'role' => $this->role,
            'avatar' => $this->avatar,
            'birthdate' => $this->birthdate,
            'phone' => $this->phone,
            'jk' => $this->jk,
            'is_smoke' => $this->is_smoke,
            'medical_history' => $this->medical_history,
            'province' => $this->province,
            'city' => $this->city,
            'subdistrict' => $this->subdistrict,
            'village' => $this->village,
            'address' => $this->address,
            'kode_pos' => $this->kode_pos,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
          
        ];
    }

   
}
