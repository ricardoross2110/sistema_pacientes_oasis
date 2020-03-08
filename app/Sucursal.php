<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property int $telefono
 * @property string $direccion
 */

class Sucursal extends Model
{
    
     /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sucursales';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'telefono', 'whatsapp', 'direccion'];

}
