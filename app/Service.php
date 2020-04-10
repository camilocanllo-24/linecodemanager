<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Service
 *
 * @property int $id
 * @property int $abonado_id
 * @property int $plan_id
 * @property string $direccion
 * @property string $ultima_milla
 * @property string $fecha_subscripcion
 * @property string|null $fecha_instalacion
 * @property string $telefono
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $torre
 * @property string|null $celda
 * @property string|null $nodo
 * @property string|null $codigo_nap
 * @property string|null $framed_ip_address
 * @property int|null $last_nas_id
 * @property-read \App\Credential $credential
 * @property-read \App\Plan $plan
 * @property-read \App\Subscriber $subscriber
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereAbonadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereCelda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereCodigoNap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereFechaInstalacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereFechaSubscripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereFramedIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereLastNasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereNodo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereTorre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereUltimaMilla($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Cpe $cpe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @property-read int|null $tickets_count
 * @property-read mixed $subscriber_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Payment[] $payments
 * @property-read int|null $payments_count
 * @property int $saldo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereSaldo($value)
 * @property string $pppoe_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Service wherePppoeStatus($value)
 */
class Service extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abonado_id', 'plan_id', 'direccion', 'ultima_milla', 'fecha_subscripcion',
        'fecha_instalacion', 'telefono', 'estado', 'framed_ip_address', 'last_nas_id', 'saldo', 'pppoe_status'
    ];

    protected $dates = [
        'fecha_subscripcion', 'fecha_instalacion', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'fecha_subscripcion' => 'date:m/d/Y',
        'fecha_instalacion' => 'date:m/d/Y',
    ];

    public function subscriber()
    {
        return $this->belongsTo('App\Subscriber', 'abonado_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function credential()
    {
        return $this->hasOne('App\Credential', 'servicio_id');
    }

    public function cpe()
    {
        return $this->hasOne('App\Cpe');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
    

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
