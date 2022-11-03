<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\CursorPaginator;

class UserService
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserList(): UserCollection
    {
        $list = $this->userRepository->all();

        return new UserCollection($list);
    }
}
