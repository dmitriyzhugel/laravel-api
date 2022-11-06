<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = json_decode($request->getContent(), true);
        $validator = Validator::make(
            $attributes,
            [
                'comment' => 'required|string',
                'post_id' => 'required|exists:posts,id',
            ]
        );
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->messages()->all());
        }

        return $this
            ->service
            ->create($attributes)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $attributes = json_decode($request->getContent(), true);
        $validator = Validator::make(
            $attributes,
            [
                'comment' => 'required|string',
                'post_id' => 'exists:posts,id',
            ]
        );
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->messages()->all());
        }

        return $this->service->update($id, $attributes);
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
