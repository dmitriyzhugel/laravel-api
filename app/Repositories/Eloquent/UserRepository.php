<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Pagination\CursorPaginator;

class UserRepository implements UserRepositoryInterface
{
    public function all(): CursorPaginator
    {
        return User::orderBy('id')->cursorPaginate(10);
    }
}
