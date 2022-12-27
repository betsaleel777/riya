<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    const INDEX = 'user.index';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $user = User::get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(): View
    {
        return view();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route(self::INDEX);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id): View
    {
        return view();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        return redirect()->route(self::INDEX);
    }

    public function trashed(): View
    {
        return view();
    }

    public function trash(int $id): RedirectResponse
    {
        return redirect()->route(self::INDEX);
    }

    public function restore(): RedirectResponse
    {
        return redirect()->route(self::INDEX);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id): JsonResponse
    {
        return response()->json();
    }

    public function search(): View
    {
        return view();
    }

    public function searchTrashed(): View
    {
        return view();
    }

    public function export()
    {

    }
}
