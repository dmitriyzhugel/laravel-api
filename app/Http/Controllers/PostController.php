<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\HandlerThrowableService;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostService $service;
    protected HandlerThrowableService $handlerThrowableService;

    public function __construct(
        PostService $service,
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
        return $this->service->allByUser((int) auth()->id());
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
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->messages()->all());
        }

        // Retrieve the validated input data
        return $this
            ->service
            ->create($attributes)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->service->get($id);
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
                'title' => 'required|string|max:255',
                'content' => 'required|string',
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
