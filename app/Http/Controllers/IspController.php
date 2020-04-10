<?php

namespace App\Http\Controllers;

use App\Isp;
use Auth;
use Illuminate\Http\Request;

class IspController extends Controller
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Isp::class);
        $isps = Isp::all();
        return view('isps.listar', ['isps' => $isps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Isp::class);
        return view('isps.crear');
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
        $this->authorize('create', Isp::class);
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'municipio' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'nit' => ['required', 'string', 'max:255'],
            'contacto' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255']
        ]);

        Isp::create([
           'nombre' => strtoupper($request->input('nombre')),
           'direccion' => strtoupper($request->input('direccion')),
           'municipio' => strtoupper($request->input('municipio')),
           'telefono' => $request->input('telefono'),
           'estado' => 'activo',
           'nit' => $request->input('nit'),
           'contacto' => strtoupper($request->input('contacto')),
           'email' => strtoupper($request->input('email'))
        ]);

        return redirect('isps');
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $isp = Isp::findOrFail($id);
        $this->authorize('update', [Isp::class, $isp]);
        return view('isps.editar', ['isp_id' => $id], ['isp' => $isp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $isp = Isp::findOrFail($id);
        $this->authorize('update', [Isp::class, $isp]);
        $isp->nombre  = strtoupper($request->input('nombre'));
        $isp->direccion = strtoupper($request->input('direccion'));
        $isp->municipio = strtoupper($request->input('municipio'));
        $isp->telefono = $request->input('telefono');
        $isp->estado = $request->input('estado');
        $isp->nit = $request->input('nit');
        $isp->contacto = strtoupper($request->input('contacto'));
        $isp->email = strtoupper($request->input('email'));

        $isp->save();

        return redirect('isps');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $isp = Isp::where('id', $id);
        $this->authorize('delete', [Isp::class, $isp]);

        $isp->delete();
        return redirect('isps');
    }
}
