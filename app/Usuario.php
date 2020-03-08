<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $rut
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $email
 * @property int $telefono
 * @property int $wwid
 * @property int $pid
 * @property string $foto
 * @property boolean $estado
 * @property string $nombre_foto
 * @property Trabajadore $trabajadore
 * @property CursoUsuario[] $cursoUsuarios
 */
class Usuario extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'usuarios';

    public $timestamps = false; 

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'rut';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPassword()
    {
      return $this->password;
    }
    

    /**
     * @var array
     */
    protected $fillable = ['rut', 'dv', 'password', 'nombres', 'apellido_paterno', 'apellido_materno', 'telefono', 'email', 'estado', 'fecha_registro', 'perfil_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfil()
    {
        return $this->belongsTo('App\Perfil', 'perfil_id');
    }
}
