<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AfricasTalking\SDK\AfricasTalking;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $dispatch;
    public $tries = 3;
    public function __construct($dispatch)
    {
        $this->dispatch = $dispatch;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $env = config('services.africastalking_env');
        if($env == "prod") {
            $at = new AfricasTalking(config('services.africastalking_secret'), config('services.africastalking_key'));
            $sms = $at->sms();
            $result = $sms->send([
                'to' => $this->dispatch['mobile'],
                'message' => $this->dispatch['message']
            ]);
        }
    }
}
