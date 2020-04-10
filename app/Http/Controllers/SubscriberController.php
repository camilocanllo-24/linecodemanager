<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriberController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isSuperAdmin()) {
            $abonados = Subscriber::all()->sortByDesc('created_at');
        } elseif (Auth::user()->isAdmin()) {
          $abonados = Auth::user()->agency->isp->subscribers()->orderByDesc('created_at')->get();
        } elseif (Auth::user()->isOperador() || Auth::user()->isCajero()) {
            $abonados = Subscriber::where('agency_id', Auth::user()->agency->id)->orderByDesc('created_at')->get();
        } elseif (Auth::user()->isTecnico()) {
            abort(404);
        }

        return view('subscribers.listar', ['abonados' => $abonados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $agencies = Agency::all();

        return view('subscribers.crear')->with('agencies', $agencies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $agency = Auth::user()->agency;
        $agency_id = $agency->id;

        if (Auth::user()->isSuperAdmin()) {
            $agency_id = $request->input('agencia');
            $agency = Agency::findOrFail($agency_id);
        } elseif (Auth::user()->isAdmin()) {
            $agency_id = $request->input('agencia');
            $agency = Agency::findOrFail($agency_id);
            if ($agency->isp_id !== Auth::user()->agency->isp_id) {
                abort(403, 'La agencia seleccionada no pertenece a tu ISP');
            }
        } elseif (Auth::user()->isTecnico()) {
            abort(404);
        }

        if ($agency->codigo_abonado_personalizado) {
            $codigoAbonado = $request->input('codigo_abonado_personalizado');
            if ($codigoAbonado) {
                $abonados = Subscriber::where('codigo_abonado', $codigoAbonado)->get();
                if ($abonados->count() > 0) {
                    abort(403, 'El código de abonado ya existe');
                }
            } else {
                abort(403, 'El código del abonado es obligatorio para esta agencia');
            }
        } else {
            $ultimoAbonado = Subscriber::orderBy('created_at', 'DESC')->first();
            $ultimoAbonado = isset($ultimoAbonado) ? $ultimoAbonado->id : 0;
            $codigoAbonado = $ultimoAbonado + 1;
        }

        $primer_nombre = strtoupper($request->input('primer_nombre'));
        $segundo_nombre = strtoupper($request->input('segundo_nombre'));
        $primer_apellido = strtoupper($request->input('primer_apellido'));
        $segundo_apellido = strtoupper($request->input('segundo_apellido'));

        Subscriber::create([
            'codigo_abonado' => $codigoAbonado,
            'primer_nombre' => $this->cleanString($primer_nombre),
            'segundo_nombre' => $this->cleanString($segundo_nombre),
            'primer_apellido' => $this->cleanString($primer_apellido),
            'segundo_apellido' => $this->cleanString($segundo_apellido),
            'tipo_identidad' => strtoupper($request->input('tipo_identidad')),
            'numero_identidad' => $request->input('numero_identidad'),
            'fecha_nacimiento' => Carbon::createFromFormat('m/d/Y', $request->input('fecha_nacimiento')),
            'telefono' => $request->input('telefono'),
            'direccion' => strtoupper($request->input('direccion')),
            'email' => strtoupper($request->input('email')),
            'agency_id' => $agency_id,
            'estado' => $request->input('estado'),
        ]);

        return redirect('subscribers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $abonado = Subscriber::findOrFail($id);

        if (Auth::user()->isAdmin()) {
            $isp = $abonado->agency->isp;
            if ($isp->id !== Auth::user()->agency->isp->id) {
                abort(403, 'El abonado seleccionado no corresponde con su ISP');
            }
        } elseif (Auth::user()->isOperador() || Auth::user()->isCajero()) {
            if ($abonado->agency->id !== Auth::user()->agency->id) {
                abort(403, 'El abonado seleccionado no corresponde con su agencia.');
            }
        } elseif (Auth::user()->isTecnico()) {
            abort(404);
        }

        $agencies = Agency::where('id', '!=', $abonado->agency->id)->get();
        return view('subscribers.editar')->with('abonado_id', $id)->with('abonado', $abonado)->with('agencies', $agencies);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $abonado = Subscriber::findOrFail($id);
        $agency = $abonado->agency;

        if (Auth::user()->isAdmin()) {
            if ($agency->isp_id !== Auth::user()->agency->isp_id) {
                abort(403, 'El abonado seleccionado no corresponde con su ISP');
            }
        } elseif (Auth::user()->isOperador() || Auth::user()->isCajero()) {
            if ($abonado->agency_id !== Auth::user()->agency_id) {
                abort(403, 'El abonado seleccionado no corresponde con su agencia.');
            }
        } elseif (Auth::user()->isTecnico()) {
            abort(404);
        }

        if ($agency->codigo_abonado_personalizado) {
            $codigoAbonado = $request->input('codigo_abonado_personalizado');
            if ($codigoAbonado) {
                $abonados = Subscriber::where('codigo_abonado', $codigoAbonado)->where('id', '!=', $abonado->id)->get();
                if ($abonados->count() > 0) {
                    abort(403, 'El código de abonado ya ha sido asignado a otro abonado');
                }
                $abonado->codigo_abonado = $codigoAbonado;
            }
        }

        $primer_nombre = strtoupper($request->input('primer_nombre'));
        $segundo_nombre = strtoupper($request->input('segundo_nombre'));
        $primer_apellido = strtoupper($request->input('primer_apellido'));
        $segundo_apellido = strtoupper($request->input('segundo_apellido'));

        $email_input = $request->input('email');
        if ($email_input) {
            $abonado->email = strtoupper($email_input);
        }

        $abonado->agency_id  = $request->input('agencia');
        $abonado->primer_nombre = $this->cleanString($primer_nombre);
        $abonado->segundo_nombre = $this->cleanString($segundo_nombre);
        $abonado->primer_apellido = $this->cleanString($primer_apellido);
        $abonado->segundo_apellido = $this->cleanString($segundo_apellido);
        $abonado->tipo_identidad = strtoupper($request->input('tipo_identidad'));
        $abonado->numero_identidad = $request->input('numero_identidad');
        $abonado->fecha_nacimiento = Carbon::createFromFormat('m/d/Y', $request->input('fecha_nacimiento'));
        $abonado->telefono = $request->input('telefono');
        $abonado->direccion = strtoupper($request->input('direccion'));
        $abonado->estado = $request->input('estado');

        $abonado->save();

        return redirect('subscribers');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $abonado = Subscriber::findOrFail($id);

        if (Auth::user()->isCajero() || Auth::user()->isTecnico()) {
            abort(404);
        }

        if (Auth::user()->isAdmin()) {
            $isp = $abonado->agency->isp;
            if ($isp->id !== Auth::user()->agency->isp->id) {
                abort(403, 'El abonado seleccionado no corresponde con su ISP');
            }
        } elseif (Auth::user()->isOperador()) {
            if ($abonado->agency->id !== Auth::user()->agency->id) {
                abort(403, 'El abonado seleccionado no corresponde con su agencia.');
            }
        }

        $servicios = $abonado->services;
        if ($servicios) {
            foreach ($servicios as $servicio) {
                $cpe = $servicio->cpe;
                $credencial = $servicio->credential;
                $tickets = $servicio->tickets;
                $payments = $servicio->payments;
                if ($tickets) {
                    foreach ($tickets as $ticket) {
                        $ticket->delete();
                    }
                }
                if ($payments) {
                    foreach ($payments as $payment) {
                        $payment->delete();
                    }
                }
                if ($cpe) {
                    if ($servicio->ultima_milla === "GPON") {
                        ServiceController::delete_ont($cpe);
                    } else {
                        $cpe->delete();
                    }
                }
                if ($credencial) {
                    $credencial->delete();
                }
                $servicio->delete();
            }
        $abonado->delete();

        }

        return redirect('subscribers');
    }

    function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'A',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'I',
            '/[éèêë]/u'     =>   'E',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'O',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'U',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'C',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'Ñ',
            '/Ñ/'           =>   'Ñ',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }
}
