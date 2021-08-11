@extends('layouts.dashboard.main')
@section('title', 'Future Bookings Check')
@section('body')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('css/frame.css') }}">
<div class="row">
    <div class="col-md-12 form-inline">
        <form action="{{ route('dashboard.future_bookings_check') }}" method="POST">
            @csrf
            <input type="text" class="form-control" style="height: 40px;" name="date" id="datetimepicker" placeholder="SELECT DATE">
            <select class="form-control" id="booking_office" name="fleet_id" style="height: 40px;">
                <option selected data-default disabled>Select Route</option>
                @foreach($routes as $sp)
                <option value="{{$sp->id}}">{{$sp->departure}} ~
                    {{$sp->destination}} ({{ $sp->seaters }})</option>
                @endforeach
            </select>
            <select class="form-control" name="time" id="time" style="height: 40px;">
                <option selected hidden data-default disabled>Select Time</option>
            </select>
            <button class="btn btn-success" style="height: 40px;margin:2px;" type="submit"><i data-feather="search" class="icon-sm"></i></button>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-4">
        <div class="row">
            @if($fleet->seaters == 7)
            @include('seats.7')
            @elseif($fleet->seaters == 10)
            @include('seats.10')
            @elseif($fleet->seaters == 11)
            @include('seats.11')
            @elseif($fleet->seaters == 14)
            @include('seats.14')
            @elseif($fleet->seaters == 16)
            @include('seats.16')
            @else
            @include('seats.other')
            @endif
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success btn-block" data-toggle="modal" data-target="#fleetInfo" type="submit" style="height:42px;text-transform:uppercase;">
                    Dispatch fleet
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">BOOKED TICKETS ({{ $bookings->count() }})</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="bookingTable">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Seat NO</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Amount</th>
                                        <th>P/M</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $item)
                                    <tr>
                                        <td>{{ $item->ticket_no }}</td>
                                        <td>{{ $item->seat_no }}</td>
                                        <td>{{ $item->fullname }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>{{ number_format($item->amount, 2) }}</td>
                                        <td>{{ $item->payment_method }}</td>
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

<!-- pop ups -->
<div class="modal close_modal" id="fleetInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Other Vehicle Information
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.dispatch_fleet_future', [auth()->user()->id, $fleet->fleet_unique, $date])}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <p>Fleet ID</p>
                            <input type="text" name="readable_fleet_id" {{ $errors->has('readable_fleet_id') ? 'has-error' : '' }} required style="height:50px;" class="form-control" placeholder="KAL 123K *">
                            <small class="text-danger">{{$errors->first('readable_fleet_id')}}</small>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block" style="border-radius: 0;height:50px;">DISPATCH FLEET</button>
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
<script>
    $(document).ready(function () {
        $('#bookingTable').DataTable({
            "drawCallback": function (settings) {
        feather.replace()
        }
        })
        $('#datetimepicker').datetimepicker({
            timepicker: false,
            format: "Y-m-d"
        })
    });
</script>
<script>
    $(document).ready(function () {
        $('#booking_office').on('change', function (e) {
            var cat_id = e.target.value
            $.ajax({
                url: "{{ route('dashboard.look_for_time') }}",
                type: "POST",
                data: {
                    cat_id: cat_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    var time = ""
                    $('#time').empty()
                    var obj = jQuery.parseJSON(data)
                    $('#time').append('<option selected hidden data-default disabled> ' +
                        'Select Time</option>')
                    $.each(obj, function (propName, propVal) {
                        $('#time').append('<option>' + propVal.depart1 +
                            '</option>')
                        $('#time').append('<option>' + propVal.depart2 +
                            '</option>')
                        $('#time').append('<option>' + propVal.depart3 +
                            '</option>')
                        $('#time').append('<option>' + propVal.depart4 + '</option>')
                    })
                }
            })
        })
    })
</script>
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
            url: "{{ route('dashboard.booked_future') }}",
            type: "POST",
            data: {
                departure: "{!! $fleet->departure !!}",
                destination: "{!! $fleet->destination !!}",
                seaters: "{!! $fleet->seaters !!}",
                travel_date: "{!! $date !!}",
                time: "{!! $time !!}",
                _token: "{{ csrf_token() }}"
            },
            cache: false,
            dataType: 'json',
            success: function (dataResult) {
                var booked = dataResult
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
                    } else if (propVal == book_16) {
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
                setTimeout(fetchBooked, 3000)
            }
        })
    }
</script>
@endsection