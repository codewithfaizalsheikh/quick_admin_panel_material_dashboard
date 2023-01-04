<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    public $table = 'events';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'event_title',
        'event_category_id',
        'user_id',
        'start_date',
        'end_date',
        'event_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
}
