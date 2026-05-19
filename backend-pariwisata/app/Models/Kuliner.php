<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Destinasi;

class Kuliner extends Model
{
    protected $fillable = ['nama_makanan', 'destinasi_id', 'foto_sampel'];

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id');
    }
}
