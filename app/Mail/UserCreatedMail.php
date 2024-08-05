<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $date;

   /**
    * Create a new message instance.
    *
    * @param  $data
    * @return void
    */
    public function __construct($data)
    {
        $this->data = $data;
        $this->date = now();
    }

   /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->view('email.user_created')->with(['user'=>$this->data,'date'=>$this->date]);
    }
}
