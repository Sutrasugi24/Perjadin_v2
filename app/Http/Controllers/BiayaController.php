<?php

namespace App\Http\Controllers;

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

    public function update(Request $request, $id)
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
            $biaya = Biaya::findOrFail($id);
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

    public function destroy($id)
    {
        try {
            $biaya = Biaya::findOrFail($id);
            $biaya->delete();
            return back()->with('success', "Data <b>{$biaya->type}</b> berhasil dihapus");
        } catch (\Throwable $th) {
            return back()->with('error', "Data gagal dihapus: {$th->getMessage()}");
        }
    }
}