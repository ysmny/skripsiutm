<?php

namespace App\Http\Controllers;

use App\Models\pelanggaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function get_product_paging()
    {
        $paging = request('paging');
        $search = request('search');
        if (request('tanggalAwal') && request('tanggalAkhir')) {
            $tanggalAwal = request('tanggalAwal');
            $tanggalAkhir = request('tanggalAkhir');
            $data = pelanggaran::where('jenis_pelanggaran', 'like', "%" . $search . "%")->whereBetween('waktu_pelanggaran', [$tanggalAwal, $tanggalAkhir])->select(['id', 'jenis_pelanggaran', 'poin', 'waktu_pelanggaran'])
                ->orderBy('id')->paginate($paging);
            return response()->json($data);
        }

        $data = pelanggaran::where('jenis_pelanggaran', 'like', "%" . $search . "%")->select(['id', 'jenis_pelanggaran', 'poin'])
            ->orderBy('id')->paginate($paging);
        return response()->json($data);
    }
}
