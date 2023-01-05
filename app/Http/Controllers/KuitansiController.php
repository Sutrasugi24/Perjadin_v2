<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKuitansiRequest;
use App\Http\Requests\UpdateKuitansiRequest;
use App\Models\Kuitansi;

class KuitansiController extends Controller
{
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
     * @param  \App\Http\Requests\StoreKuitansiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKuitansiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kuitansi  $kuitansi
     * @return \Illuminate\Http\Response
     */
    public function show(Kuitansi $kuitansi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kuitansi  $kuitansi
     * @return \Illuminate\Http\Response
     */
    public function edit(Kuitansi $kuitansi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKuitansiRequest  $request
     * @param  \App\Models\Kuitansi  $kuitansi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKuitansiRequest $request, Kuitansi $kuitansi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kuitansi  $kuitansi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kuitansi $kuitansi)
    {
        //
    }
}
