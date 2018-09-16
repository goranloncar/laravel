<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email extends Mailable
{
    use Queueable, SerializesModels;


    public $email;
    public $memos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $memos)
    {
        $this->email = $email;
        $this->memos = $memos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email');
    }
}
