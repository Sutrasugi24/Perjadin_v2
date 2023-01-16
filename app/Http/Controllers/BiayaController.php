<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\BiayaResource;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BiayaController extends Controller
{
    public function index()
    {
        $x['title'] = 'Biaya';
        $x['data'] = Biaya::get();

        return view('admin.biaya', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'      => ['required'],
            'cost'   => ['required'],
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $biaya = Biaya::create([
                'type'    => $request->type,
                'cost'   => $request->cost,
            ]);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $biaya->type . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b> </b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $biaya = BiayaResource::collection(Biaya::where(['id' => $request->id])->get());
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data biaya by id',
            'data'      => $biaya[0]
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $rules = [
            'type'    => ['required'],
            'cost'   => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $data = [
            'type'    => $request->type,
            'cost'   => $request->cost,
        ];

        DB::beginTransaction();
        try {
            $biaya = Biaya::findOrFail($request->id);
            $biaya->update($data);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $biaya->type . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b> </b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $biaya = Biaya::findOrFail($request->id);
            $biaya->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $biaya->type . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $biaya->type . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
