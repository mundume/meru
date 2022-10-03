@extends('layouts.main')
@section('title', 'Search')
@section('body')
<section class="search-bar">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                @include('layouts.search_form')
            </div><!-- end columns -->
        </div><!-- end row -->
        </div><!-- end container -->
        </section><!-- end search-bar -->
        <section id="room-listings" class="innerpage-wrapper">

            <div id="room-listing-blocks" class="innerpage-section-padding">
                <div class="container">
                    <div class="row">
                        <style>
                            .derrick {
                                padding: 10px;
                                border-radius: 0px;
                                box-shadow: 0 0px 5px 1px rgba(19, 35, 47, 0.3);
                                background-color: #ffffff;
                                margin: 0px auto 5px;
                            }
                        </style>

                        <div class="col-12 col-md-12 col-lg-9 col-xl-9">
                    <p style="color: blue;">Search results for '{{request()->input('seaters')}} seaters'</p>
                    <p style="color: red;">{{ $routes->count() }} result(s) for '{{ request()->input('departure') }}' ~
                        '{{ request()->input('destination') }}'</p>
                        <div class="row">
                            @foreach($routes as $route)
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row derrick">
                                <div class="col-md-2">
                                    <a href="{{route('route.show', [base64_encode($route->id)])}}">
<img src="{{ asset('shuttle_images/logo.png') }}" style="height: 40px;width:50px;">
                                    </a>
                                </div>
                                <div class="col-md-3">
<p><b>{{$route->depart1}} ~ {{$route->arriv1}}</b></p>
                                </div>
                                <div class="col-md-2" style="color: orange;">
                                    <p>{{number_format($route->amount, 2)}}</p>
                                </div>
                                <div class="col-md-2">
                                    <p><span class="label label-default">{{ $route->seaters }} seaters</span></p>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{route('route.show',[base64_encode($route->id)])}}">
                                        <button class="btn btn-warning btn-block" style="border-radius: 0;">BOOK NOW</button>
                                    </a>
                                    </div>
                            </div>                            
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-3 col-xl-3 side-bar">

                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12 col-xl-12">
                            <div class="side-bar-block support-block">
                                <h4>Contact Support</h4>
                                <hr>
                                <p class="query">If you have any question please don't hesitate to contact us</p>
                                <ul class="list-unstyled">
                                    <li>
                                        <span><i class="fa fa-phone"></i></span>
                                        <div class="text">
<p>+254721542489</p>
                                        </div><!-- end text -->
                                    </li>
                                </ul>
                            </div><!-- end side-bar-block -->
                        </div><!-- end columns -->

                    </div><!-- end row -->

                </div><!-- end columns -->
            </div>
        </div>
    </div>
</section>
@endsection