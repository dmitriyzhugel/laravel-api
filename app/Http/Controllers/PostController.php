<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\HandlerThrowableService;
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
    public function index()
    {
        //
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
    public function show($id)
    {
        try {
            return $this->service->show($id);
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

        } catch (Throwable $throwable) {
            return $this->handlerThrowableService->handle($throwable);
        }
    }
}
