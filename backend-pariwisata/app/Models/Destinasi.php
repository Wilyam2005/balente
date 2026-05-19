<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriWisata;
use App\Models\Kuliner;
use App\Models\RiwayatInteraksi;

class Destinasi extends Model
{
    protected $fillable = [
        'kategori_id', 'nama_tempat', 'latitude', 'longitude', 'deskripsi', 'sumber_dinas'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriWisata::class, 'kategori_id');
    }

    public function kuliner()
    {
        return $this->hasMany(Kuliner::class, 'destinasi_id');
    }

    public function riwayatInteraksi()
    {
        return $this->hasMany(RiwayatInteraksi::class, 'destinasi_id');
    }
}
