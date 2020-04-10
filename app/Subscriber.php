<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Subscriber
 *
 * @property int $id
 * @property string $codigo_abonado
 * @property string $primer_nombre
 * @property string|null $segundo_nombre
 * @property string $primer_apellido
 * @property string|null $segundo_apellido
 * @property string $tipo_identidad
 * @property int $numero_identidad
 * @property string $fecha_nacimiento
 * @property string $agency_id
 * @property string $telefono
 * @property string|null $email
 * @property string $direccion
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Agency $agency
 * @property-read \App\Isp $isp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereCodigoAbonado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereNumeroIdentidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber wherePrimerApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber wherePrimerNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereSegundoApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereSegundoNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereTipoIdentidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscriber whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Service[] $service
 * @property-read int|null $service_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @property-read int|null $tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $payments
 * @property-read int|null $payments_count
 */
class Subscriber extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo_abonado', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido',
        'tipo_identidad', 'numero_identidad', 'fecha_nacimiento', 'agency_id', 'telefono',
        'email', 'direccion', 'estado'
    ];

    public function isp()
    {
        return $this->belongsTo('App\Isp');
    }

    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    public function services()
    {
        return $this->hasMany('App\Service', 'abonado_id', 'id');
    }

    public function tickets()
    {
        return $this->hasManyThrough(
            'App\Ticket',
            'App\Service',
            'abonado_id',
            'service_id',
            'id',
            'id'
            );
    }

    public function payments()
    {
        return $this->hasManyThrough(
            'App\Payment',
            'App\Service',
            'abonado_id'
        );
    }
}
