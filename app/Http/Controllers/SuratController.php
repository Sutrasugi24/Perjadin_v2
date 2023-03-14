<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Biaya;
use App\Models\Surat;
use App\Models\Kuitansi;
use App\Models\Perjadin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuratResource;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Terbilang;

class SuratController extends Controller
{
    public function index()
    {
        $x['title'] = 'Surat';
        $x['data'] = Surat::get();
        $x['perjadin'] = Perjadin::with('users')->get();
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
            Alert::error('Pemberitahuan', 'Data <b>'. $surat->document_number .'</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
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
            'perjadin_id'       => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $data = [
            'document_number'    => $request->document_number,
            'document_date'   => $request->document_date,
            'perjadin_id'     =>   $request->perjadin_id
        ];

        DB::beginTransaction();
        try {
            $surat = Surat::findOrFail($request->id);
            $surat->update($data);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $surat->document_number . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b>'. $surat->document_number .'</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
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

    public function download($id)
    {
        $surat = Surat::findOrFail($id);
        $perjadin = Perjadin::findOrFail($surat->perjadin_id);
        //selisih hari
        $fdate = new Carbon($perjadin->return_date);
        $tdate = new Carbon($perjadin->leave_date);
        $interval = $fdate->diffInDays($tdate) + 1;

        $x['title'] = 'Surat';
        $x['perjadin'] = Perjadin::with(['kuitansi', 'surat', 'users'])->where('id', $surat->perjadin_id)->get();
        $x['selisihHari'] = $interval;
        $x['data'] = Surat::find($id);
        $x['members'][] = $perjadin->coordinator;

        foreach ($perjadin->users as $user) {
            $x['members'][] = $user->id;
        }
        $x['user'] = User::get();
        view()->share('x', $x);
        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled', true])
                ->setPaper('F4', 'landscape')
                ->loadView('admin.surat-download', $x);
        return $pdf->download('surat.pdf');
    }

    public function rincian($id){
        $surat = Surat::findOrFail($id);
        $perjadin = Perjadin::findOrFail($surat->perjadin_id);
        //selisih hari
        $fdate = new Carbon($perjadin->return_date);
        $tdate = new Carbon($perjadin->leave_date);
        $interval = $fdate->diffInDays($tdate) + 1;

        $totalMembers = (DB::table('user_perjadin')->where('perjadin_id', $surat->perjadin_id)->count()) + 1;
        
        

        $x['title'] = 'Surat';
        $x['perjadin'] = Perjadin::with(['kuitansi', 'surat', 'users'])->where('id', $surat->perjadin_id)->get();
        $x['selisihHari'] = $interval;
        $x['data'] = Surat::find($id);
        $x['members'][] = $perjadin->coordinator;
        $x['cost_per_id'] = $perjadin->kuitansi->cost_total / $totalMembers;
        
        //Terbilang
        $x['terbilang'] = Terbilang::make($perjadin->kuitansi->cost_total);

        foreach ($perjadin->users as $user) {
            $x['members'][] = $user->id;
        }

        $x['user'] = User::get();

        view()->share('x', $x);

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled', true])
                ->setPaper('F4', 'potrait')
                ->loadView('admin.rincian', $x);
        return $pdf->download('rincian_biaya.pdf');

        // return view('admin.rincian', $x);
    }

    public function pembayaran($id){
        $surat = Surat::findOrFail($id);
        $perjadin = Perjadin::findOrFail($surat->perjadin_id);
        //selisih hari
        $fdate = new Carbon($perjadin->return_date);
        $tdate = new Carbon($perjadin->leave_date);
        $interval = $fdate->diffInDays($tdate) + 1;

        $totalMembers = (DB::table('user_perjadin')->where('perjadin_id', $surat->perjadin_id)->count()) + 1;
        
        $x['title'] = 'Surat';
        $x['perjadin'] = Perjadin::with(['kuitansi', 'surat', 'users'])->where('id', $surat->perjadin_id)->get();
        $x['selisihHari'] = $interval;
        $x['data'] = Surat::find($id);
        $x['members'][] = $perjadin->coordinator;
        $x['cost_per_id'] = $perjadin->kuitansi->cost_total / $totalMembers;
        //Terbilang
        $x['terbilang'] = Terbilang::make($perjadin->kuitansi->cost_total);

        foreach ($perjadin->users as $user) {
            $x['members'][] = $user->id;
        }
        $x['user'] = User::get();
        view()->share('x', $x);

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled', true])
                ->setPaper('F4', 'landscape')
                ->loadView('admin.pembayaran_transport', $x);
        return $pdf->download('daftar_pembayaran.pdf');

        //return view('admin.pembayaran_transport', $x);
    }
}
