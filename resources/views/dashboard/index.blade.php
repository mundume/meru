@extends('layouts.dashboard.main')
@section('title', 'Dashboard')
@section('body')
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow">
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Bookings</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">{{ $bookings }}</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <i data-feather="globe" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Parcels</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">{{ $parcels }}</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <i data-feather="truck" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Routes</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">{{ $routes->count() }}</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <i data-feather="map" class="icon-md mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Growth</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h3 class="mb-2 mt-2">89.87%</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+2.8%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <select class="form-control" style="height: 45px;text-transform: uppercase;" id="booking_office">
            <option selected data-default disabled>Choose Booking Office</option>
            @foreach($routes as $route)
            <option value="{{$route->id}}">{{$route->departure}} ~
                {{$route->destination}} ({{ $route->seaters }})</option>
            @endforeach
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div id="buttons" class="float-right"></div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Weekly Sales</h6>
                </div>
                <div class="flot-wrapper">
                    <canvas id="barGraph"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Daily Bookings/Parcels proportions</h6>
                <canvas id="pieChart"></canvas>
                </div>
                </div>
                </div>
                </div>
<div class="row">
    <div class="col-12 col-xl-12 grid-margin stretch-card">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Sales Count</h6>
                </div>
                <div class="flot-wrapper">
                    <canvas id="lineGraph"></canvas>
                </div>
            </div>
        </div>
    </div>
    </div>

<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Available Fleets</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton7">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Group</th>
                                <th class="pt-0">Amount</th>
                                <th class="pt-0">Seaters</th>
                                <th class="pt-0">Route</th>
                                <th class="pt-0">Agent</th>
                                <th class="pt-0 float-right">Agent Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($routes as $item)
                            @php
                            if($item->suspend == true):
                            $color = 'tomato';
                            else:
                            $color = '';
                            endif
                            @endphp
                            @php
                            if($item->admin_suspend == true):
                            $strike = 'line-through';
                            else:
                            $strike = '';
                            endif
                            @endphp
                            <tr style="background-color: {{ $color }};text-decoration: {{ $strike }};">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->group }}</td>
                                    <td>KSh{{ number_format($item->amount, 2) }}</td>
                                    <td>{{ $item->seaters }}</td>
                                    <td>{{ $item->departure }} ~ {{ $item->destination }}</td>
                                    <td>
                                        @foreach($item->agent as $agent)
                                        {{ @$agent->fname }} {{ @$agent->lname }}
                                        @endforeach
                                    </td>
                                    <td class="form-inline float-right">
                                        <button class="btn btn-default btn-sm">
                                            <a href="{{route('dashboard.edit_route', base64_encode($item->id))}}">
                                                <i data-feather="edit" class="icon-sm"></i>
                                            </a>
                                        </button>
                                        <button class="btn btn btn-sm">
                                            <a href="{{route('route.show', base64_encode($item->id))}}" target="_blank">
                                                <i data-feather="globe" class="icon-sm"></i>
                                        </button>
                                        @if($item->suspend == false)
                                        <form action="{{route('dashboard.suspend_route', base64_encode($item->id))}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger" style="margin:2px"><i data-feather="unlock" class="icon-sm"></i></button>
                                        </form>
                                        @else
                                        <form action="{{route('dashboard.unsuspend_route', base64_encode($item->id))}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success" style="margin:2px"><i data-feather="lock" class="icon-sm"></i></button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#booking_office').on('change', function (e) {
            var route_id = e.target.value
            $.ajax({
                url: "{{ route('dashboard.booking_office') }}",
                type: "POST",
                data: {
                    route_id: route_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    var clear = ""
                    $("#buttons").empty(clear)
                    var obj = jQuery.parseJSON(data)
                    $.each(obj, function (propName, propVal) {
                        var seater = propVal.seaters
                        var id = propVal.id
                        if (seater == 7) {
                            $('#buttons').append('<a href="/book/tickets/7/' + id + '" class="btn btn-success" class="btn btn-success" style="text-transform: uppercase;">Sell Ticket(7)</a>')
                        } else if (seater == 10) {
                            $('#buttons').append('<a href="/book/tickets/10/' + id + '" class="btn btn-success" class="btn btn-success" style="text-transform: uppercase;">Sell Ticket(10)</a>')
                        } else if (seater == 11) {
                            $('#buttons').append('<a href="/book/tickets/11/' + id + '" class="btn btn-success" class="btn btn-success" style="text-transform: uppercase;">Sell Ticket(11)</a>')
                        } else if (seater == 14) {
                            $('#buttons').append('<a href="/book/tickets/14/' + id + '" class="btn btn-success" class="btn btn-success" style="text-transform: uppercase;">Sell Ticket(14)</a>')
                        } else if (seater == 16) {
                            $('#buttons').append('<a href="/book/tickets/16/' + id + '" class="btn btn-success" class="btn btn-success" style="text-transform: uppercase;">Sell Ticket(16)</a>')
                        } else {
                            $('#buttons').html('<span class="label label-danger">Oops, No fleet found</span>')
                        }
                    })
                }
            })
        })
    })
</script>
<script>
    $.ajax({
        url: "{{ route('graphs.sales') }}",
        type: 'GET',
        success: function (result) {
            var obj = jQuery.parseJSON(result)
            var options = {
                type: 'bar',
                data: {
                    labels: obj.label,
                    datasets: obj.datasets
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                reverse: false
                            }
                        }]
                    }
                }
            }
            var ctx = document.getElementById('barGraph').getContext('2d');
            new Chart(ctx, options);
        }
    })
</script>
<script>
    $.ajax({
        url: "{{ route('graphs.pie_chart') }}",
        type: "GET",
        success: function (result) {
            var obj = jQuery.parseJSON(result)
            var ctx = $("#pieChart")
            var data = {
                labels: obj.label,
                datasets: [{
                    data: obj.data,
                    backgroundColor: [
                        "#686868",
                        "#727cf5"
                    ],
                    borderWidth: [1, 1]
                }]
            }
            var options = {
                responsive: true,
                legend: {
                    display: true,
                    position: "bottom",
                    labels: {
                        fontColor: "#333",
                        fontSize: 10
                    }
                }
            }
            var chart1 = new Chart(ctx, {
                type: "pie",
                data: data,
                options: options
            })
        }
    })
</script>
<script>
    $(function () {
        var cData = JSON.parse(`<?php echo $chart_data; ?>`)
        var options = {
            type: 'line',
            data: {
                labels: cData.label,
                datasets: cData.datasets
            }
        }
        var ctx = document.getElementById('lineGraph').getContext('2d')
        new Chart(ctx, options)
    });
</script>
@endsection