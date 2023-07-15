<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelanggaransiswa extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran_siswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'siswa_id', 'pelanggaran_id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pelanggaran()
    {
        return $this->belongsTo(pelanggaran::class, 'pelanggaran_id');
    }
    public function pelanggaranById()
    {
        return $this->belongsTo(pelanggaran::class);
    }
}
