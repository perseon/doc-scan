<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteClient extends Mailable
{
    use Queueable, SerializesModels;
    protected $invite;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite)
    {
        //
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('postmaster@mg.atftax.co.uk')
            ->replyTo('info@atftax.co.uk')
            ->subject('Validare documente')
            ->markdown('emails.invite')
            ->with(['invite'=>$this->invite]);
    }
}
