<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;

class CommentController extends Controller
{
    protected CommentService $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function allByPost(int $post_id)
    {
        return $this->service->getAllByPost($post_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCommentRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(CreateCommentRequest $request)
    {
        return $this
            ->service
            ->create($request->json()->all())
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param int $id
     * @return \App\Http\Resources\CommentResource
     * @throws ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCommentRequest $request, int $id)
    {
        return $this->service->update($id, $request->json()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->service->destroy($id);

        return response()->noContent();
    }
}
