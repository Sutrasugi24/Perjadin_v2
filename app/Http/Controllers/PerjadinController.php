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
use App\Http\Requests\StorePerjadinRequest;
use App\Http\Requests\UpdatePerjadinRequest;
use Symfony\Component\HttpFoundation\Response;

class PerjadinController extends Controller
{
    public function index()
    {
        $x['title'] = 'Perjadin';
        $x['data'] = Perjadin::get();
        $x['user'] = User::get();
        $x['role'] = Role::get();

        

        return view('admin.perjadin', $x);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_date'      => ['required'],
            'return_date'   => ['required'],
            'plan'          => ['required', 'max:255'],
            'destination'   => ['required'],
            'description'   => ['required', 'max:255'],
            'transport'     => ['required', 'in:darat,laut,udara'],
            'coordinator'   => ['required', 'max:255'],
            'members'       => ['required', 'array'],

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
                'description'   => $request->description,
                'transport'     => $request->transport,
                'coordinator'   => $request->coordinator
            ]);
            $perjadin->assignRole($request->role);
            $perjadin->users()->sync(request('members'));
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $perjadin->coordinator . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b></b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $perjadin = PerjadinResource::collection(Perjadin::where(['id' => $request->id])->get());
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data perjadin by id',
            'data'      => $perjadin[0]
        ], Response::HTTP_OK);
    }

    public function edit(Perjadin $perjadin)
    {
        //
    }

    public function update(UpdatePerjadinRequest $request, Perjadin $perjadin)
    {
        //
    }

    public function destroy(Perjadin $perjadin)
    {
        //
    }
}
