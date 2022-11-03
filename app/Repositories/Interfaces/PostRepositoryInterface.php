<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;
use App\Http\Resources\PostResource;
use Illuminate\Pagination\CursorPaginator;

interface PostRepositoryInterface
{
    public function all(): CursorPaginator;
    public function show(int $id): PostResource;
    public function store(array $attributes): void;
    public function update(int $id, array $attributes): void;
    public function destroy(int $id): void;
}
