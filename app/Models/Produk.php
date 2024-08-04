<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'kategori_produk',
        'nama_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_produk', 'id_kategori');
    }

    public function subProduk()
    {
        return $this->hasMany(SubProduk::class, 'id_produk', 'id_produk');
    }
}
