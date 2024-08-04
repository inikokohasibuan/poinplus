<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProduk extends Model
{
    use HasFactory;

    protected $table = 'sub_produk';
    protected $primaryKey = 'id_sub_produk';

    protected $fillable = [
        'id_produk',
        'warna_produk',
        'size_produk',
        'harga_produk',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
