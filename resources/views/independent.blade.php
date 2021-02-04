@extends('layouts.main')
@section('title', 'Home')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
@section('body')
<div class="intro-section" id="home">
    <div class="slide-1" style="background-image: url('shuttle_images/tourist.png');" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4">
                            <center>
                                <h2 data-aos="fade-up" data-aos-delay="100">
                                    1. Discover And Book Unique Fleet
                                </h2>
                                <h2 data-aos="fade-up" data-aos-delay="100">
                                    2. Sending Parcels Now Made Easy
                                </h2>
                                <p data-aos="fade-up" data-aos-delay="300">
                                    <a href="#" class="btn btn-primary btn-pill">Send Parcel</a>
                                    <a href="#" class="btn btn-primary btn-pill">Contact Us</a>
                                </p>
                            </center>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-control" name="seaters" required>
                                            <option selected hidden data-default disabled>SELECT SEATERS</option>
                                            @foreach($uni->unique('seaters') as $rou)
                                            <option>{{$rou->seaters }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
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
{{-- <div class="site-section courses-title" id="work">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
                <h2 class="section-title">Recommended routes</h2>
            </div>
        </div>
    </div>
</div> --}}
<div class="site-section courses-entry-wrap" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="owl-carousel col-12 nonloop-block-14">
                @foreach($routes as $route)
                <div class="course bg-white align-self-stretch">
                    <figure class="m-0">
                        <a href="{{ route('route.show', base64_encode($route->id)) }}">
                            <img src="{{ asset('shuttle_images/logo.png') }}" alt="Image" class="img-fluid">
                        </a>
                    </figure>
                    <div class="course-inner-text py-4 px-4">
                        <span class="course-price">{{ number_format($route->amount) }}</span>
                        <h3><a href="{{ route('route.show', base64_encode($route->id)) }}">{{ $route->departure }} ~ {{ $route->destination }}</a></h3>
                    </div>
                    <div class="d-flex border-top stats">
                        <div class="py-3 px-4"><span class="icon-users"></span>
                            {{ $route->depart1 }} | {{ $route->depart2 }} | {{ $route->depart3 }} | {{ $route->depart4 }}
                        </div>
                        <div class="py-3 px-4 w-25 ml-auto border-left">
                            <span class="icon-chat">{{ $route->seaters }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="site-section" id="services">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
                <h2 class="section-title">Our Services</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam repellat aut neque! Doloribus sunt non aut reiciendis, vel recusandae obcaecati hic dicta repudiandae in quas quibusdam ullam, illum sed veniam!</p>
            </div>
        </div>
        <div class="row mb-5 align-items-center">
            <div class="col-lg-7 mb-5" data-aos="fade-up" data-aos-delay="100">
                <img src="images/undraw_youtube_tutorial.svg" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-black mb-4">Online Bookings</h2>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem maxime nam porro possimus fugiat quo molestiae illo.</p>
                <div class="d-flex align-items-center custom-icon-wrap mb-3">
                    <span class="custom-icon-inner mr-3"><span class="icon icon-graduation-cap"></span></span>
                    <div>
                        <h3 class="m-0">Total Bookings {{ $total_booking }}</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center custom-icon-wrap">
                    <span class="custom-icon-inner mr-3"><span class="icon icon-university"></span></span>
                    <div>
                        <h3 class="m-0">Today's Bookings {{ $today_booking }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5 align-items-center">
            <div class="col-lg-7 mb-5 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                <img src="images/undraw_teaching.svg" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-4 mr-auto order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-black mb-4">Parcel Sending</h2>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem maxime nam porro possimus fugiat quo molestiae illo.</p>
                <div class="d-flex align-items-center custom-icon-wrap mb-3">
                    <span class="custom-icon-inner mr-3"><span class="icon icon-graduation-cap"></span></span>
                    <div>
                        <h3 class="m-0">Total Parcels {{ $total_parcel }}</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center custom-icon-wrap">
                    <span class="custom-icon-inner mr-3"><span class="icon icon-university"></span></span>
                    <div>
                        <h3 class="m-0">Today's Parcels {{ $today_parcel }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section pb-0">
    <div class="future-blobs">
        <div class="blob_2">
            <img src="images/blob_2.svg" alt="Image">
        </div>
        <div class="blob_1">
            <img src="images/blob_1.svg" alt="Image">
        </div>
    </div>
    <div class="container">
        <div class="row mb-5 justify-content-center" data-aos="fade-up" data-aos-delay="">
            <div class="col-lg-7 text-center">
                <h2 class="section-title">Why Choose Us</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 ml-auto align-self-start" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 rounded bg-white why-choose-us-box">
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-graduation-cap"></span></span></div>
                        <div>
                            <h3 class="m-0">Best services</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-university"></span></span></div>
                        <div>
                            <h3 class="m-0">Reliable and Flexible</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-graduation-cap"></span></span></div>
                        <div>
                            <h3 class="m-0">Cheap and Reliable</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-university"></span></span></div>
                        <div>
                            <h3 class="m-0">Fast</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 align-self-end" data-aos="fade-left" data-aos-delay="200">
                <img src="images/person_transparent.png" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<div class="site-section bg-light" id="contact-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h2 class="section-title mb-3">Message Us</h2>
                <p class="mb-5">Natus totam voluptatibus animi aspernatur ducimus quas obcaecati mollitia quibusdam temporibus culpa dolore molestias blanditiis consequuntur sunt nisi.</p>
                <form method="post" data-aos="fade">
                    <div class="form-group row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <input type="text" class="form-control" placeholder="First name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Last name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea class="form-control" id="" cols="30" rows="5" placeholder="Write your message here."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary py-3 px-5 btn-block btn-pill" value="Send Message">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#date').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d',
            minDate: 0
        })
    })
</script>
@endsection