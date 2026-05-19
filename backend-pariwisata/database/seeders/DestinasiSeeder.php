<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DestinasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_wisatas')->updateOrInsert(
            ['id' => 1],
            ['nama_kategori' => 'Alam', 'deskripsi' => 'Wisata alam di Lombok Timur', 'created_at' => now(), 'updated_at' => now()]
        );

        DB::table('destinasis')->insert([
            [
                'kategori_id' => 1,
                'nama_tempat' => 'Pantai Tangsi (Pink Beach)',
                'latitude' => -8.8604,
                'longitude' => 116.5242,
                'deskripsi' => 'Pantai dengan pasir berwarna merah muda yang unik di Lombok Timur.',
                'sumber_dinas' => 'Dinas Pariwisata Lombok Timur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
