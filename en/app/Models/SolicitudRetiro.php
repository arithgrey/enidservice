<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudRetiro extends Model
{
    use HasFactory;
    protected $appends = ['creado'];
    protected $fillable = [
        'monto', 'status'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreadoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
