<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $rut
 * @property char $dv
 * @property int $sucursal_id
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $direccion
 * @property int $telefono
 * @property string $email
 * @property string $facebook
 * @property string $instagram
 * @property text $observacion
 * @property bool $estado
 * @property datetime $fecha_registro
 * @property Sucursal $sucursal
 */

class Paciente extends Model
{
     /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pacientes';

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
     * @var array
     */
    protected $fillable = ['rut', 'dv', 'sucursal_id', 'nombres', 'apellido_paterno', 'apellido_materno', 'direccion', 'telefono', 'email', 'facebook', 'instagram', 'observacion', 'fecha_registro', 'estado', 'fecha_registro'];
}
