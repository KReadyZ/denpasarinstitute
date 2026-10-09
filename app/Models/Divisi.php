<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'ikon',
        'header',
        'background_image',
        'deskripsi',
        'stats',
        'program_links',
        'view_file',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'stats' => 'array',
        'program_links' => 'array',
        'is_active' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(DivisiSection::class)
                    ->where('is_active', true)
                    ->orderBy('urutan', 'asc');
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}