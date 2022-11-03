<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\HandlerThrowableService;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    protected UserService $service;
    protected HandlerThrowableService $handlerThrowableService;

    public function __construct(UserService $service, HandlerThrowableService $handlerThrowableService)
    {
        $this->service = $service;
        $this->handlerThrowableService = $handlerThrowableService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): UserCollection
    {
        try {
            return $this->service->getUserList();
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }
}
