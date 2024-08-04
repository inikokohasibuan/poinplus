<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemindahanStok extends Model
{
    use HasFactory;

    protected $table = 'pemindahan_stok';
    protected $primaryKey = 'id_pemindahan_stok';

    protected $fillable = [
        'id_sub_produk',
        'id_lokasi_asal',
        'id_lokasi_tujuan',
        'jumlah_pindah',
        'waktu_pindah',
    ];

    public function subProduk()
    {
        return $this->belongsTo(SubProduk::class, 'id_sub_produk', 'id_sub_produk');
    }

    public function lokasiAsal()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi_asal', 'id_lokasi');
    }

    public function lokasiTujuan()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi_tujuan', 'id_lokasi');
    }
}
