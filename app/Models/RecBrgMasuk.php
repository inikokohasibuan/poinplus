<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecBrgMasuk extends Model
{
    use HasFactory;

    protected $table = 'rec_brg_masuk';
    protected $primaryKey = 'id_rec_brg_masuk';

    protected $fillable = [
        'no_nota_garansi',
        'tgl_brg_masuk',
        'id_lokasi',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }

    public function detailBrgMasuk()
    {
        return $this->hasMany(DetailBrgMasuk::class, 'id_rec_brg_masuk', 'id_rec_brg_masuk');
    }
}
