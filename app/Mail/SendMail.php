<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sendto;
    public $options;
    public $data;

    /**
     * Create a new message instance.
     *
     * @param $to
     * @param $options
     * @param $data
     *
     * @return void
     */
    public function __construct($to, $options, $data)
    {
        $this->sendto = $to;
        $this->options = $options;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->to($this->sendto)
            ->subject($this->options['subject'])
            ->view($this->options['template'], ['data' => $this->data]);
//            ->text($this->options['template']);
    }
}
