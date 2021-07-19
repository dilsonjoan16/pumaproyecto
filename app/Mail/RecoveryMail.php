<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoveryMail extends Mailable
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
        //return $this->view("emails.TestEmail");
        //return response()->json($this->subject('Prueba de correo'));

        return $this->from('pumawebagencia@gmail.com', env('MAIL_FROM_NAME'))
        ->view('emails.RecoveryEmail')
        ->subject('RECUPERACION DE PASSWORD CLIENTE PUMA')
        ->with($this->contacto);
    }
}
