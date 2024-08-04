<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokLokasi extends Model
{
    use HasFactory;

    protected $table = 'stok_lokasi';
    protected $primaryKey = 'id_stok_lokasi';

    protected $fillable = [
        'id_sub_produk',
        'id_lokasi',
        'jumlah_stok',
    ];

    public function subProduk()
    {
        return $this->belongsTo(SubProduk::class, 'id_sub_produk', 'id_sub_produk');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }
}
