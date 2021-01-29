<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{Parcel,Booking};
use DB;

class graphscontroller extends Controller
{
    public function sales() {
        $dates = collect();
        foreach(range(13,0) AS $i) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $dates->put($date,0);
        }
        $bookings = Booking::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                                ->groupBy('date')->orderBy('date')
                                ->get(([
                                    DB::raw('DATE(created_at) as date'),
                                    DB::raw('SUM(amount) as "views"')
                                ]))->pluck('views', 'date');
        $dates = $dates->merge($bookings);
        $data_one = [];
        foreach($dates as $der) {
            array_push($data_one, $der);
        }
        $dates_ = collect();
        foreach(range(13,0) AS $i) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $dates_->put($date, 0);
        }
        $parcels = Parcel::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                            ->groupBy('date')->orderBy('date')
                            ->get(([
                                DB::raw('DATE(created_at) as date'),
                                DB::raw('SUM(service_provider_amount) as "views"')
                            ]))->pluck('views', 'date');
        $dates_ = $dates_->merge($parcels);
        $data_two = [];
        foreach($dates_ as $cec) {
            array_push($data_two, $cec);
        }
        $options = [
            'label' => 'Bookings',
            'data' => $data_one,
            'borderColor' =>  '#727cf5',
            'backgroundColor' => '#727cf5',
            'fill' => false
        ];
        $options1 = [
            'label' => 'Parcels',
            'data' => $data_two,
            'borderColor' => '#686868',
            'backgroundColor' => '#686868',
            'fill' => false
        ];
        $data = [$options, $options1];
        $all_data['label'] = $dates->keys();
        $all_data['datasets'] = $data;
        return json_encode($all_data);
    }
    public function pie_chart() {
        $bookings = Booking::where([['is_paid', true], ['travel_date', Carbon::today()->format('Y-m-d')]])->sum('amount');
        $parcels = Parcel::where([['is_paid', true]])->whereDate('created_at', Carbon::today())->sum('service_provider_amount');
        $data['label'][0] = "Parcels";
        $data['label'][1] = "Booking";
        $data['data'][0] = $parcels;
        $data['data'][1] = $bookings;
        return json_encode($data);
    }
    public function line_graph() {
        $dates = collect();
        foreach(range(30,0) AS $i) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $dates->put($date,0);
        }
        $bookings = Booking::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                                ->groupBy('date')->orderBy('date')
                                ->get(([
                                    DB::raw('DATE(created_at) as date'),
                                    DB::raw('COUNT(*) as "count"')
                                ]))->pluck('count', 'date');
        $dates = $dates->merge($bookings);
        $data_one = [];
        foreach($dates as $der) {
            array_push($data_one, $der);
        }
        $dates_ = collect();
        foreach(range(30,0) AS $i) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $dates_->put($date, 0);
        }
        $parcels = Parcel::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                            ->groupBy('date')->orderBy('date')
                            ->get(([
                                DB::raw('DATE(created_at) as date'),
                                DB::raw('COUNT(*) as "count"')
                            ]))->pluck('count', 'date');
        $dates_ = $dates_->merge($parcels);
        $data_two = [];
        foreach($dates_ as $cec) {
            array_push($data_two, $cec);
        }
        $options = [
            'label' => 'Bookings',
            'data' => $data_one,
            'borderColor' =>  '#727cf5',
            'backgroundColor' => '#727cf5',
            'fill' => false
        ];
        $options1 = [
            'label' => 'Parcels',
            'data' => $data_two,
            'borderColor' => '#686868',
            'backgroundColor' => '#686868',
            'fill' => false
        ];
        $data = [$options, $options1];
        $all_data['label'] = $dates->keys();
        $all_data['datasets'] = $data;
        return json_encode($all_data);
    }
}
