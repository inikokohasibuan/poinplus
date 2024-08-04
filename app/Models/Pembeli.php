<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembeli';
    protected $primaryKey = 'id_pembeli';

    protected $fillable = [
        'nama_pembeli',
        'alamat_pembeli',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pembeli', 'id_pembeli');
    }
}
