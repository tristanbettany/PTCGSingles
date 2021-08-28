<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OnHandCard extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'on_hand_cards';

    protected $fillable = [
        'released_card_version_id',
        'quantity',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function version()
    {
        return $this->belongsTo(ReleasedCardVersion::class);
    }
}
