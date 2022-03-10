<?php

namespace App\Models;

Use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudRetiro extends Model
{
    use HasFactory;
    protected $appends = ['creado'];
    protected $fillable = [
        'monto', 'user_id', 'status',  'id_cuenta_banco'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function cuenta_banco()
    {
        return $this->belongsTo(CuentaBanco::class ,  'id_cuenta_banco');
    }

    public function getCreadoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function scopeStatus($query, $status)
    {
        if($status)
            return $query->where('status', $status);
    }
}
