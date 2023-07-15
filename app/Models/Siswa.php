<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'nama_siswa', 'alamat_siswa', 'jurusan', 'kelas', 'no_hp_siswa', 'no_hp_orangtua', 'id_orangtua'
    ];
    public function pelanggarans()
    {
        return $this->belongsToMany(Pelanggaran::class, 'pelanggaran_siswa');
    }
    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class, 'id_orangtua');
    }
}
