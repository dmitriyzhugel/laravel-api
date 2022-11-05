<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            ->create(array_merge($attributes, ['user_id' => auth()->id()]));
    }

    public function update(int $id, array $attributes): CommentResource
    {
        $comment = $this->commentRepository->get($id);
        if ($comment === null) {
            throw new NotFoundHttpException('Comment not found');
        }
        if ($comment->user_id !== (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        return $this
            ->commentRepository
            ->update($id, $attributes);
    }

    public function destroy(int $id): void
    {
        $comment = $this->commentRepository->get($id);
        if ($comment === null) {
            throw new NotFoundHttpException('Comment not found');
        }
        if ($comment->user_id !== (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        $this->commentRepository->destroy($id);
    }
}
