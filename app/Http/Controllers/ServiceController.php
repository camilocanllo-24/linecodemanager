<?php

namespace App\Http\Controllers;

use App;
use App\Cpe;
use App\Credential;
use App\Nas;
use App\Olt;
use App\Plan;
use App\Service;
use App\Subscriber;
use App\Ticket;
use App\Inventory;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use phpseclib\Net\SSH2;

class ServiceController extends Controller
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $abonado_id = $request->input('subscriber');
        if ($abonado_id) {
            $abonado = Subscriber::findOrFail($abonado_id);

            $this->authorize('index', [Service::class, $abonado->agency]);

            $servicios = Service::where('abonado_id', $abonado->id)->get();
            return view('services.listar')->with('servicios', $servicios)->with('abonado', $abonado);
        }

        if (Auth::user()->isSuperAdmin()) {
            $servicios = Service::all();
        } elseif (Auth::user()->isAdmin()) {
            $isp = Auth::user()->agency->isp;
            $abonados = $isp->subscribers;
            $servicios = [];
            if ($abonados) {
                foreach ($abonados as $abonado) {
                    $servicios_abonado = $abonado->services;
                    if ($servicios_abonado) {
                        foreach ($servicios_abonado as $servicio_abonado) {
                            array_push($servicios, $servicio_abonado);
                        }
                    }
                }
            }
        } else {
            $agencia = Auth::user()->agency;
            $abonados = $agencia->subscribers;
            $servicios = [];
            if ($abonados) {
                foreach ($abonados as $abonado) {
                    $servicios_abonado = $abonado->services;
                    if ($servicios_abonado) {
                        foreach ($servicios_abonado as $servicio_abonado) {
                            array_push($servicios, $servicio_abonado);
                        }
                    }
                }
            }
        }

        return view('services.listar')->with('servicios', $servicios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $abonado_id = $request->input('subscriber');
        $abonado = Subscriber::findOrFail($abonado_id);

        $usuarios = User::where('agency_id', $abonado->agency_id)->where('rol', '!=', 'superadmin')->get();

        $this->authorize('create', [Service::class, $abonado->agency]);

        $planes = Plan::where('agency_id', $abonado->agency_id)->orderBy('nombre')->get();

        return view('services.crear')->with('abonado', $abonado)->with('planes', $planes)->with('usuarios', $usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $estado = -1;
        $abonado_id = $request->input('abonado_id');
        $plan_id = $request->input('plan_id');
        $plan = Plan::findOrFail($plan_id);
        $ultima_milla = $request->input('ultima_milla');

        if ($ultima_milla === 'SIN DEFINIR' || !$ultima_milla) {
            $ultima_milla = ' ';
        }

        $abonado = Subscriber::findOrFail($abonado_id);
        if ($plan->agency->id != $abonado->agency_id) {
            abort(403, 'El plan no corresponde a la agencia del abonado');
        }

        $this->authorize('create', [Service::class, $abonado->agency]);

        if (($plan->solo_tv && $ultima_milla !== 'CATV') || (!$plan->solo_tv && $ultima_milla === 'CATV')) {
            abort(403, 'La ultima milla no corresponde con el plan seleccionado');
        }

        $servicio = Service::create([
            'abonado_id' => $abonado->id,
            'plan_id' => $plan->id,
            'direccion' => strtoupper($request->input('direccion')),
            'ultima_milla' => $ultima_milla,
            'fecha_subscripcion' => Carbon::createFromFormat('m/d/Y', $request->input('fecha_subscripcion')),
            'telefono' => $request->input('telefono'),
            'estado' => $estado
        ]);
        $primer_nombre = trim($abonado->primer_nombre);
        $primer_apellido = trim($abonado->primer_apellido);
        $primer_nombre = str_replace(" ", "_", $primer_nombre);
        $primer_apellido = str_replace(" ", "_", $primer_apellido);

        // IDABONADO_IDSERVICIO_PRIMERNOMBRE_PRIMERAPELLIDO
        $nombre_usuario = $abonado_id . '_' . $servicio->id . '_' . $primer_nombre . '_' . $primer_apellido;
        $password = $primer_nombre . '' . random_int(100, 999);


        if ($abonado->agency->codigo_abonado_personalizado) {
            $nombre_usuario = $abonado->codigo_abonado . '_' . $primer_nombre . '_' . $primer_apellido;
            $password = $abonado->codigo_abonado . $primer_nombre;
        }

        $sanitized_nombre_usuario = self::cleanString($nombre_usuario);
        $sanitized_password = self::cleanString($password);

        $credencial = Credential::create([
            'nombre_usuario' => $sanitized_nombre_usuario,
            'password' => $sanitized_password,
            'servicio_id' => $servicio->id
        ]);

        // CREAR TICKET

        $estado = 'ASIGNADO';
        $autor = \Auth::user()->id;
        $fecha_estimada_inicio = Carbon::createFromFormat('m/d/Y h:i A', $request->input('fecha_estimada_inicio'));
        $fecha_estimada_cierre = Carbon::createFromFormat('m/d/Y h:i A', $request->input('fecha_estimada_cierre'));

        $usuario_asignado = $request->input('usuario_asignado_id');

        if ($usuario_asignado === 'SIN DEFINIR') {
            $usuario_asignado = null;
            $estado = 'PENDIENTE';
        }

        Ticket::create([
            'service_id' => $servicio->id,
            'descripcion' => '',
            'tipo' => 'INSTALACION',
            'motivo' => 'CONEXIÓN PRIMERA VEZ SERVICIO',
            'fecha_estimada_inicio' => $fecha_estimada_inicio,
            'fecha_estimada_cierre' => $fecha_estimada_cierre,
            'prioridad' => 'MEDIA',
            'estado' => $estado,
            'usuario_autor_id' => $autor,
            'usuario_asignado_id' => $usuario_asignado
        ]);

        return redirect()->route('services.index', ['subscriber' => $abonado_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
        abort_if(Auth::user()->isTecnico(), 404);
        $servicio = Service::findOrFail($id);
        $this->authorize('update', [Service::class, $servicio]);
        $abonado = $servicio->subscriber;
        $planes = Plan::where('id', '!=', $servicio->plan->id)
            ->where('agency_id', $abonado->agency->id)->orderBy('nombre')->get();
        $onts = $this->get_onts($servicio);
        $new_ont = null;
        if ($servicio->ultima_milla === "GPON") {
            $ont = $servicio->cpe;
            if ($ont) {
                $new_ont = new \stdClass();
                $new_ont->olt = $ont->olt;
                $new_ont->board = $ont->board_olt;
                $new_ont->puerto = $ont->puerto_olt;
                $new_ont->serial = $ont->serial;
                $new_ont->selected = true;
                $new_ont->optical_info = $this->get_ont_optical_info($ont);
            }
        }
        return view('services.editar')->with('servicio_id', $id)->with('servicio', $servicio)->with('abonado', $abonado)->with('planes', $planes)->with('onts', $onts)->with('ont', $new_ont);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $servicio = Service::findOrFail($id);
        $this->authorize('update', [Service::class, $servicio]);
        $abonado = $servicio->subscriber;
        $estado = $request->input('estado');
        $ultima_milla = $request->input('ultima_milla');

        if ($estado == 'Activo') {
            $estado = 1;
        } else if ($estado == 'Inactivo') {
            abort(403, 'No se puede editar un servicio inactivo');
        }

        if (!$ultima_milla) {
            abort(403, 'Debe elegir la ultima milla');
        }

        $plan = $servicio->plan_id;
        $plan_nuevo = $request->input('plan_id');
        $plan_nuevo_obj = Plan::findOrFail($plan_nuevo);
        $username = $servicio->credential->nombre_usuario;

        if (($plan_nuevo_obj->solo_tv && $ultima_milla != 'CATV') || (!$plan_nuevo_obj->solo_tv && $ultima_milla == 'CATV')) {
            abort(403, 'La ultima milla no corresponde con el plan seleccionado');
        }

        if ($plan != $plan_nuevo) {

            $nas = Nas::find($servicio->last_nas_id);

            $servicio->estado = 0;
            $servicio->save();

            if ($nas) {
                $this->disconnect_user($username, $servicio->framed_ip_address, $nas->ip, $nas->puerto, $nas->secret);
            }

        }

        if ($request->input('ultima_milla') === "GPON") {
            $olt_id = $request->input('olt');
            $board = $request->input('olt_board');
            $puerto = $request->input('olt_puerto');
            $serial = $request->input('ont');

            if (!isset($olt_id) || !isset($board) || !isset($puerto) || !isset($serial)) {
                abort(403, 'Debe elegir una ONT para activar el servicio');
            }

            $cpe_actual = $servicio->cpe;

            $cpe = Cpe::where('olt_id', $olt_id)
                ->where('board_olt', $board)
                ->where('puerto_olt', $puerto)
                ->where('serial', $serial)->first();

            if ($cpe) {
                if ($plan != $plan_nuevo) {
                    $nuevo_plan = Plan::findOrFail($plan_nuevo);
                    $catv_off = $nuevo_plan->tv == 0;
                    $this->toggle_ont_catv_port($cpe, $catv_off);
                }
            } else {
                $olt = Olt::findOrFail($olt_id);
                $nuevo_plan = Plan::findOrFail($plan_nuevo);
                $catv_off = $nuevo_plan->tv == 0;

                // SI YA TIENE UN CPE ENTONCES HAY QUE CAMBIARLO POR EL NUEVO
                if ($cpe_actual) {
                    $eliminar_ont = self::delete_ont($cpe_actual);
                    if ($eliminar_ont) {
                        $this->register_ont($servicio, $olt, $board, $puerto, $serial, $username, $catv_off);
                    }
                } else {
                    $this->register_ont($servicio, $olt, $board, $puerto, $serial, $username, $catv_off);
                }
            }
        }

        $servicio->plan_id = $plan_nuevo;
        $servicio->direccion = strtoupper($request->input('direccion'));
        $servicio->ultima_milla = $ultima_milla;
        $servicio->fecha_subscripcion = Carbon::createFromFormat('m/d/Y', $request->input('fecha_subscripcion'));
        $servicio->fecha_instalacion = Carbon::createFromFormat('m/d/Y', $request->input('fecha_instalacion'));
        $servicio->telefono = $request->input('telefono');

        if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            if ($request->has('saldo')) {
                $saldo = intval($request->input('saldo'));
                if ($saldo >= 0) {
                    $servicio->saldo = $saldo;
                } else {
                    $servicio->saldo = 0;
                }
            }
        }

        $servicio->estado = $estado;

        $servicio->save();

        return redirect()->route('services.index', ['subscriber' => $abonado->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy($id)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $servicio = Service::findOrFail($id);
        $this->authorize('delete', [Service::class, $servicio]);
        $abonado = $servicio->subscriber;
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
                self::delete_ont($cpe);
            } else {
                $cpe->delete();
            }
        }
        if ($credencial) {
            $credencial->delete();
        }
        $servicio->delete();

        return redirect()->route('services.index', ['subscriber' => $abonado->id]);

    }

    /**
     * Activa/Deshabilita un servicio
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function toggle($id)
    {
        abort_if(Auth::user()->isTecnico(), 404);
        $servicio = Service::findOrFail($id);
        $abonado = $servicio->subscriber;

        $this->authorize('update', [Service::class, $servicio]);

        if ($servicio->estado == 1) {
            $servicio->estado = 0;
            $servicio->save();

            $username = $servicio->credential->nombre_usuario;

            $nas = Nas::find($servicio->last_nas_id);

            if ($servicio->ultima_milla === "GPON") {
                if ($servicio->plan->tv == 1) {
                    $this->toggle_ont_catv_port($servicio->cpe, true);
                }
            }

            if ($nas) {
                $this->disconnect_user($username, $servicio->framed_ip_address,
                    $nas->ip, $nas->puerto, $nas->secret);
            }
        } elseif ($servicio->estado == 0) {
            $servicio->estado = 1;
            if ($servicio->ultima_milla === "GPON") {
                if ($servicio->plan->tv == 1) {
                    $this->toggle_ont_catv_port($servicio->cpe, false);
                }
            }
            $servicio->save();
        } elseif ($servicio->estado == -1) {
            $planes = Plan::where('id', '!=', $servicio->plan->id)
                ->where('agency_id', $abonado->agency->id)->get();
            $onts = $this->get_onts($servicio);
            $new_ont = null;
            if ($servicio->ultima_milla === "GPON") {
                $ont = $servicio->cpe;
                if ($ont) {
                    $new_ont = new \stdClass();
                    $new_ont->olt = $ont->olt;
                    $new_ont->board = $ont->board_olt;
                    $new_ont->puerto = $ont->puerto_olt;
                    $new_ont->serial = $ont->serial;
                    $new_ont->selected = true;
                    $new_ont->optical_info = $this->get_ont_optical_info($ont);
                }
            }
            return view('services.editar')->with('servicio_id', $id)->with('servicio', $servicio)->with('abonado', $abonado)->with('planes', $planes)->with('onts', $onts)->with('ont', $new_ont);
        }

        return redirect()->route('services.index', ['subscriber' => $abonado->id]);

    }

    /**
     * Suspende un servicio
     *
     * @param int $id
     * @return bool
     */
    public static function suspender_servicio($id)
    {
        $servicio = Service::findOrFail($id);

        if ($servicio->estado == 1) {
            $servicio->estado = 0;
            $servicio->save();

            $username = $servicio->credential->nombre_usuario;

            $nas = Nas::find($servicio->last_nas_id);

            if ($servicio->ultima_milla === "GPON") {
                if ($servicio->plan->tv == 1) {

                    self::toggle_ont_catv_port($servicio->cpe, true);
                }
            }

            if ($nas) {
                self::disconnect_user($username, $servicio->framed_ip_address,
                    $nas->ip, $nas->puerto, $nas->secret);
            }
            return true;
        }

        return false;

    }

    /**
     * @param $id
     * @return \Response
     */
    function admin_disconnect_user($id)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperAdmin() || $user->isAdmin();
        abort_unless($isAdmin, 403);

        $servicio = Service::findOrFail($id);

        if ($user->isAdmin()) {
            $isp = $user->agency->isp_id;
            $agency = $servicio->agency;

            abort_unless($isp == $agency->isp_id, 403);
        }

        $username = $servicio->credential->nombre_usuario;
        $framed_ip_address = $servicio->framed_ip_address;
        $servicio->pppoe_status = 'desconectado';
        $servicio->framed_ip_address = null;

        $servicio->save();

        $nas = Nas::find($servicio->last_nas_id);

        if ($nas) {
            self::disconnect_user($username, $framed_ip_address,
                $nas->ip, $nas->puerto, $nas->secret);
        }

        return redirect()->back();
    }

    public static function disconnect_user($username, $framed_ip, $nasaddr, $coaport, $sharedsecret)
    {
        $command = "echo User-Name=$username,Framed-IP-Address=$framed_ip|/usr/bin/radclient -x $nasaddr:$coaport disconnect $sharedsecret";
        exec($command);
    }

    function register_ont(Service $service, Olt $olt, $board, $puerto, $serial, $nombre, $catv_off = false)
    {
        $marca = strtoupper($olt->marca);
        $result = false;
        $ont_next_id = null;
        if ($marca === 'PREVAIL') {
            $ont_next_id = $this->search_next_ont_id_prevail($olt, $board, $puerto);
            if ($ont_next_id == -1) {
                abort(403, "El puerto $board/$puerto ha excedido el limite de ONTs.");
            }
            $result = $this->register_ont_prevail($olt, $board, $puerto, $ont_next_id, $serial, $nombre, $catv_off);
        } elseif ($marca === 'HUAWEI') {

        } elseif ($marca === 'CDATA') {

        } elseif ($marca === 'KINGTYPE') {

        } else {
            abort(403, 'La OLT seleccionada no está soportada.');
        }

        if ($result) {
            Cpe::create([
                'tipo' => 'ont',
                'service_id' => $service->id,
                'serial' => $serial,
                'olt_id' => $olt->id,
                'board_olt' => $board,
                'puerto_olt' => $puerto,
                'indice_ont' => $ont_next_id
            ]);
        }
    }

    /**
     * @param Cpe $ont
     * @return bool
     * @throws \Exception
     */
    public static function delete_ont(Cpe $ont)
    {
        $olt = $ont->olt;
        $marca = strtoupper($olt->marca);
        $board = $ont->board_olt;
        $puerto = $ont->puerto_olt;
        $indice = $ont->indice_ont;
        $serial = $ont->serial;
        $result = false;

        if ($marca === 'PREVAIL') {
            $result = self::delete_ont_prevail($olt, $board, $puerto, $indice, $serial);
            self::toggle_ont_catv_port($ont, false);
        } elseif ($marca === 'HUAWEI') {

        } elseif ($marca === 'CDATA') {

        } elseif ($marca === 'KINGTYPE') {

        } else {
            abort(403, 'La OLT seleccionada no está soportada.');
        }

        if ($result) {
            $ont->delete();
            return true;
        }
        return false;
    }

    public static function delete_ont_prevail(Olt $olt, $board, $puerto, $indice, $serial)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username, $olt->password)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        $ssh->write($olt->password . PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("configure terminal\n");
        $ssh->write("deploy profile rule\n");
        $ssh->write("delete aim $board/$puerto/$indice\n");
        $ssh->write("y\n");
        $ssh->write("show deploy rule brief interface gpon $board/$puerto\n");
        $ssh->setTimeout(2);
        $output = $ssh->read();
        $re = "/$board\/$puerto\/$indice\b\s+\b\w+\b\s+\b\w+\s+\b($serial)/m";
        preg_match_all($re, $output, $matches, PREG_SET_ORDER, 0);
        if (count($matches) == 0) {
            return true;
        }
        return false;
    }

    public static function toggle_ont_catv_port(Cpe $ont, $shutdown)
    {
        /** @var Olt $olt */
        $olt = $ont->olt;
        $marca = strtoupper($olt->marca);
        $board = $ont->board_olt;
        $puerto = $ont->puerto_olt;
        $indice = $ont->indice_ont;

        if ($marca === 'PREVAIL') {
            self::toggle_ont_catv_port_prevail($olt, $board, $puerto, $indice, $shutdown);
        } elseif ($marca === 'HUAWEI') {

        } elseif ($marca === 'CDATA') {

        } elseif ($marca === 'KINGTYPE') {

        } else {
            abort(403, 'La OLT seleccionada no está soportada.');
        }
    }

    public static function get_ont_optical_info(Cpe $ont)
    {
        /** @var Olt $olt */
        $olt = $ont->olt;
        $marca = strtoupper($olt->marca);
        $board = $ont->board_olt;
        $puerto = $ont->puerto_olt;
        $indice = $ont->indice_ont;

        $optical_info = null;
        if ($marca === 'PREVAIL') {
            $optical_info = self::get_ont_optical_info_prevail($olt, $board, $puerto, $indice);
        } elseif ($marca === 'HUAWEI') {

        } elseif ($marca === 'CDATA') {

        } elseif ($marca === 'KINGTYPE') {

        } else {
            abort(403, 'La OLT seleccionada no está soportada.');
        }

        return $optical_info;
    }

    /**
     * @param Olt $olt
     * @param int $board
     * @param int $puerto
     * @param int $indice
     * @return \stdClass|null
     */
    private static function get_ont_optical_info_prevail(Olt $olt, $board, $puerto, $indice)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        $ssh->write($olt->password . PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("configure terminal\n");
        $ssh->write("show ont optical-info $board/$puerto/$indice\n");

        // REGEXP PARA SHOW ONT OPTICAL-INFO INTERFACE GPON ALL
        $re = "/$board\/$puerto\/$indice\s+(-?\d+.?\d+)\s+(-?\d+.?\d+)\s+(-?\d+.?\d+)\s+(-?\d+.?\d+)/m";

        // REGEX PARA SHOW ONT OPTICAL-INFO $BOARD/$PUERTO/$INDICE
        $re = '/\b.+\s+:\s+(.?\d+.?\d?\d?)/m';
        $ssh->setTimeout(2);
        $output = $ssh->read();
        preg_match_all($re, $output, $matches, PREG_SET_ORDER, 0);
        $optical_info = new \stdClass();
        if (count($matches) == 0) {
            $optical_info->voltage = 0;
            $optical_info->rx_power = 0;
            $optical_info->tx_power = 0;
            $optical_info->catv_power = 0;
            return $optical_info;
        }
        $optical_info->voltage = $matches[0][1];
        $optical_info->rx_power = $matches[1][1];
        $optical_info->tx_power = $matches[2][1];

        if (!isset($matches[5])) {
            $optical_info->catv_power = 0;
            return $optical_info;
        }

        $optical_info->catv_power = str_replace("\r", "", $matches[5][1]);
        return $optical_info;
    }

    public static function toggle_ont_catv_port_prevail(Olt $olt, $board, $puerto, $indice, $shutdown)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username, $olt->password)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        $ssh->write($olt->password . PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("configure terminal\n");
        $ssh->write("deploy profile unique\n");
        $ssh->write("aim $board/$puerto/$indice\n");
        if ($shutdown) {
            $ssh->write("local shutdown catv-port 1\n");
            $ssh->write("active\n");
            $ssh->write("exit\n");
        } else {
            $ssh->write("no local shutdown catv-port 1\n");
            $ssh->write("active\n");
            $ssh->write("y\n");
            $ssh->write("exit\n");
            self::delete_profile_unique_prevail($olt, $board, $puerto, $indice);
        }
        $ssh->write("end\n");
        $ssh->write("copy running-config startup-config\n");
        $ssh->write("y\n");
        $ssh->setTimeout(2);
        $ssh->read();
    }

    public static function delete_profile_unique_prevail(Olt $olt, $board, $puerto, $indice)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username, $olt->password)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        $ssh->write($olt->password . PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("configure terminal\n");
        $ssh->write("deploy profile unique\n");
        $ssh->write("delete aim $board/$puerto/$indice\n");
        $ssh->write("end\n");
        $ssh->write("copy running-config startup-config\n");
        $ssh->write("y\n");
        $ssh->setTimeout(2);
        $ssh->read();
    }

    function save_configuration_prevail(Olt $olt)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username, $olt->password)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        $ssh->write($olt->password . PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("copy running-config startup-config\n");
        $ssh->write("y\n");
        $ssh->setTimeout(2);
        $ssh->read();
    }

    function get_onts(Service $servicio)
    {
        $onts = [];
        $olts = Olt::whereAgencyId($servicio->subscriber->agency_id)->get();
        /** @var Olt $olt */
        foreach ($olts as $olt) {
            if ($olt->marca === 'PREVAIL') {
                $result_onts = $this->get_onts_prevail($olt);
                foreach ($result_onts as $ont) {
                    array_push($onts, $ont);
                }
            }
        }
        return $onts;
    }

    function get_onts_prevail(Olt $olt)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username, $olt->password)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        //$ssh->enablePTY();
        $ssh->write($olt->password . PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("configure terminal\n");
        $ssh->write("show ont-find list interface gpon all\n");
        $re = '/\bg(\d)\/\b(\d+)\b\s+(\d)\s+\b(\w+-\w+)\s+(\w+\/\w+\/\w+)\s+(\w+\:\w+\:\w+)\s+(\w+)/m';
        $ssh->setTimeout(2);
        $output = $ssh->read();
        preg_match_all($re, $output, $matches, PREG_SET_ORDER, 0);
        $onts = [];
        if (count($matches) == 0) {
            return $onts;
        }
        foreach ($matches as $match) {
            $ont = new \stdClass();
            $ont->olt = $olt;
            $ont->board = $match[1];
            $ont->puerto = $match[2];
            $ont->serial = $match[4];
            array_push($onts, $ont);
        }
        return $onts;
    }

    function search_next_ont_id_prevail(Olt $olt, $board, $puerto)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        //$ssh->enablePTY();
        $ssh->write($olt->password . PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("configure terminal\n");
        $ssh->write("show deploy rule brief interface gpon $board/$puerto\n");
        $ssh->setTimeout(2);
        $output = $ssh->read();
        $re = "/$board\/$puerto\/\b(\d+)/m";
        preg_match_all($re, $output, $matches, PREG_SET_ORDER, 0);
        if (count($matches) == 0) {
            return 1;
        }
        $match_index = count($matches) - 1;
        for ($i = 0; $i <= $match_index; $i++) {
            $indice = ($matches[$i])[1];
            if ($indice != $i + 1) {
                return $i + 1;
            }
        }
        $last_id = ($matches[$match_index])[1];
        if ($last_id == 128) {
            return -1;
        }
        $next_id = $last_id + 1;
        return $next_id;
    }

    function register_ont_prevail(Olt $olt, $board, $puerto, $indice, $serial, $nombre, $catv_off)
    {
        $ssh = new SSH2($olt->ip, $olt->puerto);
        if (!$ssh->login($olt->username)) {
            // ERROR
            Log::debug("Error al conectarse a la OLT: $olt->identificador");
        }
        //$ssh->enablePTY();
        $ssh->write($olt->password .PHP_EOL);
        $ssh->write("enable\n");
        $ssh->write("configure terminal\n");
        $ssh->write("deploy profile rule\n");
        $ssh->write("aim $board/$puerto/$indice name $nombre\n");
        $ssh->write("permit sn string-hex $serial line 1 default line 1\n");
        $ssh->write("active\n");
        $ssh->write("show deploy rule brief interface gpon $board/$puerto\n");
        $ssh->write("exit\n");
        $ssh->write("exit\n");
        if ($catv_off) {
            $ssh->write("deploy profile unique\n");
            $ssh->write("aim $board/$puerto/$indice\n");
            $ssh->write("local shutdown catv-port 1\n");
            $ssh->write("active\n");
            $ssh->write("exit\n");
            $ssh->write("exit\n");
        }
        $ssh->write("exit\n");
        $ssh->write("copy running-config startup-config\n");
        $ssh->write("y\n");
        $ssh->setTimeout(2);
        $output = $ssh->read();
        $re = "/$board\/$puerto\/$indice\b\s+\b\w+\b\s+\b\w+\s+\b($serial)/m";
        preg_match_all($re, $output, $matches, PREG_SET_ORDER, 0);
        if (count($matches) == 0) {
            return false;
        }

        return true;
    }

    public static function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }
}
