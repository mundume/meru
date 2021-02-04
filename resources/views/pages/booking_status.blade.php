<?php
    $subs = \App\Models\System::first();
?>
@extends('layouts.main')
@section('title', 'Booking Status')
<link rel="stylesheet" href="{{ asset('css/frame.css') }}">
@section('body')
<div class="row align-items-center">
    <div class="col-md-12">
        <div style="margin:80px 10px 0 10px;">

            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <h4 style="text-transform:uppercase;">Booking Summary</h4>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 status">
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-7" style="font-size:15px;">
                            <h3 style="color:#183947;"><b>Booking details:</b></h3>
                            <p style="color:#183947;"><b>Persons Details:</b></p>
                            <hr style="margin-top:-5px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Name:- {{ $books->fullname }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Contact:- {{ $books->mobile }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Route:- {{ $books->departure }} ~ {{ $books->destination }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Amount:- {{ number_format($books->amount, 2) }}</p>
                                </div>
                            </div>
                            <p style="color:#183947;"><b>Fleet Details:</b></p>
                            <hr style="margin-top:-5px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Group:- {{ $books->group }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Date of Travel:- {{ $books->travel_date }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Seaters:- {{ $books->seaters }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Seat No:- {{ $books->seat_no }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Time of Travel:- {{ $books->time }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #183947;color:white;padding:5px;">TICKET NO: {{ $books->ticket_no }} </h4>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn btn-block" style="background-color: #183947;color:white;padding:20px;border-radius:0px;text-transform:uppercase;width:100%;">
                                <b>No Mpesa Prompt in your phone</b>
                            </button>
                            <br>
                            <h4><b>USE PAYBILL</b></h4>
                            <p>
                                1. Go to the MPESA Menu on your phone <br>
                                2. Select Lipa Na Mpesa <br>
                                3. Select Pay Bill <br>
                                4. Enter Business NO. <b>{{$subs->paybill}}</b> <br>
                                4. Enter Account NO. <b>{{ $books->ticket_no }}</b> <br>
                                5. Enter Amount <b>{{ number_format($books->amount, 2) }}</b> and confirm. <br>
                                6. Page will refresh fo you to print your RECEIPT
                            </p>
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
    fetchbook();

    function fetchbook() {
        $.ajax({
            url: "{{ route('independent.check_status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ticket_no: "{!! $books->ticket_no !!}"
            },
            cache: false,
            dataType: 'json',
            success: function (result) {
                var status = result.is_paid
                if (status == 1) {
                    $('.status').html('<button class="btn btn-outline-success float-right">PAID</button>')
                } else {
                    $('.status').html('<button class="btn btn-outline-warning float-right">PENDING</button>')
                }
            },
            complete: function (data) {
                setTimeout(fetchbook, 5000);
            }
        });
    }
</script>
@endsection