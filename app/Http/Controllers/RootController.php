<?php

namespace App\Http\Controllers;

use App\Interfaces\CardServiceInterface;
use App\Interfaces\SeriesServiceInterface;
use App\Interfaces\SetServiceInterface;
use App\Services\SetService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class RootController extends WebController
{
    public function __construct(
        private SetServiceInterface $setService,
        private SeriesServiceInterface $seriesService,
        private CardServiceInterface $cardService
    ){}

    public function getIndex(Request $request): Renderable
    {
        if ($request->has('set') === true) {
            $set = $this->setService->getSet($request->get('set'));

            $releasedCardsQuery = $this->cardService->getReleasedCardsQuery();
            $releasedCardsQuery = $this->cardService->filterBySet(
                $request->get('set'),
                $releasedCardsQuery
            );
            if ($request->has('filter') === true) {
                $releasedCardsQuery = $this->cardService->filterByRequest(
                    $request,
                    $releasedCardsQuery
                );
            }
        }

        if ($request->has('set') === false) {
            $latestSets = $this->setService->getLatestSets();
        }

        $series = $this->seriesService->getAll();

        if (empty($releasedCardsQuery) === false) {
            $releasedCards = $this->cardService->sortByRequest(
                $request,
                $releasedCardsQuery
            );
        } else {
            $releasedCards = [];
        }

        return view('index')
            ->with('series', $series)
            ->with('set', $set ?? null)
            ->with('latestSets', $latestSets ?? null)
            ->with('releasedCards', $releasedCards);
    }
}
