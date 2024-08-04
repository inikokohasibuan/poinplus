<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBrgMasuk extends Model
{
    use HasFactory;

    protected $table = 'detail_brg_masuk';
    protected $primaryKey = 'id_detail_brg_masuk';

    protected $fillable = [
        'id_rec_brg_masuk',
        'id_sub_produk',
        'jumlah_brg_masuk',
    ];

    public function recBrgMasuk()
    {
        return $this->belongsTo(RecBrgMasuk::class, 'id_rec_brg_masuk', 'id_rec_brg_masuk');
    }

    public function subProduk()
    {
        return $this->belongsTo(SubProduk::class, 'id_sub_produk', 'id_sub_produk');
    }
}