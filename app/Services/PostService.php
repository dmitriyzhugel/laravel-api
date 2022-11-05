<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService
{
    /**
     * The post repository implementation.
     *
     * @var PostRepository
     */
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function allByUser(int $userId): PostCollection
    {
        return $this->postRepository->allByUser($userId);
    }

    public function get(int $id): PostResource
    {
        $post = $this->postRepository->get($id);
        if ($post === null) {
            throw new NotFoundHttpException('Post not found');
        }

        return $post;
    }

    public function create(array $attributes): PostResource
    {
        return $this
            ->postRepository
            ->create(array_merge($attributes, ['user_id' => auth()->id()]));
    }

    public function update(int $id, array $attributes): PostResource
    {
        $post = $this->postRepository->get($id);
        if ($post === null) {
            throw new NotFoundHttpException('Post not found');
        }
        if ((int) $post->user_id !== (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        return $this
            ->postRepository
            ->update($id, $attributes);
    }

    public function destroy(int $id): void
    {
        $post = $this->postRepository->get($id);
        if ($post === null) {
            throw new NotFoundHttpException('Post not found');
        }
        if ((int) $post->user_id !== (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        $this->postRepository->destroy($id);
    }
}
