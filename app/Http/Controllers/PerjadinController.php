<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerjadinRequest;
use App\Http\Requests\UpdatePerjadinRequest;
use App\Models\Perjadin;
use App\Http\Resources\PerjadinResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class PerjadinController extends Controller
{
    public function index()
    {
        $x['title'] = 'Perjadin';
        $x['data'] = Perjadin::with('users')->get();
        $x['role'] = Role::get();

        return view('admin.perjadin', $x);
    }

    
    public function create()
    {
        $validator = Validator::make($request->all(), [
            'leave_date'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string'],
            'role'      => ['required'],
            'nip'       => ['required', 'string'],
            'nips'      => ['requiired', 'string'],
            'jabatan'   => ['required', 'string'],
            'golongan'  => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'leave_date'      => $request->leave_date,
                'return_date'     => $request->return_date,
                'plan'  => $request->plan,
                'destination'       => $request->destination,
                'description'      => $request->description,
                'transport'   => $request->transport,
                'coordinator'  => $request->coordinator
            ]);
            $user->assignRole($request->role);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $user->name . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b>' . $user->name . '</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePerjadinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerjadinRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function show(Perjadin $perjadin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function edit(Perjadin $perjadin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerjadinRequest  $request
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerjadinRequest $request, Perjadin $perjadin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perjadin  $perjadin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perjadin $perjadin)
    {
        //
    }
}
