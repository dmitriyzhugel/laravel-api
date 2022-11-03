<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\PostRepositoryException;

class PostRepository implements PostRepositoryInterface
{
    public function all(): CursorPaginator
    {
        return Post::orderBy('id')->cursorPaginate(10);
    }

    public function show(int $id): PostResource
    {
        $post = Post::find($id);
        if ($post === null) {
            throw new ModelNotFoundException();
        }

        return new PostResource($post);
    }

    public function store(array $attributes): void
    {
        $post = new Post;
        $post->fill($attributes);
        $post->user_id = auth()->id();
        if (!$post->save()) {
            throw new PostRepositoryException('Post add problem', 400);
        }
    }

    public function update(int $id, array $attributes): void
    {
        $post = Post::find($id);
        if ($post === null) {
            throw new ModelNotFoundException();
        }

        $post->fill($attributes);
        if (!$post->save()) {
            throw new PostRepositoryException('Post update problem', 400);
        }
    }

    public function destroy(int $id): void
    {
        $post = Post::find($id);
        if ($post === null) {
            throw new ModelNotFoundException();
        }

        $post->delete();
    }
}
