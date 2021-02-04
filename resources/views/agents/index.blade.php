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
                                <h4 class="mb-2 mt-3">{{ $bookings->count() }}</h4>
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
                                <h4 class="mb-2 mt-3">{{ $parcels->count() }}</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <i data-feather="map" class="icon-sm mb-1"></i>
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
                                        <i data-feather="map-pin" class="icon-md mb-1"></i>
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
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Today's Bookings ({{ $books->count() }})</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="bookingTable">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Travel Date</th>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>P/M</th>
                                <th>Seaters</th>
                                <th>Route</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $item)
                            <tr>
                                <td>{{ $item->ticket_no }}</td>
                                <td>{{ $item->travel_date }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->id_no }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>{{ $item->seaters }}</td>
                                <td>{{ $item->departure }} ~ {{ $item->destination }}</td>
                                <td>
                                    @if($item->is_paid == false)
                                    <span class="badge badge-danger">Not Paid</span>
                                    @else
                                    <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline-danger btn-xs" style="margin:1px;" disabled>
                                        <i data-feather="trash" class="icon-sm"></i>
                                    </button>
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
    $(document).ready(function () {
        $('#bookingTable').DataTable()
    });
</script>
@endsection