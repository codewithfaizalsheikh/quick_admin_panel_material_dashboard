<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventDetail extends Model
{
    use SoftDeletes;

    public $table = 'event_details';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'event_id',
        'featured_image',
        'event_description',
        'event_info',
        'short_desc',
        'event_price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
}
