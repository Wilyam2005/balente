<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Destinasi;

class KategoriWisata extends Model
{
    protected $table = 'kategori_wisatas';

    protected $fillable = ['nama_kategori'];

    public function destinasi()
    {
        return $this->hasMany(Destinasi::class, 'kategori_id');
    }
}
