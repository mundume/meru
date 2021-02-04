@extends('layouts.main')
@section('title', 'Complete Booking')
<link rel="stylesheet" href="{{ asset('css/frame.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
@section('body')
<div class="row align-items-center">
    <div class="col-md-12">
        <div style="margin:80px 10px 0 10px;">

            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="row">
                        <div class="col-md-7">
                            <form action="{{ route('independent.post_complete_booking') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="travel_date" placeholder="TRAVEL DATE" style="border-radius: 0px;height:50px;" id="get_date" required class="form-control" readonly>
                                        <small class="text-danger">{{$errors->first('travel_date')}}</small>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-control" name="time" id="select_time" style="border-radius: 0px;height:50px;" required>
                                            <option selected data-default disabled>SELECT TIME</option>
                                            <option>{{$route->depart1}}</option>
                                            <option>{{$route->depart2}}</option>
                                            <option>{{$route->depart3}}</option>
                                            <option>{{$route->depart4}}</option>
                                        </select>
                                        <small class="text-danger">{{$errors->first('time')}}</small>
                                    </div>
                                </div>
                                <input type="text" name="ticket_no" value="{{ $book->ticket_no }}" hidden>
                                <br>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;">
                                        <code>Amount may change based on travel date.</code>
                                        <label id="ribbon">
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <small class="text-danger">{{$errors->first('seat_no')}}</small>
                                    @if($book->seaters == 7)
                                    @include('seats.7')
                                    @elseif($book->seaters == 10)
                                    @include('seats.10')
                                    @elseif($book->seaters == 11)
                                    @include('seats.11')
                                    @elseif($book->seaters == 14)
                                    @include('seats.14')
                                    @elseif($book->seaters == 16)
                                    @include('seats.16')
                                    @else
                                    @include('seats.other')
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ url()->previous() }}" class="btn btn-danger btn-block" style="height:42px;border-radius:0px;">
                                            CANCEL TICKET
                                        </a>
                                    </div>
                                    <div class="d-md-none">
                                        <br>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-block" id="lock_fool" style="height:42px;border-radius:0px;">PAY TICKET</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn btn-block" style="background-color: #183947;color:white;padding:20px;border-radius:0px;text-transform:uppercase;width:100%;">
                                <b>Booking Information</b>
                            </button>
                            <hr>
                            <style>
                                .details {
                                    padding: 20px;
                                    border-radius: 0px;
                                    box-shadow: 0 0px 5px 1px rgba(19, 35, 47, 0.3);
                                    background-color: #ffffff;
                                    /*margin-top: 10px;*/
                                    margin: 0px auto 5px;
                                    text-transform: uppercase;
                                }
                            </style>
                            <div class="col-md-12 details">
                                <p>Name:- <b>{{ $book->fullname }}</b></p>
                                <p>ID:- <b>{{ $book->id_no }}</b></p>
                                <p>Mobile:- <b>{{ $book->mobile }}</b></p>
                                <p>Pickup:- <b>{{ $book->pick_up }}</b></p>
                                <p>Ticket Number:- <b>{{ $book->ticket_no }}</b></p>
                                <p>Route:- <b>{{ $route->departure }} ~ {{ $route->destination }}</b></p>
                                <p>Seaters:- <b>{{ $route->seaters }}</b></p>
                            </div>
                        </div>
                    </div>

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
        $('#get_date').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y-m-d',
            minDate: 0
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
                url: "{{ route('dashboard.get_booked_seats') }}",
                type: "POST",
                data: {
                    time: time,
                    seaters: seaters,
                    user_id: user_id,
                    date: date,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    var booked = jQuery.parseJSON(data)
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
                }
            })
        })
    })
</script>
<script>
    $(document).ready(function () {
        $('#get_date').on('change', function (e) {
            var date = e.target.value
            var fleet_unique = "{!! $route->fleet_unique !!}"
            $.ajax({
                url: "{{ route('independent.calendarial') }}",
                type: "POST",
                data: {
                    date: date,
                    fleet_unique: fleet_unique,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#ribbon').html("")
                    var obj = jQuery.parseJSON(data)
                    // $('#fare').val(obj)
                    // $('#fare').html(obj)
                    if (obj == 'X_L01') {
                        $('#ribbon').html('<span class="label label-error">Oops, fleet is not available on that date. Kindly change date or book another.</span>')
                        $('#lock_fool').prop('disabled', true)
                    } else {
                        $('#ribbon').html('<span class="label label-success">You are about to pay KSh. ' + obj + '</span>')
                        $('#lock_fool').prop('disabled', false)
                    }
                }
            })
        })
    })
</script>
@endsection