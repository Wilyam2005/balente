<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Destinasi;
use App\Models\KategoriWisata;
use App\Models\User;

class RiwayatInteraksi extends Model
{
    protected $table = 'riwayat_interaksis';

    protected $fillable = [
        'user_id', 'kategori_id', 'jenis_interaksi', 'bobot'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriWisata::class, 'kategori_id');
    }
}
