<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\PostRepositoryException;

class PostRepository implements PostRepositoryInterface
{
    public function all(): PostCollection
    {
        return new PostCollection(Post::orderBy('id')->paginate(10));
    }

    public function allByUser(int $userId): PostCollection
    {
        return Post::where('user_id', $userId)->get();
    }

    public function get(int $id): PostResource
    {
        $post = Post::find($id);
        if ($post === null) {
            throw new ModelNotFoundException();
        }

        return new PostResource($post);
    }

    public function create(array $attributes): PostResource
    {
        $post = new Post;
        $post->fill($attributes);
        if (!$post->save()) {
            throw new PostRepositoryException('Post add problem', 400);
        }

        return new PostResource($post);
    }

    public function update(int $id, array $attributes): PostResource
    {
        $post = Post::find($id);
        if ($post === null) {
            throw new ModelNotFoundException();
        }

        $post->fill($attributes);
        if (!$post->save()) {
            throw new PostRepositoryException('Post update problem', 400);
        }

        return new PostResource($post);
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
