<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'nama_lokasi',
        'alamat_lokasi',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_lokasi', 'id_lokasi');
    }

    public function recBrgMasuk()
    {
        return $this->hasMany(RecBrgMasuk::class, 'id_lokasi', 'id_lokasi');
    }
}
