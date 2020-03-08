<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTratamiento extends Model
{
    /**
	* The table associated with the model.
	* 
	* @var string
	*/
    protected $table = 'tipo_tratamientos';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

}