<?php

namespace App\Http\Controllers;

use App\Models\Kuitansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\KuitansiResource;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KuitansiController extends Controller
{
    public function index()
    {
        
        $x['title'] = 'Kuitansi';
        $x['data'] = Kuitansi::get();

        return view('admin.kuitansi', $x);
    }

    public function create()
    {
        //
    }

    public function store(StoreKuitansiRequest $request)
    {
        //
    }

    public function show(Kuitansi $kuitansi)
    {
        //
    }

    public function edit(Kuitansi $kuitansi)
    {
        //
    }

    public function update(UpdateKuitansiRequest $request, Kuitansi $kuitansi)
    {
        //
    }

    public function destroy(Kuitansi $kuitansi)
    {
        //
    }
}
