<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SucursalProfesional extends Model
{
    /**
	* The table associated with the model.
	* 
	* @var string
	*/
    protected $table = 'sucursal_profesional';

    /**
     * @var array
     */
    protected $fillable = ['sucursal_id','profesional_rut'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }

    public function profesional()
    {
        return $this->belongsTo('App\Profesional', 'profesional_rut');
    }
}
