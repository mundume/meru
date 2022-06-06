<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $dispatch;
    public $tries = 1;
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
        if(App::environment(['staging','production'])) {
            $at = new AfricasTalking(config('services.africastalking_secret'), config('services.africastalking_key'));
            $sms = $at->sms();
            $result = $sms->send([
                'to' => $this->dispatch['mobile'],
                'message' => $this->dispatch['message']
            ]);
        } else {
            Log::critical($this->dispatch);
        }
    }
}
