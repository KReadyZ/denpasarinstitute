<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'divisi_id', 'nama', 'slug', 'ikon', 'deskripsi', 'is_active', 'urutan'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}