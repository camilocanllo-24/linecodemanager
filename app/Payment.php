<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Payment
 *
 * @property-read \App\Service $service
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment query()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $invoice_id
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon $fecha_pago
 * @property string $forma_pago
 * @property string|null $referencia_pago
 * @property int $monto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereFechaPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereFormaPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereReferenciaPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $usuario_cajero_id
 * @property-read \App\User $cajero
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Payment onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payment whereUsuarioCajeroId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Payment withoutTrashed()
 */
class Payment extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id', 'service_id', 'monto', 'fecha_pago', 'forma_pago',
        'referencia_pago', 'usuario_cajero_id', 'descripcion', 'tipo_pago'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'fecha_pago'
    ];

    protected $casts = [
      'fecha_pago' => 'date:m/d/Y h:i A'
    ];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function cajero()
    {
        return $this->belongsTo('App\User', 'usuario_cajero_id', 'id');
    }

    /*public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }*/
}
