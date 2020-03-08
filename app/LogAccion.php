<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $usuario_rut
 * @property string $accion
 * @property string $detalle
 * @property string $created_at
 * @property string $updated_at
 * @property Usuario $usuario
 */

class LogAccion extends Model
{
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'log_acciones';
    
    /**
     * @var array
     */
    protected $fillable = ['usuario_rut', 'accion', 'detalle', 'tipo_accion','created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usuario_rut');
    }
}
