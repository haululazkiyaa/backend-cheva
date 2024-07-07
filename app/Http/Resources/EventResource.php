<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->event_id,
            'name' => $this->event_name,
            'description' => $this->description,
            'category' => $this->category,
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'start_time' => $this->start_time,
            'finish_time' => $this->finish_time,
            'location' => $this->location,
            'contact_person' => $this->contact_person,
            'poster_file_path' => $this->poster_file_path,
            'registration_link' => $this->registration_link,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ];
    }
}
