<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adventure extends Model
{
    protected $fillable = [
        'kegiatan',
        'rencana_kapan',
        'deskripsi_kegiatan',
    ];
}
