<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Santoral extends Model
{
    /**
	* The table associated with the model.
	* 
	* @var string
	*/
    protected $table = 'santoral';

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
