<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerjadinRequest;
use App\Http\Requests\UpdatePerjadinRequest;
use App\Models\Perjadin;

class PerjadinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $x['title'] = 'Perjadin';
        $x['data'] = Perjadin::get();
        $x['role'] = Role::get();

        return view('admin.perjadin',[$x]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePerjadinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerjadinRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function show(Perjadin $perjadin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function edit(Perjadin $perjadin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerjadinRequest  $request
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerjadinRequest $request, Perjadin $perjadin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perjadin $perjadin)
    {
        //
    }
}
