<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SolicitudRetiro;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolicitudRetiroPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function pass(User $user , SolicitudRetiro  $solicitudRetiro){

        return $user->id ==  $solicitudRetiro->user_id;
    }
}
