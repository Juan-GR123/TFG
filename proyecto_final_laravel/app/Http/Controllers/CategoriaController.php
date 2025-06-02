<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;

class CategoriaController extends Controller
{
    public function index()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403);
        }

        $categorias = Categoria::orderByDesc('id')->get();

        return view('categoria.index', compact('categorias'));
    }

    public function crear()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403);
        }

        return view('categoria.crear');
    }

    public function eliminar()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403);
        }

        return view('categoria.eliminar');
    }

    public function save(Request $request)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,100}$/'
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();

        return redirect()->route('categoria.index');
    }

    public function delete($id)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403);
        }

        $categoria = Categoria::findOrFail($id);

        // Eliminar productos asociados y sus pedidos
        foreach ($categoria->productos as $producto) {
            // Obtener todos los pedidos que contienen este producto
            $pedidos = $producto->pedidos;

            foreach ($pedidos as $pedido) {
                // Eliminar las relaciones en la tabla pivote (productos-pedidos)
                $pedido->productos()->detach();

                // Eliminar el pedido
                $pedido->delete();
            }

            // Eliminar el producto después de eliminar sus pedidos
            $producto->delete();
        }

        // Eliminar la categoría
        $categoria->delete();

        return redirect()->route('categoria.index')->with('success', 'Categoría y elementos relacionados eliminados.');
    }

    public function ver($id)
    {
        // Llamamos a la función que limpia pedidos vencidos
        app(PedidoController::class)->eliminarPedidosVencidos();

        $categoria = Categoria::findOrFail($id);

        // Obtener los productos de la categoría
        $productos = Producto::where('categoria_id', $categoria->id)->get();

        // Verificar si el usuario ha alquilado alguna película
        $alquilados = [];

        if (Auth::check()) {
            $usuario_id = Auth::id();

            $pedidos = Pedido::where('usuario_id', $usuario_id)
                ->where('estado', 'pagado')
                ->get();

            foreach ($pedidos as $pedido) {
                foreach ($pedido->productos as $producto) {
                    $alquilados[] = $producto->id;
                }
            }
        }

        return view('categoria.ver', compact('categoria', 'productos', 'alquilados'));
    }

    public function editar($id)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403);
        }

        $categoria = Categoria::findOrFail($id);
        return view('categoria.editar', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,100}$/'
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre;
        $categoria->save();

        return redirect()->route('categoria.index')->with('success', 'Categoría actualizada correctamente.');
    }
}
