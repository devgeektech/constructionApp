<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StoreResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'owner' => $this->owner,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'logo' => asset('storage/images/' .$this->logo),
            'banner' => asset('storage/images/' .$this->banner),
            'phone' => $this->phone,
            'social_links' => $this->social_links
        ];
    }
}
