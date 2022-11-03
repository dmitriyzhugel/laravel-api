<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\PostRepositoryInterface;

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

    public function show(int $id): PostResource
    {
        return $this->postRepository->show($id);
    }
}
