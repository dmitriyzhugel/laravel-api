<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

interface PostRepositoryInterface
{
    /**
     * @return PostCollection
     */
    public function all(): PostCollection;

    /**
     * @param int $userId
     * @return PostCollection
     */
    public function allByUser(int $userId): PostCollection;

    /**
     * @param int $id
     * @return PostResource|null
     */
    public function get(int $id): ?PostResource;

    /**
     * @param array $attributes
     * @return PostResource
     */
    public function create(array $attributes): PostResource;

    /**
     * @param int $id
     * @param array $attributes
     * @return PostResource
     */
    public function update(int $id, array $attributes): PostResource;

    /**
     * @param int $id
     */
    public function destroy(int $id): void;
}
