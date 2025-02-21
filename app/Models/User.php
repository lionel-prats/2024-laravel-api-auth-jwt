<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_users';
    protected $primaryKey = 'userId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /* protected $fillable = [
        'name',
        'email',
        'password',
    ]; */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    /* protected $hidden = [
        'password',
        'remember_token',
    ]; */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /* protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ]; */

    public function getJWTIdentifier()
    {
        // Devuelve la clave primaria del modelo (getKey() es un metodo definido en vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php)
        return $this->getKey();  
    }

    public function getJWTCustomClaims()
    {
        // en este array podemos anadir informacion adicional que se va a anadir al token cuando sea generado 
        // cada vez que se genere un token con la informacion del usuario, si queremos anadir mas informacion, lo podemos hacer en este array 
        return [
            'name' => $this->name,
            'email' => $this->email,
            'roleId' => $this->roleId
        ];  
    }
}
