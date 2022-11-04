<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

interface PostRepositoryInterface
{
    public function all(): PostCollection;
    public function allByUser(int $userId): PostCollection;
    public function get(int $id): PostResource;
    public function create(array $attributes): PostResource;
    public function update(int $id, array $attributes): PostResource;
    public function destroy(int $id): void;
}
