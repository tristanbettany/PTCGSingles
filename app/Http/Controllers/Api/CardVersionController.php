<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\CardVersionServiceInterface;
use App\Models\ReleasedCard;
use App\Models\Set;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardVersionController extends ApiController
{
    public function __construct(
        private CardVersionServiceInterface $cardVersionService
    ) {
    }

    public function postIndex(
        int $cardId,
        int $versionId,
        Request $request
    ): JsonResponse {
        $updatedQuantity = $this->cardVersionService->updateVersionQuantity(
            $versionId,
            $request->get('quantity')
        );

        $set = ReleasedCard::find($cardId)->set;

        return new JsonResponse([
            'quantity' => $updatedQuantity,
            'onHandValue' => round($set->onHandValue(), 2),
            'duplicatesValue' => round($set->duplicatesValue(), 2),
            'versionsMissingValues' => $set->missingValues(),
            'versionsWithoutStock' => $set->missingStock(),
            'versionsWithStock' => $set->withStock(),
            'versionsWithDuplicates' => $set->withDuplicates(),
            'totalOnHandVersions' => $set->totalOnHand(),
            'totalDuplicateVersions' => $set->totalDuplicates(),
        ]);
    }

    public function getScrapeValue(
        int $cardId,
        int $versionId,
        Request $request
    ): JsonResponse {
        return new JsonResponse([
            'value' => $this->cardVersionService->scrapeValue($versionId),
        ]);
    }
}
