<?php
    $ab = \App\Models\Route::where('id', $route->id)->first();
    $picks = $ab->pick_up;
?>
@extends('layouts.main')
@section('title', 'Search')
@section('body')
<section id="our-services" class="innerpage-wrapper">
    <section id="blog-details-page" class="innerpage-wrapper">

        <div id="blog-details" class="innerpage-section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 content-side">
                        <div class="space-right">

                            <section id="reservation-page" class="innerpage-wrapper" style="margin-bottom: 10px;">

                                <div id="reservation" class="search-bar-1">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                                <h4 style="text-transform: uppercase;"><b>Fleet Information</b><b
                                                        class="float-right" style="color:orange;font-size:12px;">step 1
                                                        of
                                                        2</b></h4>
                                                <hr>
                                                <p>Route:- <b>{{ $route->departure }}</b> ~
                                                    <b>{{ $route->destination }}</b></p>
                                                <p>
                                                    Departures:- <br>
                                                    {{ $route->depart1 }} | {{ $route->depart2 }} |
                                                    {{ $route->depart3 }} | {{ $route->depart4 }}
                                                </p>
                                                <p>Office Location:- {!! $route->location !!}</p>
                                                <p>
                                                    Pickup Point:- <br>
                                                    @foreach($picks as $pick)
                                                    <code>{{ $pick }}</code> <br>
                                                    @endforeach
                                                </p>
                                                <hr>
                                                <h6><b>Amount:- KSh&nbsp;{{ number_format($route->amount, 2) }}</b></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="reservation-page" class="innerpage-wrapper">

                                <div id="reservation" class="search-bar-1">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                                <h4 style="text-transform: uppercase;"><b>Add your detail and
                                                        proceed</b></h4>
                                                <hr>
                                                {{-- <div class="space-right"> --}}
                                                <form
                                                    action="{{ route('independent.booking_step_one', base64_encode($route->id)) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="row">

                                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                                            <div
                                                                class="form-group {{ $errors->has('fullname') ? 'has-error' : '' }}">
                                                                <input type="text" name="fullname"
                                                                    placeholder="FULLNAME*" class="form-control"
                                                                    required value="{{ old('fullname') }}">
                                                                <small
                                                                    class="text-danger">{{$errors->first('fullname')}}</small>
                                                            </div>
                                                        </div><!-- end columns -->

                                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                                            <div class="form-group">
                                                                <input type="text" name="id_no" placeholder="ID NUMBER*"
                                                                    class="form-control" required value="{{ old('id_no') }}">
                                                                <small
                                                                    class="text-danger">{{$errors->first('id_no')}}</small>
                                                            </div>
                                                        </div><!-- end columns -->

                                                        <div
                                                            class="col-12 col-md-6 col-lg-12 col-xl-12 {{ $errors->has('pick_up') ? 'has-error' : '' }}">
                                                            <div class="form-group">
                                                                <select class="form-control border-radius"
                                                                    name="pick_up" style="height:42px;" required>
                                                                    <option selected hidden data-default disabled>CHOOSE
                                                                        PICKUP POINT</option>
                                                                    @foreach($picks as $pick)
                                                                    <option>{{ $pick }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <small
                                                                    class="text-danger">{{$errors->first('pick_up')}}</small>
                                                            </div>
                                                        </div><!-- end columns -->

                                                        <div
                                                            class="col-12 col-md-12 col-lg-12 col-xl-12 {{ $errors->has('mobile') ? 'has-error' : '' }}">
                                                            <div class="form-group">
                                                                <input type="text" name="mobile"
                                                                    placeholder="PHONE NUMBER*" class="form-control"
                                                                    required value="{{ old('mobile') }}">
                                                                <small
                                                                    class="text-danger">{{$errors->first('mobile')}}</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                                            <button type="submit"
                                                                class="btn btn-block btn-yellow">PROCEED</button>
                                                        </div><!-- end columns -->

                                                    </div><!-- end row -->
                                                </form>
                                                {{-- </div><!-- end space-right --> --}}
                                            </div><!-- end columns -->
                                        </div><!-- end row -->
                                    </div><!-- end container -->
                                </div><!-- end reservation -->

                            </section><!-- end innerpage-wrapper -->

                        </div><!-- end space-right -->
                    </div><!-- end columns -->
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end blog-details -->

    </section><!-- end innerpage-wrapper -->
</section>
@endsection