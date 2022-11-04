<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;

class CommentService
{
    /**
     * The comment repository implementation.
     *
     * @var CommentRepository
     */
    protected CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllByPost(int $postId): CommentCollection
    {
        return $this->commentRepository->allByPost($postId);
    }

    public function create(array $attributes): CommentResource
    {
        return $this
            ->commentRepository
            ->store(array_merge($attributes, ['user_id' => auth()->id()]))
            ->response()
            ->setStatusCode(201);
    }

    public function update(int $id, array $attributes): PostResource
    {
        $comment = $this->commentRepository->get($id);
        if ($comment->user_id === (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.', 403);
        }

        return $this
            ->commentRepository
            ->update($id, $attributes);
    }

    public function destroy(int $id): void
    {
        $comment = $this->commentRepository->get($id);
        if ($comment->user_id === (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.', 403);
        }

        $this->commentRepository->destroy($id);
    }
}
