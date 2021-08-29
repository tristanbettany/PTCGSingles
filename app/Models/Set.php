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

    public function value(): float
    {
        $value = 00.00;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                $value += $version->value;
            }
        }

        return $value;
    }

    public function onHandValue(): float
    {
        $value = 00.00;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if ($version->quantity() > 0) {
                    $value += ($version->value * $version->quantity());
                }
            }
        }

        return $value;
    }

    public function duplicatesValue(): float
    {
        $value = 00.00;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if ($version->quantity() > 1) {
                    $value += ($version->value * ($version->quantity() - 1));
                }
            }
        }

        return $value;
    }

    public function missingValues(): int
    {
        $missing = 0;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if (empty($version->value) === true) {
                    $missing++;
                }
            }
        }

        return $missing;
    }

    public function missingStock(): int
    {
        $missing = 0;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if ($version->quantity() < 1) {
                    $missing++;
                }
            }
        }

        return $missing;
    }

    public function withStock(): int
    {
        $notMissing = 0;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if ($version->quantity() > 0) {
                    $notMissing++;
                }
            }
        }

        return $notMissing;
    }

    public function withDuplicates(): int
    {
        $duplicates = 0;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if ($version->quantity() > 1) {
                    $duplicates++;
                }
            }
        }

        return $duplicates;
    }

    public function totalOnHand(): int
    {
        $onHand = 0;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if ($version->quantity() > 0) {
                    $onHand += $version->quantity();
                }
            }
        }

        return $onHand;
    }

    public function totalDuplicates(): int
    {
        $duplicates = 0;
        foreach ($this->releasedCards as $card) {
            foreach ($card->versions as $version) {
                if ($version->quantity() > 1) {
                    $duplicates += ($version->quantity() - 1);
                }
            }
        }

        return $duplicates;
    }
}
