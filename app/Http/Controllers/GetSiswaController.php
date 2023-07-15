<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetSiswaController extends Controller
{
    public function getSiswaPage()
    {
        $paging = request('paging');
        $search = request('search');

        // $data = DB::select("SELECT siswas.nama_siswa, siswas.alamat_siswa, siswas.jurusan, siswas.no_hp_siswa, orangtua.no_hp_orangtua, orangtua.nama_orangtua, SUM(pelanggarans.poin) AS total_pelanggaran FROM orangtua INNER JOIN siswas ON orangtua.id_orangtua = siswas.id_orangtua INNER JOIN pelanggaran_siswa ON siswas.id = pelanggaran_siswa.siswa_id INNER JOIN pelanggarans ON pelanggaran_siswa.pelanggaran_id = pelanggarans.id GROUP BY siswas.nama_siswa, siswas.alamat_siswa, siswas.jurusan, siswas.no_hp_siswa, orangtua.no_hp_orangtua,orangtua.nama_orangtua WHERE orangtua.nama_orangtua")->paginate($paging);
        $data = DB::table('siswas')
            ->join('orangtua', 'siswas.id_orangtua', '=', 'orangtua.id_orangtua')
            ->leftjoin('pelanggaran_siswa', 'siswas.id', '=', 'pelanggaran_siswa.siswa_id')->leftjoin('pelanggarans', function ($join) {
                $join->on('pelanggaran_siswa.pelanggaran_id', '=', 'pelanggarans.id');
            })
            ->select('siswas.id', 'siswas.nama_siswa', 'siswas.alamat_siswa', 'siswas.jurusan', 'siswas.kelas', 'siswas.no_hp_siswa', 'orangtua.no_hp_orangtua', 'orangtua.nama_orangtua',  DB::raw('SUM(pelanggarans.poin) as total'))
            ->groupBy('siswas.id', 'siswas.nama_siswa', 'siswas.alamat_siswa', 'siswas.jurusan', 'siswas.kelas', 'siswas.no_hp_siswa', 'orangtua.no_hp_orangtua', 'orangtua.nama_orangtua')->where('siswas.nama_siswa', 'like', "%" . $search . "%")->paginate($paging);
        return response()->json($data);
    }
}
