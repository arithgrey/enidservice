<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    public function users()
    {

        return $this->hasMany(User::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }
}
