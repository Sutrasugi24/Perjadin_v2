<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Perjadin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuratResource;
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

    public function show(Request $request)
    {
        $surat = SuratResource::collection(Surat::where(['id' => $request->id])->get());
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data surat by id',
            'data'      => $surat[0]
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $rules = [
            'document_number'    => ['required'],
            'document_date'   => ['required'],
            'perjadin_id'          => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $data = [
            'document_number'    => $request->document_number,
            'document_date'   => $request->document_date,
            'perjadin_id'          => $request->perjadin_id,
        ];

        DB::beginTransaction();
        try {
            $surat = Surat::findOrFail($request->id);
            $surat->update($data);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $surat->document_number . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b> </b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $surat = Surat::findOrFail($request->id);
            $surat->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $surat->document_number . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $surat->document_number . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
