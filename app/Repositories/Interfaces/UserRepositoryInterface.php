<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;
use Illuminate\Pagination\CursorPaginator;

interface UserRepositoryInterface
{
    public function all(): CursorPaginator;
}
