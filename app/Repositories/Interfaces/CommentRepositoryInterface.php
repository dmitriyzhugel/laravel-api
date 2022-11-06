<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;

interface CommentRepositoryInterface
{
    /**
     * @return CommentCollection
     */
    public function all(): CommentCollection;

    /**
     * @param int $postId
     * @return CommentCollection
     */
    public function allByPost(int $postId): CommentCollection;

    /**
     * @param int $id
     * @return CommentResource|null
     */
    public function get(int $id): ?CommentResource;

    /**
     * @param array $attributes
     * @return CommentResource
     */
    public function create(array $attributes): CommentResource;

    /**
     * @param int $id
     * @param array $attributes
     * @return CommentResource
     */
    public function update(int $id, array $attributes): CommentResource;

    /**
     * @param int $id
     */
    public function destroy(int $id): void;
}
