<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $tries = 5;

    public function retryUntil()
    {
        return now()->addSeconds(60);
    }

    protected $email = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $view    = $this->email['view'];
        $data    = $this->email['data'];
        $to      = $this->email['to'];
        $subject = $this->email['subject'];

        Mail::send($view, $data, function ($message) use ($to, $subject) {
             $message->to($to)->subject($subject);
        });
    }
}
