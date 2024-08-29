<?php

namespace App\Http\Controllers;

use App\Http\Resources\BiayaResource;
use App\Models\Biaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BiayaController extends Controller
{
    public function index()
    {
        $biayas = Biaya::all();
        return view('admin.biaya', ['title' => 'Biaya', 'data' => $biayas]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric', 'min:0'],
        ], [
            'type.required' => 'Jenis biaya harus diisi.',
            'cost.required' => 'Biaya harus diisi.',
            'cost.numeric' => 'Biaya harus berupa angka.',
            'cost.min' => 'Biaya tidak boleh kurang dari :min.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $biaya = Biaya::create([
                'type' => $request->type,
                'cost' => $request->cost,
            ]);
            DB::commit();
            return back()->with('success', "Data <b>{$biaya->type}</b> berhasil dibuat");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', "Data gagal dibuat: {$th->getMessage()}");
        }
    }

    public function show(Request $request)
    {
        $biaya = BiayaResource::collection(Biaya::where('id', $request->id)->get());
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Data biaya by id',
            'data' => $biaya[0]
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric', 'min:0'],
        ], [
            'type.required' => 'Jenis biaya harus diisi.',
            'cost.required' => 'Biaya harus diisi.',
            'cost.numeric' => 'Biaya harus berupa angka.',
            'cost.min' => 'Biaya tidak boleh kurang dari :min.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $biaya = Biaya::findOrFail($request->id);
            $biaya->update([
                'type' => $request->type,
                'cost' => $request->cost,
            ]);
            DB::commit();
            return back()->with('success', "Data <b>{$biaya->type}</b> berhasil disimpan");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', "Data gagal disimpan: {$th->getMessage()}");
        }
    }

    public function destroy(Request $request)
    {
        try {
            $biaya = Biaya::findOrFail($request->id);
            $biaya->delete();
            return back()->with('success', "Data <b>{$biaya->type}</b> berhasil dihapus");
        } catch (\Throwable $th) {
            return back()->with('error', "Data gagal dihapus: {$th->getMessage()}");
        }
    }
}