<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReleasedCardVersion extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'released_card_versions';

    protected $fillable = [
        'released_card_id',
        'is_standard',
        'is_reverse_holo',
        'value',
        'quantity',
    ];

    protected $casts = [
        'is_standard' => 'boolean',
        'is_reverse_holo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function releasedCard()
    {
        return $this->belongsTo(ReleasedCard::class, 'released_card_id');
    }
}
