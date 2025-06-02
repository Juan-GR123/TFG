<?php

namespace App\Helpers;

use App\Models\Categoria;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class Utils
{
    // La función cerrarSesion($nombre) elimina la variable de sesión con 
    // el nombre especificado si existe y devuelve dicho nombre.

    public static function cerrarSesion($nombre)
    {
        if (Session::has($nombre)) {
            Session::forget($nombre);
        }

        return $nombre;
    }

    public static function isAdmin()
    {
        if (!Auth::check() || Auth::user()->rol !== 'admin') {
            // Esto no hará efecto si no se devuelve desde el controlador
            abort(403, 'Acceso denegado');
        }
    }

    public static function identidad_comprobar()
    {
        if (!Auth::check()) {
            abort(403, 'Debes estar autenticado para acceder.');
        }

        return true;
    }

    public static function mostrar_categorias()
    {
        $categorias = Categoria::all(); // Suponiendo que tienes el modelo Categoria configurado correctamente
        return $categorias;
    }

    public static function Carrito_mostrar()
    {
        $mostrar = [
            'count' => 0,
        ];

        if (Session::has('carrito')) {
            $carrito = Session::get('carrito');
            $mostrar['count'] = count($carrito);
        }

        return $mostrar;
    }

    public static function Sesion_iniciada()
    {
        if (!Auth::check()) {
            abort(403, 'Debes iniciar sesión para acceder.');
        }
    }

    public static function estado($estado)
    {
        return match ($estado) {
            'confirm'     => 'Pendiente',
            'pagado'      => 'Enviado',
            default       => 'Pendiente',
        };
    }
}