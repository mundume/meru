<?php

namespace App\Jobs\Book;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\apis\apiscontroller;

class HeadBookUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $booking_data;
    public $tries = 1;
    public function __construct($booking_data)
    {
        $this->booking_data = $booking_data;
    }
    public function handle()
    {
        $call = new apiscontroller;
        $call->head_book_update($this->booking_data);
    }
}
