<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Surat;
use App\Models\Perjadin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Resources\SuratResource;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Laraindo\RupiahFormat;

class SuratController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Surat',
            'data' => Surat::all(),
            'perjadin' => Perjadin::with('users')->get(),
            'role' => Role::all(),
        ];

        return view('admin.surat', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_number' => 'required',
            'document_date' => 'required',
            'perjadin_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $surat = Surat::create($request->only('document_number', 'document_date', 'perjadin_id'));
            DB::commit();
            Alert::success('Pemberitahuan', "Data <b>{$surat->document_number}</b> berhasil dibuat")->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', "Data <b>{$request->document_number}</b> gagal dibuat: {$th->getMessage()}")->toToast()->toHtml();
        }

        return back();
    }

    public function show(Request $request)
    {
        $surat = SuratResource::collection(Surat::where('id', $request->id)->get());

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Data surat by id',
            'data' => $surat->first()
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_number' => 'required',
            'document_date' => 'required',
            'perjadin_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $surat = Surat::findOrFail($request->id);
            $surat->update($request->only('document_number', 'document_date', 'perjadin_id'));
            DB::commit();
            Alert::success('Pemberitahuan', "Data <b>{$surat->document_number}</b> berhasil disimpan")->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', "Data <b>{$request->document_number}</b> gagal disimpan: {$th->getMessage()}")->toToast()->toHtml();
        }

        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $surat = Surat::findOrFail($request->id);
            $surat->delete();
            Alert::success('Pemberitahuan', "Data <b>{$surat->document_number}</b> berhasil dihapus")->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', "Data <b>{$surat->document_number}</b> gagal dihapus: {$th->getMessage()}")->toToast()->toHtml();
        }

        return back();
    }

    public function download($id)
    {
        $surat = Surat::findOrFail($id);
        $data = $this->prepareViewData($surat);

        view()->share('x', $data);

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled', true])
            ->setPaper(array(0,0,609.4488,935.433), 'landscape')
            ->loadView('admin.surat-download', $data);

        return $pdf->download('surat.pdf');
    }

    private function prepareViewData(Surat $surat)
    {
        $perjadin = Perjadin::findOrFail($surat->perjadin_id);
        $interval = (new Carbon($perjadin->return_date))->diffInDays(new Carbon($perjadin->leave_date)) + 1;
        $totalMembers = DB::table('user_perjadin')->where('perjadin_id', $surat->perjadin_id)->count() + 1;

        $members = [$perjadin->coordinator];
        foreach ($perjadin->users as $user) {
            $members[] = $user->id;
        }

        return [
            'title' => 'Surat',
            'perjadin' => Perjadin::with(['kuitansi', 'surat', 'users'])->where('id', $surat->perjadin_id)->get(),
            'selisihHari' => $interval,
            'data' => $surat,
            'members' => $members,
            'user' => User::all(),
        ];
    }
}
