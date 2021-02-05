@extends('layouts.dashboard.main')
@section('title', 'Generate Ticket 16 Seaters')
@section('body')
<link rel="stylesheet" href="{{ asset('css/frame.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-outline-success">{{ $route->departure }} ~ {{ $route->destination }} | Booking Office</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-warning"><i data-feather="arrow-left" class="icon-sm"></i>Go Back</a>
        <button class="btn btn-success float-right" type="button" data-toggle="modal" data-target="#generate_ticket" id="check_paid">Generate Ticket&nbsp;<i data-feather="map" class="icon-sm"></i></button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4">
        <div class="row">
            @include('seats.16')
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success btn-block" data-toggle="modal" data-target="#fleetDispatch" type="submit" style="text-transform:uppercase;height:42px;">
                    Dispatch fleet
                </button>
                <br>
                <form action="{{route('dashboard.dispatch_fleet_print', $route->fleet_unique)}}" method="POST">
                    @csrf
                    <button class="btn btn-warning btn-block" type="submit" style="text-transform:uppercase;height:42px;">
                        Print Last Dispatch
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Delayed Booked Seats</h6>
                            <br>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">Seat</th>
                                        <th class="pt-0">Name</th>
                                        <th class="pt-0">Mobile</th>
                                        <th class="pt-0">Ticket No</th>
                                        {{-- <th class="pt-0">Route</th> --}}
                                        <th class="pt-0">Amount</th>
                                        <th class="pt-0">Time</th>
                                        <th class="pt-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($online_bookings as $item)
                                    <tr>
                                        <td>{{ $item->seat_no }}</td>
                                        <td>{{ $item->fullname }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>{{ $item->ticket_no }}</td>
                                        {{-- <td>{{ $item->departure }} ~ {{ $item->destination }}</td> --}}
                                        <td>{{ number_format($item->amount,2) }}</td>
                                        <td><code>{{ $item->time }}</code></td>
                                        <td>
                                            <form action="{{ route('dashboard.activate_commuter', base64_encode($item->id)) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-success"><i data-feather="unlock" class="icon-sm"></i>&nbsp;activate</button>
                                            </form>
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
        <br>
        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">Seat</th>
                                        <th class="pt-0">Name</th>
                                        <th class="pt-0">Mobile</th>
                                        <th class="pt-0">Ticket No</th>
                                        {{-- <th class="pt-0">Route</th> --}}
                                        <th class="pt-0">Amount</th>
                                        <th class="pt-0">Time</th>
                                        <th class="pt-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($current_bookings as $item)
                                    <tr>
                                        <td>{{ $item->seat_no }}</td>
                                        <td>{{ $item->fullname }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>{{ $item->ticket_no }}</td>
                                        {{-- <td>{{ $item->departure }} ~ {{ $item->destination }}</td> --}}
                                        <td>{{ number_format($item->amount,2) }}</td>
                                        <td><code>{{ $item->time }}</code></td>
                                        <td>
                                            <form action="{{ route('dashboard.delay_commuter', base64_encode($item->id)) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-warning"><i data-feather="lock" class="icon-sm"></i>&nbsp;delay</button>
                                            </form>
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
    </div>
</div>

<!-- pop up -->
<div class="modal close_modal" id="generate_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Generate Ticket
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('dashboard.moderator_sell_ticket') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <small>Name*</small>
                            <input type="text" name="fullname" required style="height:42px;" class="form-control" placeholder="Name *">
                        </div>
                        <div class="col-md-6">
                            <small>ID Number*</small>
                            <input type="text" name="id_no" required style="height:42px;" class="form-control" placeholder="ID Number *">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <small>Mobile*</small>
                            <input type="text" name="mobile" required class="form-control" style="height:42px;" placeholder="0712345678 *">
                        </div>
                        <div class="col-md-6">
                            <small>Amount</small>
                            <input type="text" style="height:42px;" class="form-control" name="amount" required value="{{ $route->amount }}">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <small>Departure</small>
                            <select class="form-control" style="height: 42px;" name="departure">
                                <option>{{$route->departure}}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <small>Destination</small>
                            <select class="form-control" style="height: 42px;" name="destination">
                                <option>{{$route->destination}}</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <select class="form-control" required style="height: 42px;" name="payment_method" required>
                        <option selected data-default disabled>CHOOSE PAYMENT METHOD</option>
                        <option value="cash">CASH</option>
                        <option value="mpesa">MPESA</option>
                    </select>
                    <br>
                    <small style="color:red;text-transform:uppercase;">
                        *Ignore travel date if customer is travelling
                        now.
                    </small>
                    <br>
                    <div id="show_time">
                        <input type="text" name="travel_date" placeholder="TRAVEL DATE" style="border-radius: 0px;height:42px;" id="get_date" class="form-control">
                    </div>
                    <br>
                    <div class="row" id="select_time" hidden>
                        <div class="col-md-10 col-sm-10 col-xs-10">
                            <select class="form-control" name="time" id="cecelia" style="height:42px;">
                                <option selected data-default disabled>SELECT TIME</option>
                                <option>{{$route->depart1}}</option>
                                <option>{{$route->depart2}}</option>
                                <option>{{$route->depart3}}</option>
                                <option>{{$route->depart4}}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <center>
                                <button class="btn btn-outline-danger" style="height: 42px;" type="button" id="clear_select">
                                    <i data-feather="x-circle" stle="color:red;"></i>
                                </button>
                            </center>
                        </div>
                        <small class="text-danger">{{$errors->first('time')}}</small>
                    </div>
                    <br>
                    <input name="group" hidden value="{{$route->group}}">
                    <input name="seaters" hidden value="{{ $route->seaters }}">
                    <input name="fleet_unique" hidden value="{{$route->fleet_unique}}">
                    <div class="row">
                        @include('seats.16_1')
                    </div>
                    <button type="submit" class="btn btn-success btn-block" style="height: 42px;">CREATE TICKET</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal close_modal" id="fleetDispatch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">
                        Fleet Information
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.dispatch_fleet', [auth()->user()->id, $route->fleet_unique])}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <select name="readable_fleet_id" {{ $errors->has('readable_fleet_id') ? 'has-error' : '' }} style="height: 45px;" class="form-control" required>
                                <option selected hidden data-default disabled>SELECT FLEET
                                </option>
                                @foreach($fleets as $fleet)
                                <option>{{ $fleet->fleet_id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block" style="border-radius: 0;height:45px;">DISPATCH FLEET</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
@if (count($errors) > 0)
<script>
    $(document).ready(function () {
        $('#generate_ticket').modal('show');
    });
</script>
@endif
<script>
    fetchBooked()

    function fetchBooked() {
        var book_1 = $('.book_1').val()
        var book_2 = $('.book_2').val()
        var book_3 = $('.book_3').val()
        var book_4 = $('.book_4').val()
        var book_5 = $('.book_5').val()
        var book_6 = $('.book_6').val()
        var book_7 = $('.book_7').val()
        var book_8 = $('.book_8').val()
        var book_9 = $('.book_9').val()
        var book_10 = $('.book_10').val()
        var book_11 = $('.book_11').val()
        var book_12 = $('.book_12').val()
        var book_13 = $('.book_13').val()
        var book_14 = $('.book_14').val()
        var book_15 = $('.book_15').val()
        var book_16 = $('.book_16').val()
        $.ajax({
            url: "{{ route('dashboard.booked') }}",
            type: "POST",
            data: {
                departure: "{!! $route->departure !!}",
                destination: "{!! $route->destination !!}",
                seaters: "{!! $route->seaters !!}",
                fleet_unique: "{!! $route->fleet_unique !!}",
                _token: "{{ csrf_token() }}"
            },
            cache: false,
            dataType: 'json',
            success: function (result) {
                var booked = result
                $('.book_1').prop('disabled', false)
                $('.book_2').prop('disabled', false)
                $('.book_3').prop('disabled', false)
                $('.book_4').prop('disabled', false)
                $('.book_5').prop('disabled', false)
                $('.book_6').prop('disabled', false)
                $('.book_7').prop('disabled', false)
                $('.book_8').prop('disabled', false)
                $('.book_9').prop('disabled', false)
                $('.book_10').prop('disabled', false)
                $('.book_11').prop('disabled', false)
                $('.book_12').prop('disabled', false)
                $('.book_13').prop('disabled', false)
                $('.book_14').prop('disabled', false)
                $('.book_15').prop('disabled', false)
                $('.book_16').prop('disabled', false)
                $.each(booked, function (propName, propVal) {
                    if (propVal == book_1) {
                        $('.book_1').prop('disabled', true)
                    } else if (propVal == book_2) {
                        $('.book_2').prop('disabled', true)
                    } else if (propVal == book_3) {
                        $('.book_3').prop('disabled', true)
                    } else if (propVal == book_4) {
                        $('.book_4').prop('disabled', true)
                    } else if (propVal == book_5) {
                        $('.book_5').prop('disabled', true)
                    } else if (propVal == book_6) {
                        $('.book_6').prop('disabled', true)
                    } else if (propVal == book_7) {
                        $('.book_7').prop('disabled', true)
                    } else if (propVal == book_8) {
                        $('.book_8').prop('disabled', true)
                    } else if (propVal == book_9) {
                        $('.book_9').prop('disabled', true)
                    } else if (propVal == book_10) {
                        $('.book_10').prop('disabled', true)
                    } else if (propVal == book_11) {
                        $('.book_11').prop('disabled', true)
                    } else if (propVal == book_12) {
                        $('.book_12').prop('disabled', true)
                    } else if (propVal == book_13) {
                        $('.book_13').prop('disabled', true)
                    } else if (propVal == book_14) {
                        $('.book_14').prop('disabled', true)
                    } else if (propVal == book_15) {
                        $('.book_15').prop('disabled', true)
                    } else if(propVal == book_16) {
                    $('.book_16').prop('disabled', true)
                    } else {
                        $('.book_1').prop('disabled', false)
                        $('.book_2').prop('disabled', false)
                        $('.book_3').prop('disabled', false)
                        $('.book_4').prop('disabled', false)
                        $('.book_5').prop('disabled', false)
                        $('.book_6').prop('disabled', false)
                        $('.book_7').prop('disabled', false)
                        $('.book_8').prop('disabled', false)
                        $('.book_9').prop('disabled', false)
                        $('.book_10').prop('disabled', false)
                        $('.book_11').prop('disabled', false)
                        $('.book_12').prop('disabled', false)
                        $('.book_13').prop('disabled', false)
                        $('.book_14').prop('disabled', false)
                        $('.book_15').prop('disabled', false)
                        $('.book_16').prop('disabled', false)
                    }
                })
            },
            complete: function (data) {
                setTimeout(fetchBooked, 5000)
            }
        })
    }
</script>
<script>
    $('#check_paid').click(function () {
        fetchBookedModal()
    })

    function fetchBookedModal() {
        var book_1_1 = $('.book_1_1').val()
        var book_2_1 = $('.book_2_1').val()
        var book_3_1 = $('.book_3_1').val()
        var book_4_1 = $('.book_4_1').val()
        var book_5_1 = $('.book_5_1').val()
        var book_6_1 = $('.book_6_1').val()
        var book_7_1 = $('.book_7_1').val()
        var book_8_1 = $('.book_8_1').val()
        var book_9_1 = $('.book_9_1').val()
        var book_10_1 = $('.book_10_1').val()
        var book_11_1 = $('.book_11_1').val()
        var book_12_1 = $('.book_12_1').val()
        var book_13_1 = $('.book_13_1').val()
        var book_14_1 = $('.book_14_1').val()
        var book_15_1 = $('.book_15_1').val()
        var book_16_1 = $('.book_16_1').val()
        $.ajax({
            url: "{{ route('dashboard.booked') }}",
            type: "POST",
            data: {
                departure: "{!! $route->departure !!}",
                destination: "{!! $route->destination !!}",
                seaters: "{!! $route->seaters !!}",
                fleet_unique: "{!! $route->fleet_unique !!}",
                _token: "{{ csrf_token() }}"
            },
            cache: false,
            dataType: 'json',
            success: function (result) {
                var booked = result
                $('.book_1_1').prop('disabled', false)
                $('.book_2_1').prop('disabled', false)
                $('.book_3_1').prop('disabled', false)
                $('.book_4_1').prop('disabled', false)
                $('.book_5_1').prop('disabled', false)
                $('.book_6_1').prop('disabled', false)
                $('.book_7_1').prop('disabled', false)
                $('.book_8_1').prop('disabled', false)
                $('.book_9_1').prop('disabled', false)
                $('.book_10_1').prop('disabled', false)
                $('.book_11_1').prop('disabled', false)
                $('.book_12_1').prop('disabled', false)
                $('.book_13_1').prop('disabled', false)
                $('.book_14_1').prop('disabled', false)
                $('.book_15_1').prop('disabled', false)
                $('.book_16_1').prop('disabled', false)
                $.each(booked, function (propName, propVal) {
                    if (propVal == book_1_1) {
                        $('.book_1_1').prop('disabled', true)
                    } else if (propVal == book_2_1) {
                        $('.book_2_1').prop('disabled', true)
                    } else if (propVal == book_3_1) {
                        $('.book_3_1').prop('disabled', true)
                    } else if (propVal == book_4_1) {
                        $('.book_4_1').prop('disabled', true)
                    } else if (propVal == book_5_1) {
                        $('.book_5_1').prop('disabled', true)
                    } else if (propVal == book_6_1) {
                        $('.book_6_1').prop('disabled', true)
                    } else if (propVal == book_7_1) {
                        $('.book_7_1').prop('disabled', true)
                    } else if (propVal == book_8_1) {
                        $('.book_8_1').prop('disabled', true)
                    } else if (propVal == book_9_1) {
                        $('.book_9_1').prop('disabled', true)
                    } else if (propVal == book_10_1) {
                        $('.book_10_1').prop('disabled', true)
                    } else if (propVal == book_11_1) {
                        $('.book_11_1').prop('disabled', true)
                    } else if (propVal == book_12_1) {
                        $('.book_12_1').prop('disabled', true)
                    } else if (propVal == book_13_1) {
                        $('.book_13_1').prop('disabled', true)
                    } else if (propVal == book_14_1) {
                        $('.book_14_1').prop('disabled', true)
                    } else if (propVal == book_15_1) {
                        $('.book_15_1').prop('disabled', true)
                    } else if(propVal == book_16_1) {
                    $('.book_16_1').prop('disabled', true)
                    } else {
                        $('.book_1_1').prop('disabled', false)
                        $('.book_2_1').prop('disabled', false)
                        $('.book_3_1').prop('disabled', false)
                        $('.book_4_1').prop('disabled', false)
                        $('.book_5_1').prop('disabled', false)
                        $('.book_6_1').prop('disabled', false)
                        $('.book_7_1').prop('disabled', false)
                        $('.book_8_1').prop('disabled', false)
                        $('.book_9_1').prop('disabled', false)
                        $('.book_10_1').prop('disabled', false)
                        $('.book_11_1').prop('disabled', false)
                        $('.book_12_1').prop('disabled', false)
                        $('.book_13_1').prop('disabled', false)
                        $('.book_14_1').prop('disabled', false)
                        $('.book_15_1').prop('disabled', false)
                        $('.book_16_1').prop('disabled', false)
                    }
                })
            },
            complete: function (data) {
                setTimeout(fetchBookedModal, 3000)
            }
        })
    }
</script>
<script>
    $(document).ready(function () {
        $('#show_time').click(function () {
        // $('#select_time').attr("hidden", "hidden");
        $('#select_time').removeAttr('hidden')
        })
        })
        </script>
        <script>
            $(document).ready(function () {
        $('#select_time').on('change', function (e) {
            var time = e.target.value
            var seaters = "{!! $route->seaters !!}"
            var user_id = "{!! $route->user_id !!}"
            var date = $('#get_date').val()
            var book_1_1 = $('.book_1_1').val()
            var book_2_1 = $('.book_2_1').val()
            var book_3_1 = $('.book_3_1').val()
            var book_4_1 = $('.book_4_1').val()
            var book_5_1 = $('.book_5_1').val()
            var book_6_1 = $('.book_6_1').val()
            var book_7_1 = $('.book_7_1').val()
            var book_8_1 = $('.book_8_1').val()
            var book_9_1 = $('.book_9_1').val()
            var book_10_1 = $('.book_10_1').val()
            var book_11_1 = $('.book_11_1').val()
            var book_12_1 = $('.book_12_1').val()
            var book_13_1 = $('.book_13_1').val()
            var book_14_1 = $('.book_14_1').val()
            var book_15_1 = $('.book_15_1').val()
            var book_16_1 = $('.book_16_1').val()
            $.ajax({
                url: "{{ route('dashboard.get_booked_seats') }}",
                type: "POST",
                data: {
                    time: time,
                    seaters: seaters,
                    user_id: user_id,
                    date: date,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (dataResult) {
                    // var booked = dataResult
                    var booked = jQuery.parseJSON(dataResult)
                    for (i = 0; i < 100; i++) {
                        window.clearTimeout(i);
                    }
                    $('.book_1_1').prop('disabled', false)
                    $('.book_2_1').prop('disabled', false)
                    $('.book_3_1').prop('disabled', false)
                    $('.book_4_1').prop('disabled', false)
                    $('.book_5_1').prop('disabled', false)
                    $('.book_6_1').prop('disabled', false)
                    $('.book_7_1').prop('disabled', false)
                    $('.book_8_1').prop('disabled', false)
                    $('.book_9_1').prop('disabled', false)
                    $('.book_10_1').prop('disabled', false)
                    $('.book_11_1').prop('disabled', false)
                    $('.book_12_1').prop('disabled', false)
                    $('.book_13_1').prop('disabled', false)
                    $('.book_14_1').prop('disabled', false)
                    $('.book_15_1').prop('disabled', false)
                    $('.book_16_1').prop('disabled', false)
                    $.each(booked, function (propName, propVal) {
                        if (propVal == book_1_1) {
                            $('.book_1_1').prop('disabled', true)
                        } else if (propVal == book_2_1) {
                            $('.book_2_1').prop('disabled', true)
                        } else if (propVal == book_3_1) {
                            $('.book_3_1').prop('disabled', true)
                        } else if (propVal == book_4_1) {
                            $('.book_4_1').prop('disabled', true)
                        } else if (propVal == book_5_1) {
                            $('.book_5_1').prop('disabled', true)
                        } else if (propVal == book_6_1) {
                            $('.book_6_1').prop('disabled', true)
                        } else if (propVal == book_7_1) {
                            $('.book_7_1').prop('disabled', true)
                        } else if (propVal == book_8_1) {
                            $('.book_8_1').prop('disabled', true)
                        } else if (propVal == book_9_1) {
                            $('.book_9_1').prop('disabled', true)
                        } else if (propVal == book_10_1) {
                            $('.book_10_1').prop('disabled', true)
                        } else if (propVal == book_11_1) {
                            $('.book_11_1').prop('disabled', true)
                        } else if (propVal == book_12_1) {
                            $('.book_12_1').prop('disabled', true)
                        } else if (propVal == book_13_1) {
                            $('.book_13_1').prop('disabled', true)
                        } else if (propVal == book_14_1) {
                            $('.book_14_1').prop('disabled', true)
                        } else if (propVal == book_15_1) {
                            $('.book_15_1').prop('disabled', true)
                        } else if(propVal == book_16_1) {
                        $('.book_16_1').prop('disabled', true)
                        } else {
                            $('.book_1_1').prop('disabled', false)
                            $('.book_2_1').prop('disabled', false)
                            $('.book_3_1').prop('disabled', false)
                            $('.book_4_1').prop('disabled', false)
                            $('.book_5_1').prop('disabled', false)
                            $('.book_6_1').prop('disabled', false)
                            $('.book_7_1').prop('disabled', false)
                            $('.book_8_1').prop('disabled', false)
                            $('.book_9_1').prop('disabled', false)
                            $('.book_10_1').prop('disabled', false)
                            $('.book_11_1').prop('disabled', false)
                            $('.book_12_1').prop('disabled', false)
                            $('.book_13_1').prop('disabled', false)
                            $('.book_14_1').prop('disabled', false)
                            $('.book_15_1').prop('disabled', false)
                            $('.book_16_1').prop('disabled', false)
                        }
                    })
                }
            })
        })
    })
</script>
<script>
    $(document).ready(function () {
        $('#get_date').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d',
            minDate: '-1970/01/01'
        })
    })
</script>
<script>
    $(document).ready(function () {
        $('#clear_select').click(function () {
            $('#cecelia').val('').trigger('change')
            $('input[type=date]').val('');
            $('#select_time').attr("hidden", "hidden");
            // $('#select_time').removeAttr('hidden')
            fetchBooked()
            fetchBookedModal()
        })
    })
</script>
@endsection