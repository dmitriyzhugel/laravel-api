<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Services\HandlerThrowableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CommentController extends Controller
{
    protected CommentService $service;
    protected HandlerThrowableService $handlerThrowableService;

    public function __construct(
        CommentService $service,
        HandlerThrowableService $handlerThrowableService
    ) {
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
    public function store(Request $request)
    {
        try {
            $attributes = json_decode($request->getContent(), true);
            $validator = Validator::make(
                $attributes,
                [
                    'comment' => 'required|string',
                    'post_id' => 'required|exists:posts,id',
                ]
            );
            if ($validator->fails()) {
                throw new \Exception('Validation error', 422);
            }

            return $this
                ->service
                ->create($attributes)
                ->response()
                ->setStatusCode(201);
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
    public function update(Request $request, $id)
    {
        try {
            $attributes = json_decode($request->getContent(), true);
            $validator = Validator::make(
                $attributes,
                [
                    'comment' => 'required|string',
                    'post_id' => 'exists:posts,id',
                ]
            );
            if ($validator->fails()) {
                throw new \Exception('Validation errors', 422);
            }

            return $this->service->update($id, $attributes);
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

            return response()->noContent();
        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }
}
