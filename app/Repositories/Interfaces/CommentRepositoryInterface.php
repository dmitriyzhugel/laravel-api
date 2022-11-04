<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;

interface CommentRepositoryInterface
{
    public function all(): CommentCollection;
    public function allByPost(int $postId): CommentCollection;
    public function get(int $id): CommentResource;
    public function create(array $attributes): CommentResource;
    public function update(int $id, array $attributes): CommentResource;
    public function destroy(int $id): void;
}
