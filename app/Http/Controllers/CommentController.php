<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Services\HandlerThrowableService;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    protected CommentService $service;
    protected HandlerThrowableService $handlerThrowableService;

    public function __construct(CommentService $service, HandlerThrowableService $handlerThrowableService)
    {
        $this->service = $service;
        $this->handlerThrowableService = $handlerThrowableService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }

    public function allByPost(int $post_id)
    {
        try {
            return $this->service->getAllByPost($post_id);
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request)
    {
        try {
            return $this->service->create($request->validated());
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
    public function update(UpdateCommentRequest $request, $id)
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
    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }
}
