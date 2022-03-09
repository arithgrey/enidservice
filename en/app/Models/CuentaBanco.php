<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Banco;

class CuentaBanco extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarjeta', 'propietario', 'id_banco', 'user_id'
    ];
    function banco()
    {
        return $this->belongsTo(Banco::class, 'id_banco');
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }

}
