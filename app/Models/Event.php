<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'category',
        'description',
        'location',
        'event_date',
        'registration_url',
        'poster_path',
    ];

    protected $casts = ['event_date' => 'date'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
