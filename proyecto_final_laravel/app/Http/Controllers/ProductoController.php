<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pedido;

class ProductoController extends Controller
{
    public function index()
    {
        // Llamamos a la función que limpia pedidos vencidos
        app(PedidoController::class)->eliminarPedidosVencidos();

        $productos = Producto::inRandomOrder()->limit(6)->get();

        $alquilados = [];

        if (Auth::check()) {
            $usuario_id = Auth::id();

            $pedidos = Pedido::where('usuario_id', $usuario_id)
                ->where('estado', 'pagado')
                ->get();

            foreach ($pedidos as $pedido) {
                if ($pedido->tieneAcceso()) {
                    foreach ($pedido->productos as $producto) {
                        $alquilados[] = $producto->id;
                    }
                }
            }
        }

        return view('producto.destacados', compact('productos', 'alquilados'));
    }


    public function ver($id)
    {
        // Llamamos a la función que limpia pedidos vencidos
        app(PedidoController::class)->eliminarPedidosVencidos();


        $producto = Producto::findOrFail($id);
        $alquilado = false;
        $archivo = null;

        if (Auth::check()) {
            $usuario_id = Auth::id();

            $pedidos = Pedido::where('usuario_id', $usuario_id)
                ->where('estado', 'pagado')
                ->get();

            foreach ($pedidos as $pedido) {
                if ($pedido->productos()->where('producto_id', $producto->id)->exists()) {
                    $alquilado = true;
                    $archivo = $producto->pelicula; // Asegúrate de que este campo exista en la tabla productos
                    break;
                }
            }
        }

        return view('producto.ver', compact('producto', 'alquilado', 'archivo'));
    }

    // Ver tráiler
    public function verTrailer($id)
    {
        $producto = Producto::findOrFail($id);

        if (!$producto->trailer) {
            abort(404, 'Tráiler no disponible');
        }

        return view('producto.trailer', compact('producto'));
    }

    // Ver película (si ha sido alquilada)
    public function verPelicula($id)
    {
        $producto = Producto::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario_id = Auth::id();
        $alquilado = Pedido::where('usuario_id', $usuario_id)
            ->where('estado', 'pagado')
            ->whereHas('productos', function ($q) use ($producto) {
                $q->where('producto_id', $producto->id);
            })
            ->get()
            ->first(function ($pedido) {
                return $pedido->tieneAcceso();
            });

        if (!$alquilado || !$producto->pelicula) {
            abort(403, 'No tienes acceso a esta película');
        }

        return view('producto.pelicula', compact('producto'));
    }

    public function stream($id)
    {
        $producto = Producto::findOrFail($id);
        $path = storage_path('app/public/peliculas/' . $producto->pelicula);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->stream(function () use ($path) {
            // Abrir el archivo en modo lectura binaria ('rb')
            // Esto permite leer el archivo tal cual es, sin modificar los datos (importante para archivos binarios como videos)
            $file = fopen($path, 'rb');

            // Leer el archivo en bloques de 1024 bytes (1 KB) hasta llegar al final del archivo
            while (!feof($file)) {
                // Enviar los 1024 bytes leídos al navegador
                // `fread` lee una porción del archivo y `echo` la envía al navegador
                echo fread($file, 1024);
            }

            // Cerrar el archivo después de haberlo leído completamente
            fclose($file);
        }, 200, [
            // Establecer el tipo de contenido como video mp4
            'Content-Type' => 'video/mp4',

            // Especificar el tamaño total del archivo
            // `filesize($path)` devuelve el tamaño del archivo en bytes
            'Content-Length' => filesize($path),

            // Permitir que el navegador realice peticiones de partes del archivo (importante para el streaming)
            // Esto permite que el video se pueda avanzar o retroceder
            'Accept-Ranges' => 'bytes',
        ]);
    }

    // Función para hacer streaming del tráiler
    public function streamTrailer($id)
    {
        // Buscar el producto (película) por su ID
        $producto = Producto::findOrFail($id);

        // Obtener la ruta del archivo del tráiler
        $path = storage_path('app/public/trailers/' . $producto->trailer);

        // Verificar si el archivo del tráiler existe
        if (!file_exists($path)) {
            // Si el archivo no existe, devolver un error 404
            abort(404);
        }

        // Iniciar el streaming del tráiler
        return response()->stream(function () use ($path) {
            // Abrir el archivo en modo lectura binaria ('rb')
            $file = fopen($path, 'rb');

            // Leer el archivo en bloques de 1024 bytes (1 KB) hasta llegar al final del archivo
            while (!feof($file)) {
                // Enviar los 1024 bytes leídos al navegador
                echo fread($file, 1024);
            }

            // Cerrar el archivo después de haberlo leído completamente
            fclose($file);
        }, 200, [
            // Establecer el tipo de contenido como video mp4
            'Content-Type' => 'video/mp4',

            // Especificar el tamaño total del archivo
            'Content-Length' => filesize($path),

            // Permitir que el navegador realice peticiones de partes del archivo (importante para el streaming)
            'Accept-Ranges' => 'bytes',
        ]);
    }


    private function isAdmin()
    {
        return Auth::check() && Auth::user()->rol === 'admin';
    }

    public function gestion()
    {
        if (!$this->isAdmin()) abort(403);

        $productos = Producto::all();
        return view('producto.gestion', compact('productos'));
    }

    public function crear()
    {
        if (!$this->isAdmin()) abort(403);

        $categorias = Categoria::all();
        return view('producto.crear', compact('categorias'));
    }

    public function save(Request $request, $id = null)
    {
        if (!$this->isAdmin()) abort(403);

        $request->validate([
            'nombre' => 'required|string|min:3|max:100',
            'descripcion' => 'required|string|min:10',
            'categoria' => 'required|integer|exists:categorias,id',
            'fecha' => 'nullable|date|before_or_equal:today',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'trailer' => 'nullable|mimetypes:video/mp4,video/ogg,video/webm|max:200000',
            'trailer_url' => 'nullable|url',
            'pelicula' => 'nullable|mimetypes:video/mp4,video/ogg,video/webm|max:1000000',
            'pelicula_url' => 'nullable|url',
            'reparto' => 'nullable|string',
        ]);

        $id = Session::get('producto_edit_id');
        $producto = $id ? Producto::findOrFail($id) : new Producto();

        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->categoria_id = $request->input('categoria');
        $producto->fecha = $request->input('fecha') ?? Carbon::now();
        $producto->reparto = $request->input('reparto', ''); // Si no se pasa, se guarda un valor vacío


        if ($request->hasFile('imagen')) {
            $nombre = $request->file('imagen')->getClientOriginalName();
            $path = $request->file('imagen')->storeAs('uploads', $nombre, 'public');
            $producto->imagen = $nombre;
        }

        // Lógica para manejar "trailer" (ya sea enlace o archivo de video)
        if ($request->filled('trailer_url')) {
            // Si se pasa un enlace, guardamos el enlace
            $producto->trailer = $request->input('trailer_url');
        } elseif ($request->hasFile('trailer')) {
            // Si se sube un archivo, lo almacenamos y guardamos el nombre del archivo
            $trailerNombre = $request->file('trailer')->getClientOriginalName();
            $trailerPath = $request->file('trailer')->storeAs('trailers', $trailerNombre, 'public');
            $producto->trailer = $trailerNombre;
        } else {
            // Si no se pasó ni un archivo ni un enlace, se muestra un error
            $producto->trailer = $producto->trailer ?? $producto->trailer;
        }

        // Lógica para manejar "pelicula" (ya sea enlace o archivo de video)
        if ($request->filled('pelicula_url')) {
            // Si se pasa un enlace, guardamos el enlace
            $producto->pelicula = $request->input('pelicula_url');
        } elseif ($request->hasFile('pelicula')) {
            // Si se sube un archivo, lo almacenamos y guardamos el nombre del archivo
            $peliculaNombre = $request->file('pelicula')->getClientOriginalName();
            $peliculaPath = $request->file('pelicula')->storeAs('peliculas', $peliculaNombre, 'public');
            $producto->pelicula = $peliculaNombre;
        } else {
            // Si no se pasó ni un archivo ni un enlace, se muestra un error
            $producto->pelicula = $producto->pelicula ?? $producto->pelicula;
        }

        $producto->save();

        Session::forget('producto_edit_id');
        Session::flash('producto', 'complete');

        return redirect()->route('producto.gestion');
    }

    public function editar($id)
    {
        if (!$this->isAdmin()) abort(403);

        Session::put('producto_edit_id', $id);

        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('producto.crear', compact('producto', 'categorias'));
    }

    public function eliminar($id)
    {
        if (!$this->isAdmin()) abort(403);

        $producto = Producto::findOrFail($id);

        // Eliminar las relaciones con los pedidos
        foreach ($producto->pedidos as $pedido) {
            // Eliminar las relaciones en la tabla pivot lineas_pedidos
            $pedido->productos()->detach($producto->id); // Elimina solo este producto de la relación

            // Si el pedido no tiene más productos, eliminar el pedido
            if ($pedido->productos->count() == 0) {
                $pedido->delete();
            }
        }

        // Eliminar archivos asociados del disco 'public'
        if ($producto->imagen && Storage::disk('public')->exists('uploads/' . $producto->imagen)) {
            Storage::disk('public')->delete('uploads/' . $producto->imagen);
        }

        if ($producto->trailer && Storage::disk('public')->exists('trailers/' . $producto->trailer)) {
            Storage::disk('public')->delete('trailers/' . $producto->trailer);
        }

        if ($producto->pelicula && Storage::disk('public')->exists('peliculas/' . $producto->pelicula)) {
            Storage::disk('public')->delete('peliculas/' . $producto->pelicula);
        }


        // Eliminar el producto
        $producto->delete();

        // Flash message para mostrar que la eliminación fue exitosa
        Session::flash('delete', 'complete');

        return redirect()->route('producto.gestion');
    }

    public function buscar(Request $request)
    {
        // Llamamos a la función que limpia pedidos vencidos
        app(PedidoController::class)->eliminarPedidosVencidos();

        $query = $request->input('q'); // Este es el parámetro 'q' que se enviará desde el formulario

        $productos = Producto::where('nombre', 'like', '%' . $query . '%')->get();

        // $productos = Producto::where('nombre', 'like', '%' . $query . '%')
        //     ->orWhere('descripcion', 'like', '%' . $query . '%')
        //     ->get();

        return view('producto.resultados', compact('productos', 'query'));
    }
}
