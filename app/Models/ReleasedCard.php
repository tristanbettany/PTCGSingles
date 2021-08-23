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
        'number',
        'image',
        'data_source_url',
        'name',
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

    public function paddedNumber(): string
    {
        return str_pad($this->number, 3, "00", STR_PAD_LEFT);
    }

    public function versions()
    {
        return $this->hasMany(ReleasedCardVersion::class);
    }
}
