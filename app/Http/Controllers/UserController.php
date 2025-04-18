<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $x['title']     = 'User';
        $x['data']      = User::with('perjadins')->get();
        $x['role']      = Role::get();
        return view('admin.user', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string'],
            'role'      => ['required'],
            'nip'       => ['nullable', 'string', 'unique:users'],
            'nips'      => ['nullable', 'string', 'unique:users'],
            'jabatan'   => ['nullable', 'string'],
            'pangkat'   => ['nullable', 'string'],
            'golongan'  => ['nullable', 'string']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'nip'       => $request->nip,
                'nips'      => $request->nips,
                'jabatan'   => $request->jabatan,
                'pangkat'   => $request->pangkat,
                'golongan'  => $request->golongan
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

    public function show(Request $request)
    {
        $user = UserResource::collection(User::where(['id' => $request->id])->get());
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data user by id',
            'data'      => $user[0]
        ], Response::HTTP_OK);
        
    }

    public function update(Request $request)
    {
        $rules = [
            'name'      => ['required', 'string', 'max:255'],
            'password'  => ['nullable', 'string'],
            'role'      => ['required'],
            'jabatan'   => ['nullable', 'string'],
            'pangkat'   => ['nullable', 'string'],
            'golongan'  => ['nullable', 'string']
        ];

        if ($request->email != $request->old_email) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $validator = Validator::make($request->all(), $rules);
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
            $validator = Validator::make($request->all(), $rules);
        }

        if ($request->nip != $request->old_nip) {
            $rules['nip'] = ['nullable', 'string', 'unique:users'];
            $validator = Validator::make($request->all(), $rules);
        } else {
            $rules['nip'] = ['nullable', 'string'];
            $validator = Validator::make($request->all(), $rules);
        }

        if ($request->nips != $request->old_nips) {
            $rules['nips'] = ['nullable', 'string', 'unique:users'];
            $validator = Validator::make($request->all(), $rules);
        } else {
            $rules['nips'] = ['nullable', 'string'];
            $validator = Validator::make($request->all(), $rules);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'nip'     => $request->nip,
            'nips'     => $request->nips,
            'jabatan'     => $request->jabatan,
            'pangkat'     => $request->pangkat,
            'golongan'     => $request->golongan,
        ];
        if (!empty($request->password)) {
            $data['password']   = bcrypt($request->password);
        }

        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            $user->update($data);
            $user->syncRoles($request->role);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $user->name . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b>' . $user->name . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $user->name . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $user->name . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function import(Request $request)
    {
        try {
        Excel::import(new UsersImport, $request->file('file'));
        Alert::success('Pemberitahuan', 'Data <b>' . $request->file . '</b> berhasil ditambahkan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $request->file . '</b> gagal ditambahkan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
