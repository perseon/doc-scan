<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResults extends Mailable
{
    use Queueable, SerializesModels;

    protected $invite =[];
    protected $clientEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientEmail,array $invite)
    {
        //
        $this->clientEmail = $clientEmail;
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->invite);
        return $this->from('postmaster@mg.atftax.co.uk')
            ->replyTo('info@atftax.co.uk')
            ->subject($this->clientEmail. ' a scanat documentele')
            ->markdown('emails.results')
            ->with(['invite'=>$this->invite]);
    }
}
