<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\dashboardcontroller;


class notify_admin extends Command
{
    protected $signature = 'notify:admin';
    protected $description = 'Notify admin on sales';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $call = new dashboardcontroller;
        $call->notify_admin();
    }
}
