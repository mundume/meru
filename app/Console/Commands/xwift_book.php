<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\apis\apiscontroller;

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
    }
}
