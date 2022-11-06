<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Repositories\Interfaces\UserRepositoryInterface;

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

    /**
     * @return UserCollection
     */
    public function getUserList(): UserCollection
    {
        return $this->userRepository->all();
    }
}
