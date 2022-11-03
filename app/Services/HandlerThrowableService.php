<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Service for handle exceptions
 */
class HandlerThrowableService
{
    public function handle(Throwable $throwable): JsonResponse
    {
        return new JsonResponse([
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode()
        ]);
    }
}
