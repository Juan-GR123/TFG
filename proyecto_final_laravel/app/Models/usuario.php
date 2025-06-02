<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    // Nombre de la tabla si no sigue la convención (Laravel usa 'usuarios' por defecto)
    protected $table = 'usuarios';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'rol',
        'imagen',
    ];

    // Ocultar campos en JSON
    protected $hidden = [
        'password',
    ];

    // Autocasting de campos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // // Mutador para hashear contraseña al guardar
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }


    // Login manual (aunque puedes usar Laravel Auth)
    public static function login($email, $password)
    {
        $usuario = self::where('email', $email)->first();

        if ($usuario && Hash::check($password, $usuario->password)) {
            return $usuario;
        }

        return false;
    }

    public static function getUsuarios()
    {
        return self::orderBy('id')->get();
    }

    public static function get_id_editar($id)
    {
        return self::find($id);
    }

    public static function eliminarUsuario($id)
    {
        $usuario = self::find($id);

        if ($usuario) {
            // Elimina líneas de pedido y pedidos relacionados (si no están en cascada)
            \App\Models\LineaPedido::whereIn('pedido_id', function ($query) use ($id) {
                $query->select('id')->from('pedidos')->where('usuario_id', $id);
            })->delete();

            \App\Models\Pedido::where('usuario_id', $id)->delete();

            return $usuario->delete();
        }

        return false;
    }

    public function updateUsuario(array $data)
    {
        return $this->update($data);
    }
}
