<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Isp
 *
 * @property int $id
 * @property string $nombre
 * @property string $direccion
 * @property string $municipio
 * @property string $telefono
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nit
 * @property string $contacto
 * @property string $email
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Nas[] $nas
 * @property-read int|null $nas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plan[] $plan
 * @property-read int|null $plan_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Subscriber[] $subscribers
 * @property-read int|null $subscribers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereContacto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereNit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Isp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Isp extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'direccion','municipio', 'telefono', 'estado', 'email', 'nit', 'contacto',
    ];

    public function plan()
    {
        return $this->hasMany('App\Plan');
    }

    public function nas()
    {
        return $this->hasMany('App\Nas');
    }

    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\Agency');
    }

    public function subscribers()
    {
        return $this->hasManyThrough('App\Subscriber', 'App\Agency');
    }

}
