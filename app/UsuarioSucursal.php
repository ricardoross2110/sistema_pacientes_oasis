<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioSucursal extends Model
{
    /**
    * The table associated with the model.
    * 
    * @var string
    */
    protected $table = 'usuario_sucursal';

    public $timestamps = false; 
    
    /**
     * @var array
     */
    protected $fillable = ['sucursal_id', 'usuario_rut'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usuario_rut');
    }

}
