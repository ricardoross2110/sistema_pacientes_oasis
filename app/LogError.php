<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $usuario_rut
 * @property string $tipo_error
 * @property string $detalle
 * @property string $mensaje
 * @property string $created_at
 * @property string $updated_at
 * @property Usuario $usuario
 */

class LogError extends Model
{
    
     /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'log_errores';


    /**
     * @var array
     */
    protected $fillable = ['usuario_rut', 'tipo_error', 'detalle', 'mensaje','created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Usuario', 'usuario_rut');
    }
}
