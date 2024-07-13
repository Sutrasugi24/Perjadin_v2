<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Surat;
use App\Models\Kuitansi;
use App\Models\Perjadin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function index(Request $request){
        $x['title']         = 'Dashboard';
        $x['user']          = User::get();
        $x['role']          = Role::get();
        $x['permission']    = Permission::get();
        $x['kuitansi']    = Kuitansi::get();
        $x['perjadin']    = Perjadin::get();
        $x['surat']    = Surat::get();
        return view('admin.dashboard', $x);
    }
}
