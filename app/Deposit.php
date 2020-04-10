<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion', 'agency_id',
    ];


    public function isp()
    {
        return $this->belongsTo('App\Isp');
    }

    public function agency()
    {
        return $this->belongsTo('App\Agency');
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
