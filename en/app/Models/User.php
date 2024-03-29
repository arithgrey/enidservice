<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'facebook',
        'tel_contacto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function solicitudes_retiro()
    {

        return $this->hasMany(SolicitudRetiro::class);
    }

    public function cuentas_banco()
    {

        return $this->hasMany(CuentaBanco::class);
    }

    public function servicios()
    {

        return $this->hasMany(Servicio::class);
    }
    public function proveedores()
    {
        return $this->hasMany(ProveedorServicio::class);
    }
    public function listas_negras()
    {

        return $this->hasMany(ListaNegra::class);
    }
    function preferencias()
    {

        return $this->hasMany(Preferencia::class);
    }
    public function ppfps()
    {
        return $this->hasMany(ProyectoPersonaFormaPago::class);
    }
    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class);
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class,  'id_empresa');
    }
}
