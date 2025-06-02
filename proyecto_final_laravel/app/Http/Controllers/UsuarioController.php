<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Mail\ConfirmacionRegistro;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Exception;
use App\Rules\DnsCheck;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function index()
    {
        return "Controlador Usuarios, Acción index";
    }

    public function registro()
    {
        if (Auth::check()) {
            return redirect()->route('producto.index');
        }

        return view('usuario.registro');
    }

    public function sesion()
    {
        if (Auth::check()) {
            return redirect()->route('producto.index');
        }

        return view('usuario.sesion');
    }

    public function listado()
    {
        if (Auth::user()->rol === 'admin') {
            $usuarios = Usuario::all(); // Admin ve todo
        } else {
            $usuarios = Usuario::where('id', Auth::id())->get(); // Usuario normal solo se ve a sí mismo
        }

        return view('usuario.listado', compact('usuarios'));
    }

    public function perfil()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $pedidos = Pedido::where('usuario_id', $usuario->id)->get();

            return view('usuario.perfil', compact('usuario', 'pedidos'));
        }

        return view('usuario.sesion');
    }

    public function confirmar($token)
    {
        $usuario = Usuario::where('token_confirmacion', $token)->first();

        if (!$usuario) {
            return redirect('/usuario/sesion')->with('error', 'Token inválido.');
        }


        // Confirmar el registro
        $usuario->email_confirmado = true;
        $usuario->token_confirmacion = null; // Limpiar el token
        $usuario->save();

        return redirect('/usuario/sesion')->with('success', 'Registro confirmado. Bienvenido!');
    }


    public function save(Request $request)
    {
        $request->validate([
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,50}$/',
            'apellidos' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,50}$/',
            'email' => ['required', 'email', 'unique:usuarios,email', new DnsCheck],
            'password' => ['nullable', 'string', 'min:5', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
            'rol' => 'in:user,admin',
            'imagen' => 'nullable|image|max:2048'
        ]);


        try {
            $usuario = new Usuario();
            $usuario->nombre = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->rol = $request->rol ?? 'user';


            if ($request->hasFile('imagen')) {
                $nombreImagen = $request->file('imagen')->getClientOriginalName();
                $path = $request->file('imagen')->storeAs('uploads', $nombreImagen, 'public');
                $usuario->imagen = $nombreImagen;
            }
            $usuario->token_confirmacion = Str::random(60); // Generar un token aleatorio




            // Intentar enviar correo de confirmación
            try {
                Mail::to($usuario->email)->send(new ConfirmacionRegistro($usuario));
            } catch (Exception $e) {
                // Si el correo no se puede enviar, puedes capturar el error
                return redirect()->back()->with('error', 'No se pudo enviar el correo de confirmación. Intenta nuevamente más tarde.');
            }
            $usuario->save();

            // Auth::login($usuario);
 
            // return redirect()->route('usuario.registro')->with('registro', 'complete');

            return redirect()->route('usuario.sesion')->with('success', 'Registro exitoso. Por favor, confirma tu email antes de iniciar sesión.');
        } catch (\Exception $e) {
            return redirect()->back()->with('registro', 'failed')->withInput();
        }
    }

    // public function cancelarRegistro($token)
    // {
    //     // Verificar si el token es válido
    //     $usuario = Usuario::where('token_confirmacion', $token)->first();

    //     if (!$usuario) {
    //         return redirect()->route('producto.index')->with('error', 'El registro no se pudo cancelar, token inválido.');
    //     }

    //     // Eliminar los pedidos asociados a este usuario
    //     $pedidos = Pedido::where('usuario_id', $usuario->id)->get();
    //     foreach ($pedidos as $pedido) {
    //         $pedido->productos()->detach(); // No elimina los productos de la base de datos, solo las asociaciones entre el pedido y esos productos.
    //         $pedido->delete(); // Elimina el pedido
    //     }

    //     // Eliminar el usuario
    //     $usuario->delete();

    //     // Redirigir al usuario a una página de éxito o mensaje
    //     return redirect()->route('usuario.registro')->with('success', 'Tu cuenta ha sido eliminada exitosamente.');
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // Buscar usuario por email
        $usuario = Usuario::where('email', $credentials['email'])->first();

        if (!$usuario || !Hash::check($credentials['password'], $usuario->password)) {
            return redirect()->route('usuario.sesion')->with('error_login', 'Identificación fallida');
        }

        // Verificar si el email está confirmado
        if (!$usuario->email_confirmado) {
            return redirect()->route('usuario.sesion')->with('error_login', 'Debes confirmar tu correo electrónico antes de iniciar sesión.');
        }

        Auth::login($usuario);
        $request->session()->regenerate();
        return redirect()->intended(route('producto.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('producto.index');
    }

    public function editar($id)
    {
        $user = Auth::user();

        if (!$user || ($user->rol !== 'admin' && $user->id != $id)) {
            return redirect()->route('producto.index');
        }

        $usuarioDatos = Usuario::findOrFail($id);
        return view('usuario.modificar', compact('usuarioDatos'));
    }

    public function eliminar($id)
    {
        $user = Auth::user();

        if (!$user || ($user->rol !== 'admin' && $user->id != $id)) {
            return redirect()->route('producto.index');
        }
 
        $usuarioEliminar = Usuario::findOrFail($id);

        // Eliminar imagen de perfil si existe
        if ($usuarioEliminar->imagen && Storage::disk('public')->exists('uploads/' . $usuarioEliminar->imagen)) {
            Storage::disk('public')->delete('uploads/' . $usuarioEliminar->imagen);
        }

        // Eliminar los pedidos asociados a este usuario
        $pedidos = Pedido::where('usuario_id', $usuarioEliminar->id)->get();
        foreach ($pedidos as $pedido) {
            $pedido->productos()->detach(); // Si usas relación de productos, los elimina de la relación
            $pedido->delete(); // Elimina el pedido
        }


        $usuarioEliminar->delete();

        Session::flash('delete', 'complete');

        if ($user->id == $id) {
            Auth::logout();
            return redirect()->route('usuario.sesion');
        }

        return redirect()->route('usuario.listado');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('usuario.sesion');
        }

        $request->validate([
            'id' => 'required|numeric|exists:usuarios,id',
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,50}$/',
            'apellidos' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,50}$/',
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($request->id), new DnsCheck],
            'password' => ['nullable', 'string', 'min:5', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
            'rol' => 'in:user,admin',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $usuario = Usuario::findOrFail($request->id);
        $rolAntiguo = $usuario->rol;

        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        // $usuario->email = $request->email;

        if ($usuario->email !== $request->email) {
            $usuario->email = $request->email;
            $usuario->email_confirmado = false;
            $usuario->token_confirmacion = Str::random(60);

            try {
                Mail::to($usuario->email)->send(new ConfirmacionRegistro($usuario));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'No se pudo enviar el correo de confirmación.')->withInput();
            }
        }


        if ($request->hasFile('imagen')) {
            $nombreImagen = $request->file('imagen')->getClientOriginalName();
            $path = $request->file('imagen')->storeAs('uploads', $nombreImagen, 'public');
            $usuario->imagen = $nombreImagen;
        }

        if ($user->rol === 'admin') {
            $usuario->rol = $request->rol;
        }

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        if ($usuario->save()) {
            Session::flash('update', 'complete');

            if (
                $user->rol === 'admin' &&
                $user->id == $request->id &&
                $rolAntiguo == 'admin' && $request->rol == 'user'
            ) {
                Auth::logout();
                Session::flush();

                // Reautenticamos al usuario manualmente
                Auth::login($usuario); // Ya está actualizado

                return redirect()->route('producto.index')->with('info', 'Tu rol ha sido actualizado a usuario.');
            }
        } else {
            Session::flash('update', 'failed');
        }

        return redirect()->route('usuario.listado');
    }

    //Este metodo es el mismo que el anterior pero que te redirige al perfil
    public function update2(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('usuario.sesion');
        }

        $request->validate([
            'id' => 'required|numeric|exists:usuarios,id',
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,50}$/',
            'apellidos' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\d ]{2,50}$/',
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($request->id), new DnsCheck],
            'password' => ['nullable', 'string', 'min:5', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
            'rol' => 'in:user,admin',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $usuario = Usuario::findOrFail($request->id);
        $rolAntiguo = $usuario->rol;

        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        // $usuario->email = $request->email;

        if ($usuario->email !== $request->email) {
            $usuario->email = $request->email;
            $usuario->email_confirmado = false;
            $usuario->token_confirmacion = Str::random(60);

            try {
                Mail::to($usuario->email)->send(new ConfirmacionRegistro($usuario));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'No se pudo enviar el correo de confirmación.')->withInput();
            }
        }


        if ($request->hasFile('imagen')) {
            $nombreImagen = $request->file('imagen')->getClientOriginalName();
            $path = $request->file('imagen')->storeAs('uploads', $nombreImagen, 'public');
            $usuario->imagen = $nombreImagen;
        }

        if ($user->rol === 'admin') {
            $usuario->rol = $request->rol;
        }

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        if ($usuario->save()) {
            Session::flash('update', 'complete');

            if (
                $user->rol === 'admin' &&
                $user->id == $request->id &&
                $rolAntiguo == 'admin' && $request->rol == 'user'
            ) {
                Auth::logout();
                Session::flush();

                // Reautenticamos al usuario manualmente
                Auth::login($usuario); // Ya está actualizado

                return redirect()->route('producto.index')->with('info', 'Tu rol ha sido actualizado a usuario.');
            }
        } else {
            Session::flash('update', 'failed');
        }

        return redirect()->route('usuario.perfil');
    }


    // private function Sesion_iniciada()
    // {
    //     if (!Session::has('identidad')) {
    //         redirect()->route('sesion')->send();
    //         exit;
    //     }
    // }

}
