<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Biaya;
use App\Models\Kuitansi;
use App\Models\Perjadin;
use App\Models\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Spatie\Permission\Models\Role;
use App\Http\Resources\KuitansiResource;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KuitansiController extends Controller
{
    public function index()
    {
        $x['title'] = 'Kuitansi';
        $x['perjadin'] = Perjadin::with('users')->get();
        $x['biaya'] = Biaya::all();
        $x['data'] = Kuitansi::all();

        return view('admin.kuitansi', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kuitansi_number'   => ['required'],
            'kuitansi_date'     => ['required'],
            'perjadin_id'       => ['required'],
            'biaya_id'          => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $total_biaya = $this->calculateTotalBiaya($request->perjadin_id, $request->biaya_id);

            $kuitansi = Kuitansi::create([
                'kuitansi_number' => $request->kuitansi_number,
                'kuitansi_date' => $request->kuitansi_date,
                'cost_total' => $total_biaya,
                'perjadin_id' => $request->perjadin_id,
                'biaya_id' => $request->biaya_id,
            ]);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $kuitansi->kuitansi_number . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b></b> gagal dibuat: ' . $th->getMessage())->toToast()->toHtml();
        }

        return back();
    }

    public function show(Request $request)
    {
        $kuitansi = KuitansiResource::collection(Kuitansi::where('id', $request->id)->get());
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Data kuitansi by id',
            'data' => $kuitansi[0]
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $this->validateRequest($request);

        $total_biaya = $this->calculateTotalBiaya($request->perjadin_id, $request->biaya_id);

        $data = [
            'kuitansi_number' => $request->kuitansi_number,
            'kuitansi_date' => $request->kuitansi_date,
            'cost_total' => $total_biaya,
            'perjadin_id' => $request->perjadin_id,
            'biaya_id' => $request->biaya_id,
        ];

        DB::beginTransaction();
        try {
            $kuitansi = Kuitansi::findOrFail($request->id);
            $kuitansi->update($data);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $kuitansi->number . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b></b> gagal disimpan: ' . $th->getMessage())->toToast()->toHtml();
        }

        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $kuitansi = Kuitansi::findOrFail($request->id);
            $kuitansi->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $kuitansi->number . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $kuitansi->number . '</b> gagal dihapus: ' . $th->getMessage())->toToast()->toHtml();
        }

        return back();
    }

    public function download($id)
    {
        $kuitansi = Kuitansi::findOrFail($id);

        // Fetch related Perjadin data
        $perjadin = Perjadin::findOrFail($kuitansi->perjadin_id); // Assuming perjadin_id is the foreign key
        
        $x['title'] = 'Kuitansi';
        $x['data'] = $kuitansi;
        
        $x['terbilang'] = Number::spell($kuitansi->cost_total, locale: 'id');
        $x['perjadin'] = $perjadin; // Pass perjadin data to the view
        $x['user'] = User::all();

        view()->share('x', $x);
        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true])
            ->setPaper(array(0,0,609.4488,935.433), 'portrait')
            ->loadView('admin.kuitansi-download', $x);
        
        return $pdf->download('kuitansi.pdf');
    }

    public function rincian($id)
    {
        $kuitansi = Kuitansi::findOrFail($id);
        $data = $this->prepareViewData($kuitansi);

        view()->share('x', $data);

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled', true])
            ->setPaper(array(0,0,609.4488,935.433), 'portrait') //F4
            ->loadView('admin.rincian', $data);

        return $pdf->download('rincian_biaya.pdf');
    }

    public function pembayaran($id)
    {
        $kuitansi = Kuitansi::findOrFail($id);
        $data = $this->prepareViewData($kuitansi);

        view()->share('x', $data);

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled', true])
            ->setPaper(array(0,0,609.4488,935.433), 'landscape') //F4
            ->loadView('admin.pembayaran_transport', $data);

        return $pdf->download('daftar_pembayaran.pdf');
    }

    private function prepareViewData(Kuitansi $kuitansi)
    {
        $perjadin = Perjadin::findOrFail($kuitansi->perjadin_id);
        $interval = (new Carbon($perjadin->return_date))->diffInDays(new Carbon($perjadin->leave_date)) + 1;
        $totalMembers = DB::table('user_perjadin')->where('perjadin_id', $kuitansi->perjadin_id)->count() + 1;

        $members = [$perjadin->coordinator];
        foreach ($perjadin->users as $user) {
            $members[] = $user->id;
        }

        return [
            'title' => 'Kuitansi',
            'perjadin' => Perjadin::with(['kuitansi', 'users'])->where('id', $kuitansi->perjadin_id)->get(),
            'selisihHari' => $interval,
            'data' => $kuitansi,
            'members' => $members,
            'user' => User::all(),
            'cost_per_id' => $perjadin->kuitansi->cost_total / $totalMembers,
            'terbilang' => Number::spell($perjadin->kuitansi->cost_total, locale: 'id'),
        ];
    }

    private function validateRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'kuitansi_number' => ['required'],
            'kuitansi_date' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    }

    private function calculateTotalBiaya($perjadin_id, $biaya_id)
    {
        $perjadin = Perjadin::findOrFail($perjadin_id);
        $id_perjadin = $perjadin_id;
        $id_biaya = $biaya_id;

        // Calculate the number of days
        $fdate = new Carbon($perjadin->return_date);
        $tdate = new Carbon($perjadin->leave_date);
        $interval = $fdate->diffInDays($tdate) + 1;
        $members = (DB::table('user_perjadin')->where('perjadin_id', $id_perjadin)->count()) + 1;

        $biaya = Biaya::findOrFail($id_biaya);

        return $biaya->cost * $interval * $members;
    }
}
