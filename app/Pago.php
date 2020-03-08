<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $monto
 * @property int $tipo_pago_id
 * @property int $atencion_id
 * @property TipoPago $tipo_pago
 * @property Atencion $atencion
 */

class Pago extends Model
{
     /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pagos';

    /**
     * @var array
     */
    protected $fillable = ['monto', 'tipo_pago_id', 'atencion_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPago()
    {
        return $this->belongsTo('App\TipoPago', 'tipo_pago_id');
    }

    public function atencion()
    {
        return $this->belongsTo('App\Atencion', 'atencion_id');
    }
}
