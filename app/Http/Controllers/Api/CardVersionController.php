<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\CardVersionServiceInterface;
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

        return new JsonResponse([
            'quantity' => $updatedQuantity,
        ]);
    }
}
