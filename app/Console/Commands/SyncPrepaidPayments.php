<?php

namespace App\Console\Commands;

use App\Agency;
use App\Payment;
use App\Service;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncPrepaidPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:pagos {agencia?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronizar pagos de usuarios prepago';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $param = $this->argument('agencia');
        if (isset($param)) {
            $agencia = Agency::findOrFail($param);
            if ($agencia) {
                if ($agencia) {
                    $abonados = $agencia->subscribers;
                    $servicios = [];
                    foreach ($abonados as $abonado) {
                        $servicios_abonado = $abonado->services;
                        foreach ($servicios_abonado as $service) {
                            array_push($servicios, $service);
                        }
                    }
                    if (count($servicios) > 0) {
                        /** @var Service $servicio */
                        foreach ($servicios as $servicio) {
                            if ($servicio->estado == 1) {
                                $ultimo_pago = Payment::where('service_id', $servicio->id)->orderBy('fecha_pago', 'DESC')->first();
                                if ($ultimo_pago) {
                                    /** @var Carbon $fecha_ultimo_pago */
                                    $fecha_ultimo_pago = $ultimo_pago->fecha_pago;
                                    $fecha_vencimiento_pago = $fecha_ultimo_pago->copy()->addMonth();
                                    $monto_ultimo_pago = $ultimo_pago->monto;
                                    $hoy = Carbon::now();
                                    $mesPasado = $hoy->copy()->subMonth();
                                    $diasMes = $fecha_ultimo_pago->diffInDays($fecha_vencimiento_pago);
                                    $diasTranscurridos = $fecha_ultimo_pago->diffInDays($hoy);

                                    $isBetween = $fecha_ultimo_pago->isBetween($mesPasado, $hoy);

                                    if ($isBetween) {
                                        $plan = $servicio->plan;
                                        $precio_internet = 0;
                                        $precio_tv = 0;

                                        if ($plan->precio_internet) {
                                            $precio_internet = $plan->precio_internet;
                                        }

                                        if ($plan->precio_tv) {
                                            $precio_tv = $plan->precio_tv;
                                        }

                                        $valor_mes = $precio_tv + $precio_internet;

                                        $valor_dia = $valor_mes / $diasMes;

                                        $saldo_restante = $monto_ultimo_pago - ($valor_dia*$diasTranscurridos);

                                        $servicio->saldo = $saldo_restante;

                                        $servicio->save();
                                        \Log::debug("SINCRONIZANDO PAGOS. Agencia: $agencia->nombre, Servicio: $servicio->id, Saldo Restante: $saldo_restante, Valor día: $valor_dia");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $agencias = Agency::where('tipo_facturacion', 'PREPAGO')->where('estado', 'activo')->get();
            if ($agencias) {
                /** @var Agency $agencia */
                foreach ($agencias as $agencia) {
                    if ($agencia) {
                        if ($agencia) {
                            $abonados = $agencia->subscribers;
                            $servicios = [];
                            foreach ($abonados as $abonado) {
                                $servicios_abonado = $abonado->services;
                                foreach ($servicios_abonado as $service) {
                                    array_push($servicios, $service);
                                }
                            }
                            if (count($servicios) > 0) {
                                /** @var Service $servicio */
                                foreach ($servicios as $servicio) {
                                    if ($servicio->estado == 1) {
                                        $ultimo_pago = Payment::where('service_id', $servicio->id)->orderBy('fecha_pago', 'DESC')->first();
                                        if ($ultimo_pago) {
                                            /** @var Carbon $fecha_ultimo_pago */
                                            $fecha_ultimo_pago = $ultimo_pago->fecha_pago;
                                            $fecha_vencimiento_pago = $fecha_ultimo_pago->copy()->addMonth();
                                            $monto_ultimo_pago = $ultimo_pago->monto;
                                            $hoy = Carbon::now();
                                            $mesPasado = $hoy->copy()->subMonth();
                                            $diasMes = $fecha_ultimo_pago->diffInDays($fecha_vencimiento_pago);
                                            $diasTranscurridos = $fecha_ultimo_pago->diffInDays($hoy);

                                            $isBetween = $fecha_ultimo_pago->isBetween($mesPasado, $hoy);

                                            if ($isBetween) {
                                                $plan = $servicio->plan;
                                                $precio_internet = 0;
                                                $precio_tv = 0;

                                                if ($plan->precio_internet) {
                                                    $precio_internet = $plan->precio_internet;
                                                }

                                                if ($plan->precio_tv) {
                                                    $precio_tv = $plan->precio_tv;
                                                }

                                                $valor_mes = $precio_tv + $precio_internet;

                                                $valor_dia = $valor_mes / $diasMes;

                                                $saldo_restante = $monto_ultimo_pago - ($valor_dia*$diasTranscurridos);

                                                $servicio->saldo = $saldo_restante;

                                                $servicio->save();
                                                \Log::debug("SINCRONIZANDO PAGOS. Agencia: $agencia->nombre, Servicio: $servicio->id, Saldo Restante: $saldo_restante, Valor día: $valor_dia");
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
