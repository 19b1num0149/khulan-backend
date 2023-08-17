<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Event_Itinenary extends Model
{
    use HasFactory;

    protected $table = 'group_event_itineraries';

    protected $fillable = [
        'event_id',
        'description',
        'title',
    ];

    public function event(){
        return $this->belongsTo(Group_and_Event::class);
    }

}
