<?php

namespace App\Console\Commands;

use App\Agency;
use App\Http\Controllers\ServiceController;
use App\Service;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SuspendServicesWithDebt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suspender:morosos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suspender servicios morosos';

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
     */
    public function handle()
    {
        $agencias = Agency::whereEstado('activo')->get();
        if ($agencias) {
            /** @var Agency $agencia */
            foreach ($agencias as $agencia) {
                if ($agencia) {
                    $tipo_facturacion = $agencia->tipo_facturacion;
                    if ($tipo_facturacion === 'PREPAGO') {
                        $abonados = $agencia->subscribers;
                        $servicios = [];
                        foreach ($abonados as $abonado) {
                            $servicios_abonado = $abonado->services;
                            foreach ($servicios_abonado as $service) {
                                array_push($servicios, $service);
                            }
                        }
                        if (count($servicios) > 0) {
                            foreach ($servicios as $servicio) {
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

                                if ($servicio->estado == 1 && $servicio->saldo <= 0 && $valor_mes > 0) {
                                    ServiceController::suspender_servicio($servicio->id);
                                    \Log::debug("FACTURACION PREPAGO. Agencia: $agencia->nombre, Servicio suspendido: $servicio->id");
                                }
                            }
                        }
                    } else {
                        $dia_corte = $agencia->dia_corte;
                        $dia_facturacion = $agencia->dia_facturacion;
                        $facturas_vencidas = $agencia->facturas_vencidas;
                        $hoy = Carbon::now();
                        $fecha_facturacion = Carbon::create($hoy->year, $hoy->month, $dia_facturacion);
                        if ($dia_corte == $hoy->day) {
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
                                        $plan = $servicio->plan;
                                        $precio_internet = 0;
                                        $precio_tv = 0;
                                        if ($plan->precio_internet) {
                                            $precio_internet = $plan->precio_internet;
                                        }
                                        if ($plan->precio_tv) {
                                            $precio_tv = $plan->precio_tv;
                                        }
                                        $fecha_instalacion = $servicio->fecha_instalacion;
                                        $facturas = $fecha_instalacion->diffInMonths($fecha_facturacion);
                                        $pagos = $servicio->payments;
                                        $monto_facturado = $facturas * ($precio_tv + $precio_internet);
                                        $monto_pagado = 0;
                                        $monto_maximo_permitido = $facturas_vencidas * ($precio_tv + $precio_internet);
                                        foreach ($pagos as $pago) {
                                            if ($pago) {
                                                $monto_pagado += intval($pago->monto);
                                            }
                                        }

                                        \Log::debug("FACTURACION POSTPAGO DE $agencia->nombre Servicio: $servicio->id, Facturas: $facturas, Monto Pagado: $monto_pagado, Monto Maximo Permitido: $monto_maximo_permitido");

                                        if ($facturas >= 1) {
                                            if ($monto_pagado <= $monto_maximo_permitido) {
                                                ServiceController::suspender_servicio($servicio->id);
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
