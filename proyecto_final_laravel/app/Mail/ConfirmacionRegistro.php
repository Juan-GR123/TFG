<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Usuario;

class ConfirmacionRegistro extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;


    /**
     * Create a new message instance.
     */
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     */
     public function build()
    {
        return $this->subject('Confirmación de Registro')
                    ->view('emails.confirmacion')
                    ->with([
                        'usuario' => $this->usuario->nombre,
                        'urlConfirmacion' => route('usuario.confirmar', $this->usuario->token_confirmacion) // Aquí se pasa el token
                    ]);
    }
}
