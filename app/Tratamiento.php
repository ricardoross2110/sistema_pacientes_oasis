<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $rut
 * @property int $paciente_rut
 * @property string $nombre
 * @property text $observacion
 * @property int $valor
 * @property Paciente $paciente
 */

class Tratamiento extends Model
{
    /**
    * The table associated with the model.
    * 
    * @var string
    */
    protected $table = 'tratamientos';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'folio';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['folio', 'nombre', 'tipo_tratamiento_id','observacion', 'valor', 'num_control', 'estado_deuda'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente()
    {
        return $this->belongsTo('App\Paciente', 'paciente_rut');
    }
    public function tipoTratamiento()
    {
        return $this->belongsTo('App\TipoTratamiento', 'id');
    }
}
