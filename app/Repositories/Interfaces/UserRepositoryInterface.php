<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;
use App\Http\Resources\UserCollection;

interface UserRepositoryInterface
{
    /**
     * @return UserCollection
     */
    public function all(): UserCollection;
}
