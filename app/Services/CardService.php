<?php

namespace App\Services;

use App\Interfaces\CardServiceInterface;
use App\Models\ReleasedCard;
use App\Models\ReleasedCardVersion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class CardService extends AbstractService implements CardServiceInterface
{
    public function getReleasedCardsQuery(): Builder
    {
        return ReleasedCard::query();
    }

    public function filterBySet(
        int $setId,
        Builder $query
    ): Builder {
        return $query->where('set_id', $setId);
    }

    public function filterByRequest(
        Request $request,
        Builder $query
    ): Builder {
        if ($request->has('filter_type') === true) {
            $filterType = $request->get('filter_type');

            switch ($filterType) {
                case SetService::NEED:
                case SetService::GOT:
                case SetService::EXP:
                case SetService::ABO:
                    $query->with('versions');
                    break;
                case SetService::AVMAX:
                    $query->where('name', 'LIKE', '%VMAX%');
                    break;
                case SetService::AV:
                    $query->where('name', 'LIKE BINARY', '% V%')
                        ->where('name', 'NOT LIKE', '%VMAX%');
                    break;
                default:
                    break;
            }
        }

        return $query;
    }

    public function sortByRequest(
        Request $request,
        Builder $query
    ): Collection {
        $collection = $query->get();

        if ($request->has('filter_type') === true) {
            $filterType = $request->get('filter_type');

            switch ($filterType) {
                case SetService::EXP:
                    return $collection->sortBy(function($card) {
                        $values = [];
                        foreach ($card->versions as $version) {
                            $values[] = $version->value;
                        }
                        return max($values);
                    }, SORT_REGULAR, true);
                case SetService::ABO:
                    return $collection->filter(function($card) {
                        foreach ($card->versions as $version) {
                            if ($version->value > 1) {
                                return true;
                            }
                        }

                        return false;
                    });
                case SetService::NEED:
                    return $collection->filter(function($card) {
                        foreach ($card->versions as $version) {
                            if ($version->quantity() < 1) {
                                return true;
                            }
                        }

                        return false;
                    });
                case SetService::GOT:
                    return $collection->filter(function($card) {
                        foreach ($card->versions as $version) {
                            if ($version->quantity() < 1) {
                                return false;
                            }
                        }

                        return true;
                    });
                default:
                    break;
            }
        }

        return $collection;
    }
}
