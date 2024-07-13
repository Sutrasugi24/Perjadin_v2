<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perjadin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\PerjadinResource;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PerjadinController extends Controller
{
    public function index()
    {
        $x['title'] = 'Perjadin';
        $x['data'] = Perjadin::with('users')->get();
        $x['user'] = User::get();
        $x['role'] = Role::get();
        $x['transport'] = ['darat', 'laut', 'udara'];
        // dd($x);

        return view('admin.perjadin', $x);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_date'      => ['required'],
            'return_date'   => ['required'],
            'plan'          => ['required', 'max:255'],
            'destination'   => ['required'],
            'destination_two' => ['max:255'],
            'destination_three' => ['max:255'],
            'description'   => ['max:255'],
            'transport'     => ['required', 'in:darat,laut,udara'],
            'coordinator'   => ['required', 'max:255'],
            'members'       => ['array'],

        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $perjadin = Perjadin::create([
                'leave_date'    => $request->leave_date,
                'return_date'   => $request->return_date,
                'plan'          => $request->plan,
                'destination'   => $request->destination,
                'destination_two' => $request->destination_two,
                'destination_three' => $request->destination_three,
                'description'   => $request->description,
                'transport'     => $request->transport,
                'coordinator'   => $request->coordinator
            ]);
            // $perjadin->assignRole($request->role);
            $perjadin->users()->sync(request('members'));
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $perjadin->coordinator . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b>'. $perjadin->coordinator . '</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $perjadin = PerjadinResource::collection(Perjadin::with('users')->where(['id' => $request->id])->get());
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data perjadin by id',
            'data'      => $perjadin[0]
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $rules = [
            'leave_date'    => ['required'],
            'return_date'   => ['required'],
            'plan'          => ['required', 'max:255'],
            'destination'   => ['required'],
            'description'   => ['max:255'],
            'transport'     => ['required', 'in:darat,laut,udara'],
            'coordinator'   => ['required', 'max:255'],
            'members'       => ['array'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $data = [
            'leave_date'    => $request->leave_date,
            'return_date'   => $request->return_date,
            'plan'          => $request->plan,
            'destination'   => $request->destination,
            'destination_two'   => $request->destination_two,
            'destination_three'   => $request->destination_three,
            'description'   => $request->description,
            'transport'     => $request->transport,
            'coordinator'   => $request->coordinator,
            // 'members'       => $request->members
        ];

        DB::beginTransaction();
        try {
            $perjadin = Perjadin::with('users')->findOrFail($request->id);
            $perjadin->users()->sync(request('members'));
            $perjadin->update($data);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $perjadin->coordinator . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b>' . $perjadin->coordinator . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $perjadin = Perjadin::findOrFail($request->id);
            $perjadin->users()->detach();
            $perjadin->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $perjadin->coordinator . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $perjadin->coordinator . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
