<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinasiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_tempat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_wisata,id',
            // Pembatasan koordinat spasial (Boundary Indonesia)
            'latitude' => ['required', 'numeric', 'min:-11.0', 'max:6.0'], 
            'longitude' => ['required', 'numeric', 'min:95.0', 'max:141.0'], 
            'deskripsi' => 'nullable|string',
            // Validasi file gambar ketat untuk Backend SPK
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ];
    }
    
    public function messages()
    {
        return [
            'latitude.min' => 'Latitude tidak valid! (Di luar batas Indonesia).',
            'latitude.max' => 'Latitude tidak valid! (Di luar batas Indonesia).',
            'longitude.min' => 'Longitude tidak valid! (Di luar batas Indonesia).',
            'longitude.max' => 'Longitude tidak valid! (Di luar batas Indonesia).',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau webp.',
        ];
    }
}
