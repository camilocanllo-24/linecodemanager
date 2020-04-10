<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider_product extends Model
{ /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [
        'id_producto', 'id_provedor',
    ];

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
