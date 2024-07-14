<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_name',
        'description',
        'category',
        'start_date',
        'finish_date',
        'start_time',
        'finish_time',
        'location',
        'contact_person',
        'registration_link',
        'status',
        'user_id',
        'poster_file_path',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function history()
    {
        return $this->hasMany(UserEventHistory::class, 'event_id');
    }
}
