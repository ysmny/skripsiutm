<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orangtua;

class GetOrangtuaController extends Controller
{
    public function getOrtu()
    {

        $paging = request('paging');
        $search = request('search');

        $data = Orangtua::where('nama_orangtua', 'like', "%" . $search . "%")->select(['id_orangtua', 'nama_orangtua', 'alamat', 'no_hp_orangtua', 'status_nomor'])
            ->orderBy('id_orangtua')->paginate($paging);
        return response()->json($data);
    }
}
