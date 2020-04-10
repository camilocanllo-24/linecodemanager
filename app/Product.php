<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
/**
 * App\User
 *
 * @property int $id
 * @property string $descripcion
 * @property string $codigo_barras
 * @property string $marca
 * @property string $id_categoria
 * @property string $id_iva
 * @property string $precio_cj_dp
 * @property string $precio_und
 * @property string $precio_venta
 * @property string $utilidad
 * @property string $cantidad_maxima
 * @property string $cantidad_actual
 * @property string $imagen
 *  @property-read \App\Category $category
 * @property-read \App\Vat $vats
 * @mixin \Eloquent
 */

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion', 'codigo_barras','marca', 'id_categoria', 'id_iva', 'precio_cj_dp', 'precio_und','precio_venta','utilidad','cantidad_maxima', 'cantidad_actual', 'imagen',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category', 'id_categoria', 'id');
    }
    public function vat()
    {
        return $this->belongsTo('App\Vat', 'id_iva', 'id');
    }
    public function isSuperAdmin()
    {
        return $this->rol === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    public function isOperador()
    {
        return $this->rol === 'operador';
    }

    public function isCajero()
    {
        return $this->rol === 'cajero';
    }

    public function isTecnico()
    {
        return $this->rol === 'tecnico';
    }
}
