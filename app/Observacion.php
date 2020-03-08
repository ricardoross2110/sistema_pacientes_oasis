<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    /**
	* The table associated with the model.
	* 
	* @var string
	*/
    protected $table = 'observaciones';

    /**
     * @var array
     */
    protected $fillable = ['atencion_id', 'observacion', 'fecha'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function atencion()
    {
        return $this->belongsTo('App\Atencion', 'atencion_id');
    }
}
