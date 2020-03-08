<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tratamiento_folio
 * @property int $profesional_rut
 * @property int $sucursal_id
 * @property int $usuario_rut
 * @property int $num_atencion
 * @property text $observacion
 * @property datetime $fecha
 * @property int $abono
 * @property Tratamiento $tratamiento
 * @property Usuario $usuario
 * @property Profesional $profesional
 * @property Sucursal $sucursal
 */

class Atencion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atenciones';

    /**
     * @var array
     */
    protected $fillable = ['num_atencion', 'tratamiento_folio', 'profesional_rut', 'sucursal_id', 'usuario_rut', 'num_atencion','observacion', 'fecha', 'abpno'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tratamiento()
    {
        return $this->belongsTo('App\Tratamiento', 'tratamiento_folio');
    }

    public function profesional()
    {
        return $this->belongsTo('App\Profesional', 'profesional_rut');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usuario_rut');
    }
}
