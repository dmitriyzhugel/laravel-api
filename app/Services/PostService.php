<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;

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
        return $this->postRepository->get($id);
    }

    public function store(array $attributes): PostResource
    {
        return $this
            ->postRepository
            ->create(array_merge($attributes, ['user_id' => auth()->id()]));
    }

    public function update(int $id, array $attributes): PostResource
    {
        $post = $this->postRepository->get($id);
        if ((int) $post->user_id !== (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.', 403);
        }

        return $this
            ->postRepository
            ->update($id, $attributes);
    }

    public function destroy(int $id): void
    {
        $post = $this->postRepository->get($id);
        if ($post->user_id !== (int) auth()->id()) {
            throw new AuthorizationException('This action is unauthorized.', 403);
        }

        $this->postRepository->destroy($id);
    }
}
