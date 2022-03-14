<?php

namespace TamaleFiesta;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TamaleFiesta\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //Variables Globales
    public $rol_aut=array();

    public function getRouteKeyName()
    {
        return 'hash_user';
    }

    public function roles()
    {
        return $this->belongsToMany('TamaleFiesta\Role');
    }

    

    public function authorizedRoles($roles)
    {
        global $rol_aut;

        if(!is_null($roles)){
            if($this->hasAnyRoles($roles)){
                return $rol_aut;
            }
        }
        abort(403,'No puedes acceder a esta Seccion');
    }

    public function hasRole($role)
    {
       if($this->roles()->where('nombre',$role)->first()){
            return true;
        }else{
            return false;
        }
    }

    public function hasAnyRoles($roles){

        global $rol_aut;

        if(is_array($roles)){
            $i=0;
            foreach ($roles as $rol) {
                if ($this->hasRole($rol)) {
                    $rol_aut[]=$rol;
                    $i++;
                }
            }

            if($i>0){
                return true;
            }
        }else{
            if ($this->hasRole($roles)) {
                return true;
            }else{
               return false;
            }
        }


    }

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
