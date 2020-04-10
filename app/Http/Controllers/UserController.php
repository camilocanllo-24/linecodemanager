<?php

namespace App\Http\Controllers;

use App\Agency;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $this->authorize('viewAny', User::class);

        if (Auth::user()->isSuperAdmin()) {
            $usuarios = User::all();
        } else if (Auth::user()->isAdmin()) {
            $usuarios = Auth::user()->agency->isp->users()->where('rol', '!=', 'superadmin')->get();
        }

        return view('users.listar', ['usuarios' => $usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $agencies = Agency::all();

        return view('users.crear')->with('agencies', $agencies);
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
        $this->authorize('create', User::class);
        $rol = $request->input('rol');

        if (!Auth::user()->isSuperAdmin() && $rol === 'superadmin') {
            abort(403, 'No estas autorizado a asignar el rol de SuperAdmin');
        }

        $agency_id = $request->input('agencia');
        $agency = Agency::findOrFail($agency_id);

        if (Auth::user()->isAdmin()) {
            if (Auth::user()->agency->isp->id !== $agency->isp->id) {
                abort(403, 'La agencia no corresponde a tu ISP');
            }
        }

        User::create([
            'nombres' => strtoupper($request->input('nombres')) . ' ' . strtoupper($request->input('apellidos')),
            'password' => Hash::make($request->input('password')),
            'email' => strtoupper($request->input('email')),
            'agency_id' => $agency_id,
            'estado' => $request->input('estado'),
            'rol' => $rol,
            'fecha_registro' => Carbon::now(),
        ]);

        return redirect('users');
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
        $usuario = User::findOrFail($id);
        $this->authorize('update', [User::class, $usuario]);

        $agencies = Agency::where('id', '!=', $usuario->agency->id)->get();

        return view('users.editar')->with('usuario_id', $id)->with('usuario', $usuario)->with('agencies', $agencies);
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
        /** @var User $usuario */
        $usuario = User::findOrFail($id);

        $this->authorize('update', [User::class, $usuario]);

        $rol = $request->input('rol');

        // SI NO ES SUPERADMIN NO PODRA ASIGNAR ROL DE SUPERADMIN.
        if (!Auth::user()->isSuperAdmin() && $rol === 'superadmin') {
            abort(403, 'No estas autorizado a asignar el rol de SuperAdmin');
        }

        // UN USUARIO NO PUEDE MODIFICAR SU PROPIO ROL.
        if (Auth::user()->id === $usuario->id && Auth::user()->rol !== $usuario->rol) {
            abort(403, 'No estas autorizado a cambiar tu rol');
        }

        $usuario->nombres  = strtoupper($request->input('nombres'));

        if ($request->has('password') && $request->input('password') != '') {
            $usuario->password = Hash::make($request->input('password'));
        }

        $usuario->agency_id  = $request->input('agencia');
        $usuario->email = strtoupper($request->input('email'));
        $usuario->rol  = $rol;
        $usuario->estado = $request->input('estado');

        $usuario->save();

        return redirect()->route('users.edit', $usuario);

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
        $usuario = User::findOrFail($id);

        $this->authorize('delete', [User::class, $usuario]);

        $usuario->delete();

        return redirect('users');
    }
}
