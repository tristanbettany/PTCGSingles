<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Set extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'sets';

    protected $fillable = [
        'name',
        'series',
        'release_date',
        'base_card_count',
        'secret_card_count',
        'symbol',
        'logo',
        'data_source_url',
        'series_id',
    ];

    protected $casts = [
        'release_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function releasedCards()
    {
        return $this->hasMany(ReleasedCard::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
