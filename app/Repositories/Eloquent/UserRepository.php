<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Http\Resources\UserCollection;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function all(): UserCollection
    {
        return new UserCollection(User::orderBy('id')->paginate(10));
    }
}
