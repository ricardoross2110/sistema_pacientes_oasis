<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 */

class TipoContrato extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_contrato';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];
}
