@extends('layouts.main')
@section('title', 'Search')
@section('body')
<div class="intro-section" id="home">
    <div class="slide-1" style="background-image: url('shuttle_images/tourist.png');" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4">
                            <p style="color: blue;">Search results for '{{request()->input('seaters')}} seaters'</p>
                            <p style="color: red;">{{ $routes->count() }} result(s) for '{{ request()->input('departure') }}' ~
                                '{{ request()->input('destination') }}' </p>
                            @foreach($routes as $route)
                            <div class="row derrick">
                                <div class="col-md-2">
                                    <a href="{{route('route.show', [base64_encode($route->id)])}}">
                                        <img src="{{ asset('shuttle_images/logo.png') }}" style="height: 50px;width:50px;">
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <b>{{$route->departure}} ~ {{$route->destination}}</b>
                                </div>
                                <div class="col-md-2" style="color: orange;">
                                    <small>{{number_format($route->amount, 2)}}</small>
                                </div>
                                <div class="col-md-3">
                                    <p><span class="label label-default">{{ $route->seaters }} seaters</span></p>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{route('route.show',[base64_encode($route->id)])}}">
                                        <button class="btn btn-warning" style="border-radius: 0;">BOOK NOW</button>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-lg-5 ml-auto">
                            <form action="{{ route('independent.search') }}" method="GET" class="form-box">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        SEARCH ROUTE
                                    </div>
                                </div>
                                <br>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <select class="form-control" name="seaters" required>
                                            <option selected hidden data-default disabled>SELECT SEATERS</option>
                                            @foreach($uni->unique('seaters') as $rou)
                                            <option>{{$rou->seaters }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3 mb-lg-0">
                                        <select class="form-control" name="departure" required>
                                            <option selected hidden data-default disabled>DEPARTURE</option>
                                            @foreach($uni->unique('departure') as $rou)
                                            <option>{{ $rou->departure }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" name="destination" required>
                                            <option selected hidden data-default disabled>DESTINATION</option>
                                            @foreach($uni->unique('destination') as $rou)
                                            <option>{{ $rou->destination }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-pill btn-block" value="SEARCH ROUTE">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection