<?php

namespace App\Models;

use App\Models\CuentaBanco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'imagen'
    ];
    public function cuentas_banco()
    {

        return $this->hasMany(CuentaBanco::class);
    }

}
