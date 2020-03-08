<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property string $action
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Log extends Model
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
    protected $fillable = ['id', 'accion', 'detalle', 'created_at', 'USUARIO_rut'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
