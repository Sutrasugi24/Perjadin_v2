<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Perjadin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuratResources;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SuratController extends Controller
{
    public function index()
    {
        $x['title'] = 'Surat';
        $x['data'] = Surat::get();
        $x['perjadin'] = Perjadin::get();
        $x['role'] = Role::get();
        // dd($x);

        return view('admin.surat', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_number'      => ['required'],
            'document_date'   => ['required'],
            'perjadin_id'   => ['required'],
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $surat = Surat::create([
                'document_number'    => $request->document_number,
                'document_date'   => $request->document_date,
                'perjadin_id'   => $request->perjadin_id,
            ]);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $surat->document_number . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b> </b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function edit(Surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuratRequest  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuratRequest $request, Surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surat $surat)
    {
        //
    }
}
