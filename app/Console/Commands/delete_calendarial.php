<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Express\{Calendarial,Route};

class delete_calendarial extends Command
{
    protected $signature = 'delete:calendarial';
    protected $description = 'Delete calendarial';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $date = Carbon::today()->format('Y-m-d');
        $calendarial = Calendarial::where('date', $date)->get();
        foreach($calendarial as $calendar) {
            $route = Route::where('fleet_unique', $calendar->fleet_unique)->update([
                'amount' => $calendar->off_peak
            ]);
            $calendar->delete();
        }
    }
}
