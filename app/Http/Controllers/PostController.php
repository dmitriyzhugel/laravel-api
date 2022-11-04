<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\HandlerThrowableService;
use App\Http\Requests\Api\IndexPostRequest;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use Throwable;

class PostController extends Controller
{
    protected PostService $service;
    protected HandlerThrowableService $handlerThrowableService;

    public function __construct(PostService $service, HandlerThrowableService $handlerThrowableService)
    {
        $this->service = $service;
        $this->handlerThrowableService = $handlerThrowableService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPostRequest $request)
    {
        return $this->service->allByUser((int) auth()->id());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        try {
            // Retrieve the validated input data
            return $this->service->store($request->validated());
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            return $this->service->get($id);
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, int $id)
    {
        try {
            $this->service->update($id, $request->validated());
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }
}
