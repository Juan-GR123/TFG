<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Helpers\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Mail\PedidoConfirmado;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    public function hacer()
    {
        return view('pedido.hacer');
    }



    private function getPayPalProvider()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials([
            'mode' => config('services.paypal.mode'),  // Aquí debería usar el valor 'sandbox' o 'live'
            'sandbox' => [
                'client_id'     => config('services.paypal.client_id'),
                'client_secret' => config('services.paypal.secret'),
            ],
            'payment_action' => 'Sale',
            'currency'       => config('services.paypal.currency'),
            'notify_url'     => '', // URL opcional para las notificaciones IPN de PayPal
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ]);

        $provider->getAccessToken();

        return $provider;
    }


    public function pagar(Request $request)
    {
        if (Auth::check()) {
            $usuario_id = Auth::id();
            $provincia = $request->input('provincia');
            $localidad = $request->input('localidad');
            $direccion = $request->input('direccion');
            $tiempo = $request->input('tiempo');

            // Mostrar carrito
            $mostrar = Utils::Carrito_mostrar();
            $productosCount = $mostrar['count'];

            if ($productosCount <= 0) {
                return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
            }

            $costeAdicional = $productosCount * $tiempo * 10;
            $costeTotal = $costeAdicional;

            // Guardamos los datos en sesión temporal para después del pago
            Session::put('pedido_temp', [
                'provincia' => $provincia,
                'localidad' => $localidad,
                'direccion' => $direccion,
                'coste' => $costeTotal,
                'tiempo' => $tiempo
            ]);

            $provider = $this->getPayPalProvider();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('pedido.realizado'),
                    "cancel_url" => route('pedido.cancelar'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => config('services.paypal.currency'),
                            "value" => $costeTotal
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) { 
                foreach ($response['links'] as $link) { //Aquí se recorren todos los enlaces que PayPal incluye en la respuesta. Cada uno tiene un propósito distinto.
                    if ($link['rel'] === 'approve') {//Esto busca el link que tenga aprove para autorizar el pago
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('pedido.hacer')->with('error', 'No se pudo conectar con PayPal.');
        }

        return redirect('/');
    }

    public function cancelar()
    {
        Session::forget('pedido_temp');
        Session::put('pedido', 'failed');
        return redirect()->route('pedido.hacer');
    }

    public function realizado(Request $request)
    {
        $provider = $this->getPayPalProvider();
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            // Pago correcto
            if (Session::has('pedido_temp') && Auth::check()) {
                $pedidoData = Session::get('pedido_temp');
                $usuario_id = Auth::id();

                $pedido = new Pedido();
                $pedido->usuario_id = $usuario_id;
                $pedido->provincia = $pedidoData['provincia'];
                $pedido->localidad = $pedidoData['localidad'];
                $pedido->direccion = $pedidoData['direccion'];
                $pedido->coste = $pedidoData['coste'];
                $pedido->estado = 'pagado';
                $pedido->fecha = now();
                $pedido->hora = now()->format('H:i:s');
                $pedido->tiempo_alquiler = $pedidoData['tiempo'];

                if ($pedido->save()) {
                    $pedido->guardarLineasDesdeSesion();
                    Session::forget('carrito');
                    Session::forget('pedido_temp');
                    Session::put('pedido_id', $pedido->id);
                    Session::put('pedido', 'complete');

                    // Enviar correo de confirmación
                    $productos = $pedido->productos()->get();
                    Mail::to(Auth::user()->email)->send(new PedidoConfirmado($pedido, $productos));

                    return redirect()->route('pedido.confirmado');
                }
            }
        }

        Session::put('pedido', 'failed');
        return redirect()->route('pedido.hacer');
    }



    public function confirmado()
    {
        // Llamamos a la función que limpia pedidos vencidos
        app(PedidoController::class)->eliminarPedidosVencidos();

        if (Auth::check()) {
            $usuario_id = Auth::id();
            $pedido_id = Session::get('pedido_id');

            if ($pedido_id) {
                $pedido = Pedido::find($pedido_id);

                // Verificamos que el pedido exista y pertenezca al usuario
                if (!$pedido || $pedido->usuario_id !== $usuario_id) {
                    Session::put('pedido', 'failed');
                    return redirect()->route('producto.index');
                }

                $productos = $pedido->productos()->get();

                return view('pedido.confirmado', compact('pedido', 'productos'));
            }
        }

        return redirect('/');
    }

    public function misPedidos()
    {
        Utils::identidad_comprobar();

        $usuario_id = Auth::id();
        $pedidos = Pedido::where('usuario_id', $usuario_id)->orderBy('id', 'desc')->get();

        return view('pedido.pedidos', compact('pedidos'));
    }

    public function detalle($id)
    {
        // Llamamos a la función que limpia pedidos vencidos
        app(PedidoController::class)->eliminarPedidosVencidos();


        Utils::identidad_comprobar();

        $pedido = Pedido::findOrFail($id);


        $productos = $pedido->productos()->get();

        return view('pedido.detalle', compact('pedido', 'productos'));
    }

    public function gestion()
    {
        Utils::isAdmin();

        $pedidos = Pedido::orderBy('id', 'desc')->get();

        return view('pedido.pedidos', ['pedidos' => $pedidos, 'gestion' => true]);
    }

    public function estadoPedidos(Request $request)
    {
        Utils::isAdmin();

        $id = $request->input('pedido_id');
        $estado = $request->input('estado');

        $pedido = Pedido::find($id);
        if ($pedido) {
            $pedido->estado = $estado;
            $pedido->save();
        }

        return redirect()->route('pedido.detalle', ['id' => $id]);
    }

    public function eliminar($id)
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $pedido = Pedido::find($id);

            if ($pedido && ($pedido->usuario_id == $usuario->id || $usuario->rol === 'admin')) {
                $pedido->delete(); // Deberías tener relaciones y cascada configurada para eliminar líneas
                Session::put('pedido', 'eliminado');
            } else {
                Session::put('pedido', 'failed');
            }
        } else {
            Session::put('pedido', 'failed');
            return redirect('/');
        }

        return redirect()->route('pedido.mis_pedidos');
    }

    public function cancelado()
    {
        if (Auth::check()) {
            $usuario = Auth::user();

            // Obtener el ID del pedido temporal de la sesión
            $pedido_id = Session::get('pedido_id');

            if ($pedido_id) {
                // Buscar el pedido en la base de datos
                $pedido = Pedido::find($pedido_id);

                if ($pedido && $pedido->usuario_id == $usuario->id) {
                    // Eliminar el pedido de la base de datos
                    $pedido->delete();

                    // Eliminar el pedido de la sesión
                    Session::forget('pedido_id');
                    Session::forget('pedido_temp');
                    Session::put('pedido', 'eliminado');

                    // Redirigir a la página de pedidos o a la página principal
                    return redirect()->route('pedido.mis_pedidos');
                } else {
                    Session::put('pedido', 'failed');
                }
            }
        }

        // Si no se encuentra el pedido o el usuario no es válido
        Session::put('pedido', 'failed');
        return redirect()->route('pedido.hacer');
    }


    public function eliminarPedidosVencidos()
    {
        $usuario_id = Auth::id();
        $pedidos = Pedido::where('usuario_id', $usuario_id)->get();

        foreach ($pedidos as $pedido) {
            if (!$pedido->tieneAcceso()) {
                $pedido->delete();
            }
        }
    }
}
