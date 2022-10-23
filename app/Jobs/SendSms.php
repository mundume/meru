<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\{App,Log};
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mobile;
    public $message;
    public $tries = 1;
    public function __construct($mobile,$message)
    {
        $this->mobile = $mobile;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $at = new AfricasTalking(config('services.africastalking_secret'), config('services.africastalking_key'));
        $sms = $at->sms();
        $result = $sms->send([
            'to' => 0 . substr($this->mobile,-9),
            'message' => $this->message
        ]);
        Log::critical("Message sent\r\n".$this->message."to\r\n".$this->mobile);
    }
}
