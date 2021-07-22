<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudMail extends Mailable
{
    use Queueable, SerializesModels;

    //variable creada en el controlador
    public $contacto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contacto)
    {
        $this->contacto = $contacto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('pumawebagencia@gmail.com', env('MAIL_FROM_NAME'))
        ->view('emails.SolicitudEmail')
        ->subject('SOLICITUD DE PERSONAL PUMA')
        ->with($this->contacto);

    }
}
