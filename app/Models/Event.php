<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'organization_id',
        'title',
        'category',
        'description',
        'location',
        'event_date',
        'registration_deadline', // Status badge
        'registration_url',
        'poster_path',
    ];

    protected $casts = [
        'event_date' => 'date',
        'registration_deadline' => 'date',
        ];

    public const CATEGORIES = [
        'seminar_workshop' => 'Seminar, Pelatihan, dan Workshop',
        'lomba' => 'Lomba',
        'beasiswa_lainnya' => 'Beasiswa dan Lainnya',
        ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function statusPendaftaran(): string
    {
        $today = now()->startOfDay();
        $deadline = $this->registration_deadline->copy()->startOfDay();

        if ($deadline->lt($today)) {
            return 'closed';
        }

        if ($deadline->lte($today->copy()->addDays(3))) {
            return 'closing';
        }

        return 'open';
    }

    public function setTitleAttribute($value): void // Fitur revisi Bekti, untuk menghapus input spasi lebih
    {
        $this->attributes['title'] = preg_replace('/\s+/', ' ', trim($value));
    }
}
