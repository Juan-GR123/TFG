<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoConfirmado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $productos;

    public function __construct($pedido, $productos)
    {
        $this->pedido = $pedido;
        $this->productos = $productos;
    }

    public function build()
    {
        return $this->subject('Pedido Realizado Con Éxito')
            ->view('emails.pedido_confirmado')
            ->with([
                'usuario' => $this->pedido->usuario, 
                'productos' => $this->productos,
                'coste_total' => $this->pedido->coste,
                'tiempo' => $this->pedido->tiempo_alquiler,
            ]);
    }
}
