<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Session::get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    public function add($id)
    {
        $carrito = Session::get('carrito', []);

        // Verificar si ya está en el carrito
        foreach ($carrito as $item) {
            if ($item['id_producto'] == $id) {
                Session::flash('error_carrito', 'La película ya está en el carrito');
                return redirect()->route('carrito.index');
            }
        }

        $producto = Producto::find($id);

        if ($producto) {
            $carrito[] = [
                'id_producto' => $producto->id,
                'producto' => $producto
            ];
            Session::put('carrito', $carrito);
        } else {
            return redirect()->route('home');
        }

        return redirect()->route('carrito.index');
    }

    public function delete($index)
    {
        $carrito = Session::get('carrito', []);
        if (isset($carrito[$index])) {
            unset($carrito[$index]);
            Session::put('carrito', array_values($carrito)); // Reindexar
        }
        return redirect()->route('carrito.index');
    }

    public function deleteAll()
    {
        Session::forget('carrito');
        return redirect()->route('carrito.index');
    }
}
