<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Category;
use App\Deposit_product;
use App\Product;
use App\User;
use App\Vat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Sodium\add;

class ProductController extends Controller
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
        $deposito_producto = Deposit_product::all();
        if (Auth::user()->isSuperAdmin()) {
            $productos = Product::all();
        } else if (Auth::user()->isAdmin() || Auth::user()->isCajero()) {
            $productos = Product::where('id', $deposito_producto->id_producto)->get();
        }


        return view('products.listar', ['productos' => $productos]);
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
        $id_categoria = Category::all();
        $id_iva = Vat::all();
        return view('products.crear')->with('id_categoria', $id_categoria)->with('id_iva', $id_iva);
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
        $preciounidad = $request->input('precio_und');
        $preciocjdppk = $request->input('precio_cj_dp');
        $idiva = $request->input('id_iva');
        $cantidad = strtoupper($request->input('cantidad_actual'));
        $vats = Vat::where('id', $idiva)->get();
        $iva = $vats->descripcion;
        $monto = $preciocjdppk;
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
        $monto2 = $preciounidad;
        $monto2 = explode("$ ", $monto2);
        $monto2 = explode(",", $monto2[1]);
        $monto2 = explode(".", $monto2[0]);
        $count_monto2 = count($monto2);
        if ($count_monto2 > 1) {
            $temp = '';
            for ($i = 0; $i < $count_monto2; $i++) {
                $temp .= $monto2[$i];
            }
            $monto2 = $temp;
        } else {
            $monto2 = $monto2[0];
        }
        $utilidad = ($preciounidad * $iva / 100);
        $precioventa = ($utilidad + $preciounidad);
        $monto3 = $precioventa;
        $monto3 = explode("$ ", $monto3);
        $monto3 = explode(",", $monto3[1]);
        $monto3 = explode(".", $monto3[0]);
        $count_monto3 = count($monto3);
        if ($count_monto3 > 1) {
            $temp = '';
            for ($i = 0; $i < $count_monto3; $i++) {
                $temp .= $monto3[$i];
            }
            $monto3 = $temp;
        } else {
            $monto3 = $monto3[0];
        }
        $monto4 = $cantidad;
        $monto4 = explode("$ ", $monto4);
        $monto4 = explode(",", $monto4[1]);
        $monto4 = explode(".", $monto4[0]);
        $count_monto4 = count($monto4);
        if ($count_monto4 > 1) {
            $temp = '';
            for ($i = 0; $i < $count_monto4; $i++) {
                $temp .= $monto4[$i];
            }
            $monto4 = $temp;
        } else {
            $monto4 = $monto4[0];
        }

        Product::create([
            'descripcion' => strtoupper($request->input('descripcion')),
            'codigo_barras' => $request->input('codigo_barras'),
            'marca'=> strtoupper($request->input('marca')),
            'id_categoria' => $request->input('id_categoria'),
            'id_iva' =>$request->input('id_iva'),
            'precio_cj_dp'=> $monto,
            'precio_und' => $monto2,
            'precio_venta' => $monto3,
            'utilidad'=> $utilidad,
            'cantidad_maxima' => strtoupper($request->input('cantidad_maxima')),
            'cantidad_actual' => $monto4,
            'imagen'=> strtoupper($request->input('imagen')),

        ]);

        return redirect('products');
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
