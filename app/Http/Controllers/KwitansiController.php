<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKwitansiRequest;
use App\Http\Requests\UpdateKwitansiRequest;
use App\Models\Kwitansi;

class KwitansiController extends Controller
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
     * @param  \App\Http\Requests\StoreKwitansiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKwitansiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kwitansi  $kwitansi
     * @return \Illuminate\Http\Response
     */
    public function show(Kwitansi $kwitansi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kwitansi  $kwitansi
     * @return \Illuminate\Http\Response
     */
    public function edit(Kwitansi $kwitansi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKwitansiRequest  $request
     * @param  \App\Models\Kwitansi  $kwitansi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKwitansiRequest $request, Kwitansi $kwitansi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kwitansi  $kwitansi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kwitansi $kwitansi)
    {
        //
    }
}
