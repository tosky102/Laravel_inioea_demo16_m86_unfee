<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sendto;
    public $options;
    public $data;

    /**
     * Create a new job instance.
     *
     * @param $to
     * @param $options
     * @param $data
     * @return void
     */
    public function __construct($to, $options, $data)
    {
        $this->sendto = $to;
        $this->options = $options;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to($this->sendto)->send(new SendMail($this->sendto, $this->options, $this->data));

    }
}
