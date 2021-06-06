<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
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

        return $this->from('dilsonlaravel@gmail.com', env('MAIL_FROM_NAME'))
        ->view('emails.TestEmail')
        ->subject('Correo contacto de cliente Puma')
        ->with($this->contacto);
    }
}
