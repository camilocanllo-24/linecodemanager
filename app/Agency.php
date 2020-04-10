<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Agency
 *
 * @property int $id
 * @property string $nombre
 * @property string $direccion
 * @property string $contacto
 * @property string $telefono
 * @property string $email
 * @property string $municipio
 * @property int $isp_id
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Isp $isp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Nas[] $nas
 * @property-read int|null $nas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plan[] $plan
 * @property-read int|null $plan_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereContacto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereIspId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Subscriber[] $subscribers
 * @property-read int|null $subscribers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Ticket[] $tickets
 * @property-read int|null $tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Service[] $services
 * @property-read int|null $services_count
 * @property int $dia_facturacion
 * @property int $dia_pago
 * @property int $dia_corte
 * @property int $facturas_vencidas
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereDiaCorte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereDiaFacturacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereDiaPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereFacturasVencidas($value)
 * @property string $tipo_facturacion
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereTipoFacturacion($value)
 */
class Agency extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'direccion', 'contacto', 'telefono', 'email', 'municipio', 'isp_id', 'estado',
        'dia_facturacion', 'dia_pago', 'dia_corte', 'facturas_vencidas', 'tipo_facturacion',
        'codigo_abonado_personalizado'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'codigo_abonado_personalizado' => 'boolean',
    ];

    public function plan()
    {
        return $this->hasMany('App\Plan');
    }

    public function nas()
    {
        return $this->hasMany('App\Nas');
    }

    public function isp()
    {
        return $this->belongsTo('App\Isp');
    }

    public function subscribers()
    {
        return $this->hasMany('App\Subscriber');
    }

}
