<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'accesos';

    /**
     * @var array
     */
    protected $fillable = [ 'usuario_rut', 'fecha'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usuario_rut');
    }
}
