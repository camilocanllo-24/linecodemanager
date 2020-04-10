<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Isp;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class AgencyController extends Controller
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
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Agency::class);
        $agencies = Agency::all();
        return view('agencies.listar', ['agencies' => $agencies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Agency::class);
        $isps = Isp::all();

        return view('agencies.crear')->with('isps', $isps);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Agency::class);

        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'municipio' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'contacto' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'isp' => 'required',
        ]);

        $tipo_facturacion = strtoupper($request->input('tipo_facturacion'));
        $dia_facturacion = $request->input('dia_facturacion');
        $dia_pago = $request->input('dia_pago');
        $dia_corte = $request->input('dia_corte');
        $facturas_vencidas = $request->input('facturas_vencidas');
        $codigo_abonado_personalizado = $request->input('codigo_abonado_personalizado');

        if ($codigo_abonado_personalizado === 'on') {
            $codigo_abonado_personalizado = true;
        } else {
            $codigo_abonado_personalizado = false;
        }

        if ($tipo_facturacion === 'PREPAGO') {
            $dia_facturacion = -1;
            $dia_pago = -1;
            $dia_corte = -1;
            $facturas_vencidas = -1;
        }

        Agency::create([
            'nombre' => strtoupper($request->input('nombre')),
            'direccion' => strtoupper($request->input('direccion')),
            'municipio' => strtoupper($request->input('municipio')),
            'telefono' => $request->input('telefono'),
            'estado' => 'activo',
            'contacto' => strtoupper($request->input('contacto')),
            'email' => strtoupper($request->input('email')),
            'isp_id' => $request->input('isp'),
            'dia_facturacion' => $dia_facturacion,
            'dia_pago' => $dia_pago,
            'dia_corte' => $dia_corte,
            'facturas_vencidas' => $facturas_vencidas,
            'tipo_facturacion' => $tipo_facturacion,
            'codigo_abonado_personalizado' => $codigo_abonado_personalizado
        ]);

        return redirect('agencies');
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
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $agency = Agency::findOrFail($id);
        $this->authorize('update', [Agency::class, $agency]);

        $isps = Isp::where('id', '!=', $agency->isp->id)->get();
        return view('agencies.editar')->with('agency_id', $id)->with('agency', $agency)->with('isps', $isps);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);
        $this->authorize('update', [Agency::class, $agency]);

        $tipo_facturacion = strtoupper($request->input('tipo_facturacion'));
        $dia_facturacion = $request->input('dia_facturacion');
        $dia_pago = $request->input('dia_pago');
        $dia_corte = $request->input('dia_corte');
        $facturas_vencidas = $request->input('facturas_vencidas');

        if ($tipo_facturacion === 'PREPAGO') {
            $dia_facturacion = -1;
            $dia_pago = -1;
            $dia_corte = -1;
            $facturas_vencidas = -1;
        }

        $codigo_abonado_personalizado = $request->input('codigo_abonado_personalizado');

        if ($codigo_abonado_personalizado === 'on') {
            $codigo_abonado_personalizado = true;
        } else {
            $codigo_abonado_personalizado = false;
        }

        $agency->nombre  = strtoupper($request->input('nombre'));
        $agency->direccion = strtoupper($request->input('direccion'));
        $agency->municipio = strtoupper($request->input('municipio'));
        $agency->telefono = $request->input('telefono');
        $agency->estado = $request->input('estado');
        $agency->contacto = strtoupper($request->input('contacto'));
        $agency->email = strtoupper($request->input('email'));
        $agency->isp_id = $request->input('isp');
        $agency->dia_facturacion = $dia_facturacion;
        $agency->dia_pago = $dia_pago;
        $agency->dia_corte = $dia_corte;
        $agency->facturas_vencidas = $facturas_vencidas;
        $agency->tipo_facturacion = $tipo_facturacion;
        $agency->codigo_abonado_personalizado = $codigo_abonado_personalizado;

        $agency->save();

        return redirect('agencies');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $agency = Agency::where('id', $id);
        $this->authorize('delete', [Agency::class, $agency]);
        $agency->delete();
        return redirect('agencies');
    }
}
