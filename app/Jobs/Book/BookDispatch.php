<?php

namespace App\Jobs\Book;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\apis\apiscontroller;

class BookDispatch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $ticket_no;
    public $tries = 1;
    public function __construct($ticket_no)
    {
        $this->ticket_no = $ticket_no;
    }
    public function handle()
    {
        $call = new apiscontroller;
        $call->head_dispatch($this->ticket_no);
    }
}
