<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Exceptions\CommentRepositoryException;

class CommentRepository implements CommentRepositoryInterface
{
    public function all(): CommentCollection
    {
        return Comment::all();
    }

    public function allByPost(int $postId): CommentCollection
    {
        return Comment::where('post_id', $postId)->get();
    }

    public function get(int $id): ?CommentResource
    {
        $comment = Comment::find($id);

        return $comment !== null ? (new CommentResource($comment)) : null;
    }

    public function create(array $attributes): CommentResource
    {
        $comment = new Comment();
        $comment->fill($attributes);
        if (!$comment->save()) {
            throw new CommentRepositoryException('Comment add problem', 400);
        }

        return new CommentResource($comment);
    }

    public function update(int $id, array $attributes): CommentResource
    {
        $comment = Comment::find($id);
        $comment->fill($attributes);
        if (!$comment->save()) {
            throw new CommentRepositoryException('Comment update problem', 400);
        }

        return new CommentResource($comment);
    }

    public function destroy(int $id): void
    {
        Comment::destroy($id);
    }
}
