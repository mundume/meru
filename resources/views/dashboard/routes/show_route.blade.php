<?php
    $ab = \App\Models\Route::where('id', $route->id)->first();
    $picks = $ab->pick_up;
  ?>
@extends('layouts.main')
@section('title', 'View Fleet')
<link rel="stylesheet" href="{{ asset('css/frame.css') }}">
@section('body')
<div class="row align-items-center">
    <div class="col-md-12">
        <div style="margin:80px 10px 0 10px;">

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <button class="btn btn-outline-success">{{ $route->departure }} ~ {{ $route->destination }} | {{ $route->seaters }}</button>
                    {{-- <a href="{{ url()->previous() }}" class="btn btn-outline-warning float-right">Go Back</a> --}}
                    @if($route->suspend == false && $route->admin_suspend == false)
                    <a href="#" class="btn btn-outline-warning float-right" data-toggle="modal" data-target="#book">BOOK</a>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card-header">
                                FLEET INFORMATION
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    Route <b>{{ $route->departure }}</b> ~ <b>{{ $route->destination }}</b>
                                </h5>
                                <p class="card-text">
                                    KSh&nbsp;{{ number_format($route->amount, 2) }}
                                </p>
                                <p class="card-text">
                                    Contact Information: {{ $route->mobile }}
                                </p>
                                <p class="card-text">
                                    Pickup Points <br>
                                    @foreach($picks as $pick)
                                    <code>{{ $pick }}</code> <br>
                                    @endforeach
                                </p>
                                <div class="card-text">
                                    Departure Time <br>
                                    {{ $route->depart1 }} | {{ $route->depart2 }} | {{ $route->depart3 }} | {{ $route->depart4 }}
                                </div>
                                <div class="card-text">
                                    Office Location <br>
                                    <code>{!! $route->location !!}</code>
                                </div>
                            </div>
                            {{-- </div> --}}
                            {{-- <div class="card-header">
                        FLEET INFORMATION
                    </div>
                    <p>Departure {{ $route->departure }} | Destination {{ $route->destination }}</p> --}}
                        </div>
                        <div class="col-md-4">
                            <div class="card-header">
                                SEATS ARRANGEMENT
                            </div>
                            @if($route->seaters == 7)
                            @include('seats.7')
                            @elseif($route->seaters == 10)
                            @include('seats.10')
                            @elseif($route->seaters == 11)
                            @include('seats.11')
                            @elseif($route->seaters == 14)
                            @include('seats.14')
                            @elseif($route->seaters == 16)
                            @include('seats.16')
                            @else
                            @include('seats.other')
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- pop up -->
<div class="modal" data-keyboard="false" data-backdrop="static" id="book" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('independent.booking_step_one', base64_encode($route->id)) }}" method="POST">
            @csrf
            <div class="modal-content" style="border-radius: 0px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 {{ $errors->has('fullname') ? 'has-error' : '' }}">
                            <input type="text" name="fullname" placeholder="FULLNAME*" class="form-control" required>
                            <small class="text-danger">{{$errors->first('fullname')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 {{ $errors->has('id_no') ? 'has-error' : '' }}">
                            <input type="text" name="id_no" placeholder="ID NUMBER*" class="form-control" required>
                            <small class="text-danger">{{$errors->first('id_no')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 {{ $errors->has('pick_up') ? 'has-error' : '' }}">
                            <select class="form-control border-radius" name="pick_up" style="height:42px;" required>
                                @foreach($picks as $pick)
                                <option selected hidden data-default disabled>CHOOSE PICKUP POINT</option>
                                <option>{{$pick}}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{$errors->first('pick_up')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 {{ $errors->has('mobile') ? 'has-error' : '' }}">
                            <input type="text" name="mobile" placeholder="PHONE NUMBER*" class="form-control" required>
                            <small class="text-danger">{{$errors->first('mobile')}}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-block">PROCEED</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection