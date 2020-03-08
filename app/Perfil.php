<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $nombre
 */

class Perfil extends Model
{
    
     /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfiles';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

}
