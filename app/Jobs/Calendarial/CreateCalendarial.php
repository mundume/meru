<?php

namespace App\Jobs\Calendarial;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\apis\apiscontroller;

class CreateCalendarial implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $dispatch;
    public $tries = 3;
    public function __construct($dispatch)
    {
        $this->dispatch = $dispatch;
    }
    public function handle()
    {
        $call = new apiscontroller;
        $call->create_calend($this->dispatch);
    }
}
