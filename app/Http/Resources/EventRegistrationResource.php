<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventRegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'registration_id' => $this->registration_id,
            'user_id' => $this->user_id,
            'event_id' => $this->event_id,
            'registration_date' => $this->registration_date,
            'user' => new UserResource($this->whenLoaded('user')), // Jika Anda menggunakan UserResource
            'event' => new EventResource($this->whenLoaded('event')), // Jika Anda menggunakan EventResource
        ];
    }
}
