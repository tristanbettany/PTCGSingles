<?php

namespace App\Services;

use App\CSV;
use App\Interfaces\SetServiceInterface;
use App\Models\ReleasedCardVersion;
use App\Models\Set;
use Illuminate\Support\Collection;
use DateTimeImmutable;

final class SetService extends AbstractService implements SetServiceInterface
{
    public const NONE = 'None';
    public const GOT = 'Cards With All Versions In Hand';
    public const NEED = 'Cards With Versions NOT In Hand';
    public const EXP = 'Most Expensive Cards First';
    public const ABO = 'Cards Above 1 GBP';
    public const AVMAX = 'All VMAX Cards';
    public const AV = 'All V Cards';

    public const FILTER_OPTIONS = [
        self::NONE,
        self::GOT,
        self::NEED,
        self::EXP,
        self::ABO,
        self::AVMAX,
        self::AV
    ];

    public function getSet(int $id): Set
    {
        return Set::find($id);
    }

    public function getLatestSets(): Collection
    {
        Set::query()
            ->where('release_date', '>=', new DateTimeImmutable('2 years ago'))
            ->get();
    }

    public function getSwapsList(int $setId): array
    {
        $records = ReleasedCardVersion::query()
            ->get()
            ->filter(function ($version) use ($setId) {
                if ($version->releasedCard->set_id !== $setId) {
                    return false;
                }

                if ($version->quantity() < 2) {
                    return false;
                }

                return true;
            });

        $rows = [];
        foreach ($records as $record) {
            /** @var ReleasedCardVersion $record */
            $rows[] = [
                'version_id' => $record->id,
                'name' => $record->releasedCard->name . ' ' . $record->releasedCard->paddedNumber() . '/' . $record->releasedCard->set->base_card_count,
                'is_standard' => $record->is_standard === true ? 'Yes' : 'No',
                'is_reverse_holo' => $record->is_reverse_holo === true ? 'Yes' : 'No',
                'value' => $record->value,
                'quantity' => $record->quantity() - 1,
            ];
        }

        return $rows;
    }

    public function getNeedsList(int $setId): array
    {
        $records = ReleasedCardVersion::query()
            ->get()
            ->filter(function ($version) use ($setId) {
                if ($version->releasedCard->set_id !== $setId) {
                    return false;
                }

                if ($version->quantity() > 0) {
                    return false;
                }

                return true;
            });

        $rows = [];
        foreach ($records as $record) {
            /** @var ReleasedCardVersion $record */
            $rows[] = [
                'version_id' => $record->id,
                'name' => $record->releasedCard->name . ' ' . $record->releasedCard->paddedNumber() . '/' . $record->releasedCard->set->base_card_count,
                'is_standard' => $record->is_standard === true ? 'Yes' : 'No',
                'is_reverse_holo' => $record->is_reverse_holo === true ? 'Yes' : 'No',
                'value' => $record->value,
                'quantity' => $record->quantity() - 1,
            ];
        }

        return $rows;
    }

    public function exportSwaps(int $setId): void
    {
        $rows = $this->getSwapsList($setId);

        $headers = [
            '#',
            'Name',
            'Standard?',
            'Reverse Holo?',
            'Value',
            'Available',
        ];

        CSV::download(
            'swaps',
            $headers,
            $rows
        );
    }

    public function exportNeeds(int $setId): void
    {
        $rows = $this->getNeedsList($setId);

        $headers = [
            '#',
            'Name',
            'Standard?',
            'Reverse Holo?',
            'Value',
            'Available',
        ];

        CSV::download(
            'needs',
            $headers,
            $rows
        );
    }
}
