<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $nombre
 */
class Profesion extends Model
{
   
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'profesiones';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

}