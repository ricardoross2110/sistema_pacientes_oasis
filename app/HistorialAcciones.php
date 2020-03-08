<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialAcciones extends Model
{
    /**
	* The table associated with the model.
	* 
	* @var string
	*/
    protected $table = 'historial_acciones';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['fecha','santo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
}
