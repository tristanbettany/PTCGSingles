<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReleasedCard extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'released_cards';

    protected $fillable = [
        'set_id',
        'rarity_id',
        'type_id',
        'number',
        'image',
        'in_hand_quantity',
        'tradeable_quantity',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function set()
    {
        return $this->belongsTo(Set::class, 'set_id');
    }

    public function rarity()
    {
        return $this->hasOne(Rarity::class, 'rarity_id');
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'type_id');
    }
}
