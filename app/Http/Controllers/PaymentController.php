<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Service;
use App\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;

class PaymentController extends Controller
{
    /**
     * Instantiate controller
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $service_id = $request->input('service');
        if ($service_id) {
            $service = Service::findOrFail($service_id);
            if (\Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
                $pagos = $service->payments()->withTrashed()->orderByDesc('fecha_pago')->get();
            } else {
                $pagos = $service->payments->sortByDesc('fecha_pago');
            }
            return view('payments.listar')->with('pagos', $pagos)->with('service_id', $service_id);
        }

        $subscriber_id = $request->input('subscriber');
        if ($subscriber_id) {
            $subscriber = Subscriber::findOrFail($subscriber_id);
            if (\Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
                $pagos = $subscriber->payments()->withTrashed()->orderByDesc('fecha_pago')->get();
            } else {
                $pagos = $subscriber->payments->sortByDesc('fecha_pago');
            }
            return view('payments.listar')->with('pagos', $pagos)->with('subscriber_id', $subscriber_id);
        }

        $pagos = null;
        if (\Auth::user()->isSuperAdmin()) {
            $pagos = Payment::withTrashed()->get()->sortByDesc('fecha_pago');
        } elseif (\Auth::user()->isAdmin()) {
            $abonados = \Auth::user()->agency->isp->subscribers;
            $pagos = [];
            foreach ($abonados as $abonado) {
                $abonado_pagos = $abonado->payments()->withTrashed()->orderByDesc('fecha_pago')->get();
                if ($abonado_pagos) {
                    foreach ($abonado_pagos as $abonado_pago) {
                        array_push($pagos, $abonado_pago);
                    }
                }
            }
        } else {
            $abonados = \Auth::user()->agency->subscribers;
            $pagos = [];
            foreach ($abonados as $abonado) {
                $abonado_pagos = $abonado->payments->sortByDesc('fecha_pago');
                if ($abonado_pagos) {
                    foreach ($abonado_pagos as $abonado_pago) {
                        array_push($pagos, $abonado_pago);
                    }
                }
            }
        }

        return view('payments.listar')->with('pagos', $pagos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $servicio_id = $request->input('service');
        $servicio = Service::findOrFail($servicio_id);
        $agencia = $servicio->subscriber->agency;

        $hoy = Carbon::now();
        $deuda = null;
        $saldo = null;

        if ($agencia->tipo_facturacion === "PREPAGO") {
            $saldo = $servicio->saldo;
        } else {

            $dia_facturacion = $agencia->dia_facturacion;

            $fecha_facturacion = Carbon::create($hoy->year, $hoy->month, $dia_facturacion);

            $plan = $servicio->plan;
            $precio_internet = 0;
            $precio_tv = 0;
            if ($plan->precio_internet) {
                $precio_internet = $plan->precio_internet;
            }
            if ($plan->precio_tv) {
                $precio_tv = $plan->precio_tv;
            }

            if ($servicio->estado != -1) {
                $fecha_instalacion = $servicio->fecha_instalacion;
                $facturas = $fecha_instalacion->diffInMonths($fecha_facturacion);
                $pagos = $servicio->payments;
                $monto_facturado = $facturas * ($precio_tv + $precio_internet);
                $monto_pagado = 0;
                foreach ($pagos as $pago) {
                    if ($pago) {
                        $monto_pagado += intval($pago->monto);
                    }
                }

                $deuda = intval($monto_facturado) - intval($monto_pagado);
            } else {
                $deuda = 0;
            }

        }

        return view('payments.crear')->with('servicio', $servicio)->with('deuda', $deuda)->with('saldo', $saldo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $servicio_id = $request->input('service');
        $servicio = Service::findOrFail($servicio_id);
        $referencia_pago = $request->input('referencia_pago');
        $reactivar_servicio = $request->input('reactivar_servicio');
        $tipo_pago = $request->input('tipo_pago');

        $monto = $request->input('monto');
        $monto = explode("$ ", $monto);
        $monto = explode(",", $monto[1]);
        $monto = explode(".", $monto[0]);
        $count_monto = count($monto);
        if ($count_monto > 1) {
            $temp = '';
            for ($i = 0; $i < $count_monto; $i++) {
                $temp .= $monto[$i];
            }
            $monto = $temp;
        } else {
            $monto = $monto[0];
        }

        if (!$referencia_pago) {
            $referencia_pago = null;
        }

        $fecha_pago = $request->input('fecha_pago');

        $fecha_pago_parsed = Carbon::createFromFormat('m/d/Y h:i A', $fecha_pago);

        $cajero = Auth::user()->id;

        Payment::create([
            'service_id' => $servicio_id,
            'monto' => intval($monto),
            'fecha_pago' => $fecha_pago_parsed,
            'forma_pago' => $request->input('forma_pago'),
            'tipo_pago' => $tipo_pago,
            'referencia_pago' => $referencia_pago,
            'usuario_cajero_id' => $cajero,
            'descripcion' => strtoupper($request->input('descripcion')),
        ]);

        if ($reactivar_servicio && $servicio->estado == 0) {
            app(ServiceController::class)->toggle($servicio_id);
            return redirect()->route('payments.index', ['service' => $servicio_id]);
        }

        $agencia = $servicio->subscriber->agency;
        $hoy = Carbon::now();

        if ($tipo_pago === "SERVICIOS") {
            if ($agencia->tipo_facturacion === "PREPAGO") {
                $saldo_anterior = $servicio->saldo;
                $saldo_nuevo = $saldo_anterior + $monto;
                $servicio->saldo = $saldo_nuevo;
                $servicio->save();
                if ($saldo_nuevo > 0 && $servicio->estado == 0) {
                    app(ServiceController::class)->toggle($servicio_id);
                }
            } else {
                if ($servicio->estado != -1) {
                    $dia_facturacion = $agencia->dia_facturacion;
                    $facturas_vencidas = $agencia->facturas_vencidas;
                    $fecha_facturacion = Carbon::create($hoy->year, $hoy->month, $dia_facturacion);
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
                    $monto_maximo_permitido = $facturas_vencidas * ($precio_tv + $precio_internet);
                    $monto_pagado = 0;
                    foreach ($pagos as $pago) {
                        if ($pago) {
                            $monto_pagado += intval($pago->monto);
                        }
                    }
                    $monto_pagado += $monto;

                    $deuda = intval($monto_facturado) - intval($monto_pagado);
                    if ($deuda < $monto_maximo_permitido && $servicio->estado == 0) {
                        app(ServiceController::class)->toggle($servicio_id);
                    }
                }
            }
        }


        return redirect()->route('payments.index', ['service' => $servicio_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $payment = Payment::withTrashed()->findOrFail($id);
        $servicio = $payment->service_id;

        if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            if ($payment->trashed()) {
                $payment->restore();
            } else {
                $payment->delete();
            }
        } else {
            if (!$payment->trashed()) {
                $payment->delete();
            } else {
                abort(403, 'No tienes autorización para reactivar un pago');
            }
        }

        return redirect()->route('payments.index', ['service' => $servicio]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot
     */
    public function printTicket($id)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $payment = Payment::findOrFail($id);
        $service = $payment->service;
        $subscriber = $service->subscriber;
        $agency = $subscriber->agency;
        $isp = $agency->isp;

        $logo = base64_encode(file_get_contents(public_path("img/logos/$isp->id.png")));

        $html = view('payments.print')->with('pago', $payment)->with('isp', $isp)->with('logo', $logo)->toHtml();

        $pdfPath = storage_path("pdfs/ticket_temp_$id.pdf");
        Browsershot::html($html)->paperSize(80, 150, 'mm')->save($pdfPath);

        return response()->file($pdfPath)->deleteFileAfterSend();
    }
}
