<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface
{
    public function getCommentList(): array;
    public function store(): void;
    public function delete(): void;
}
