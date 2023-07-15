<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pelanggaransiswa as psiswa;

class getPelanggaranSiswa extends Controller
{
    public function getPelSiswaPage()
    {

        $paging = request('paging');
        $search = request('search');
        if (request('tanggalAwal') && request('tanggalAkhir')) {
            $tanggalAwal = request('tanggalAwal');
            $tanggalAkhir = request('tanggalAkhir');
            $data = psiswa::with('siswa', 'pelanggaran')->where('id', 'like', "%" . $search . "%")->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->select(['id', 'siswa_id', 'pelanggaran_id', 'created_at'])
                ->orderBy('id')->paginate($paging);
            return response()->json($data);
        }
        $data = psiswa::with('siswa', 'pelanggaran')->select(['id', 'siswa_id', 'pelanggaran_id', 'created_at'])
            ->whereHas('siswa', function ($query) use ($search) {
                return $query->where('siswa_id', 'like', "%" . $search . "%");
            })->orderBy('id')->paginate($paging);
        return response()->json($data);


        // Event::whereHas('participants', function ($query) {
        //     return $query->where('IDUser', '=', 1);
        // })->get();


    }
}
