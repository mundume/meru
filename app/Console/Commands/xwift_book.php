<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\apis\apiscontroller;
use App\Jobs\Book\Booking;

class xwift_book extends Command
{
    protected $signature = 'xwift:book';
    protected $description = 'xwift books';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $call = new apiscontroller;
        $call->check_booked();
        Booking::dispatch()->delay(now()->addSeconds(25));
    }
}
