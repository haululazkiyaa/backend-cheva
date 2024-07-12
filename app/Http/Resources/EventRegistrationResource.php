<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventRegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->registration_id,
            'user_id' => $this->user_id,
            'event_id' => $this->event_id,
            'registration_date' => $this->registration_date,
        ];
    }
}
