<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $rut
 * @property char $dv
 * @property int $sucursal_id
 * @property int $cargo_id
 * @property int $tipo_contrato_id
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
 * @property Cargo $cargo
 * @property Sucursal $sucursal
 * @property TipoContrato $tipo_contrato
 */

class Profesional extends Model
{
	/**
	* The table associated with the model.
	* 
	* @var string
	*/
    protected $table = 'profesionales';

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
    protected $fillable = ['rut', 'dv', 'cargo_id', 'profesion_id', 'tipo_contrato_id', 'nombres', 'apellido_paterno', 'apellido_materno', 'direccion', 'telefono', 'email', 'observacion', 'estado', 'fecha_registro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function profesion()
    {
        return $this->belongsTo('App\Profesion', 'profesion_id');
    }

    public function cargo()
    {
        return $this->belongsTo('App\Cargo', 'cargo_id');
    }

    public function tipoContrato()
    {
        return $this->belongsTo('App\TipoContrato', 'tipo_contrato_id');
    }
}
