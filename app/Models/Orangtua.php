<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Orangtua extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'orangtua';
    protected $primaryKey = 'id_orangtua';
    protected $fillable = [
        'nama_orangtua', 'alamat', 'no_hp_orangtua', 'status_nomor'
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
