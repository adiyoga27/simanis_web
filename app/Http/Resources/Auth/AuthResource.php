<?php

namespace App\Http\Resources\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AuthResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'token_type' => 'Bearer',
            'access_token' => $this->token->plainTextToken,
            'avatar' => $this->avatar? url(Storage::url($this->avatar)) : null,
            'expires_at' => Carbon::parse($this->token->accessToken?->expires_at)->toDateTimeString(),  
        ];
    }
}
