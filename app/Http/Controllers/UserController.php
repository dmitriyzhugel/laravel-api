<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): UserCollection
    {
        return $this->service->getUserList();
    }
}
