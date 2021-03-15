@extends('layouts.main')
@section('title', 'Home')
@section('body')
<div class="home-container">

    <div class="flexslider" id="slider">
        <ul class="slides">
            <li class="item-1"></li>
            <li class="item-2"></li>
        </ul><!-- end slides -->

        <div id="hero-main">
            <div class="hero-content">
                <div class="text-align">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <h1 id="welcome">Welcome To Shuttle App</h1>
                                <h3 id="tagline">Enjoy Best Services With Us!</h3>
                                <div class="hero-text" style="margin-bottom: 100px;">
                                    @include('layouts.search_form')
                                </div><!-- end hero text -->
                                </div><!-- end col-md-12 -->
                                </div><!-- end row -->
                                </div><!-- end container -->
                                </div><!-- end text align -->
                                </div><!-- end hero content -->
                                </div><!-- end hero main -->
                                </div><!-- end slider -->
                                </div><!-- end home-container -->


                                <!--================ ROOMS ==============-->
                                <section id="rooms" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <div class="page-heading">
                    <h2>Today's <span>Scheduled Fleets</span></h2>
                    <p>List of fleets scheduled today...</p>
                </div><!-- end page-heading -->

                <div class="owl-carousel owl-theme" id="owl-rooms">

                    <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
                                    <img src="{{ asset('theme_one/images/room-1.jpg') }}" class="img-fluid" alt="room-image" />
                                    <div class="room-title">
                                        <a href="#">
                                            <h3>Nairobi ~ Mombasa</h3>
                                        </a>
                                        <div class="rating">
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </div><!-- end rating -->
                                        </div><!-- end room-title -->
                                        </div><!-- end room-img -->

                                        <div class="room-price">
                                            <ul class="list-unstyled">
                                                <li>KShs 1800<span class="link"><a href="#" style="color:white;" class="btn btn-warning">Book</a></span></li>
                                            </ul>
                                        </div><!-- end room-price -->
                                        </div><!-- end room-block -->
                                        </div><!-- end grid -->
                                        </div><!-- end item -->

                    <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
                                    <img src="{{ asset('theme_one/images/room-3.jpg') }}" class="img-fluid" alt="room-image" />
                                    <div class="room-title">
                                        <a href="#">
                                            <h3>Nairobi ~ Kisumu</h3>
                                        </a>
                                        <div class="rating">
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </div><!-- end rating -->
                                    </div><!-- end room-title -->
                                </div><!-- end room-img -->

                                <div class="room-price">
                                    <ul class="list-unstyled">
                                        <li>KShs 1500<span class="link"><a href="#">Book</a></span></li>
                                    </ul>
                                </div><!-- end room-price -->
                            </div><!-- end room-block -->
                        </div><!-- end grid -->
                        </div><!-- end item -->

                    <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
                                    <img src="{{ asset('theme_one/images/room-5.jpg') }}" class="img-fluid" alt="room-image" />
                                    <div class="room-title">
                                        <a href="#">
                                            <h3>Nairobi ~ Eldoret</h3>
                                        </a>
                                        <div class="rating">
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </div><!-- end rating -->
                                    </div><!-- end room-title -->
                                </div><!-- end room-img -->

                                <div class="room-price">
                                    <ul class="list-unstyled">
                                        <li>KShs 1200<span class="link"><a href="#">Book</a></span></li>
                                    </ul>
                                </div><!-- end room-price -->
                            </div><!-- end room-block -->
                        </div><!-- end grid -->
                        </div><!-- end item -->

                    <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
                                    <img src="{{ asset('theme_one/images/room-3.jpg') }}" class="img-fluid" alt="room-image" />
                                    <div class="room-title">
                                        <a href="#">
                                            <h3>Meru ~ Nairobi</h3>
                                        </a>
                                        <div class="rating">
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </div><!-- end rating -->
                                    </div><!-- end room-title -->
                                </div><!-- end room-img -->

                                <div class="room-price">
                                    <ul class="list-unstyled">
                                        <li>KShs 1000<span class="link"><a href="#">Book</a></span></li>
                                    </ul>
                                </div><!-- end room-price -->
                            </div><!-- end room-block -->
                        </div><!-- end grid -->
                        </div><!-- end item -->

                    <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
                                    <img src="{{ asset('theme_one/images/room-1.jpg') }}" class="img-fluid" alt="room-image" />
                                    <div class="room-title">
                                        <a href="#">
                                            <h3>Mombasa ~ Nairobi</h3>
                                        </a>
                                        <div class="rating">
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </div><!-- end rating -->
                                    </div><!-- end room-title -->
                                </div><!-- end room-img -->

                                <div class="room-price">
                                    <ul class="list-unstyled">
                                        <li>KShs 1800<span class="link"><a href="#">Book</a></span></li>
                                    </ul>
                                </div><!-- end room-price -->
                            </div><!-- end room-block -->
                        </div><!-- end grid -->
                        </div><!-- end item -->

                        </div><!-- end owl-rooms -->
                        </div><!-- end columns -->
                        </div><!-- end row -->
                        </div><!-- end container -->
                        </section><!-- end rooms -->


                        <!--================ SERVICES ==============-->
                        <section id="services" class="section-padding no-pd-bot">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="page-heading">
                                            <h2>Our <span>Services</span></h2>
                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                                tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis
                                                nostrud exerci tation ullamcorper suscipit.</p>
                                        </div><!-- end page-heading -->

                                        <div id="service-blocks">
                                            <div class="row">

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="service-block">
                                                        <span><i class="fa fa-coffee"></i></span>
                                                        <h2 class="service-name">Tickets Booking</h2>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti sit dicta quae
                                                            natus quasi ratione quis id, tenetur atque blanditiis.</p>
                                                    </div><!-- end service-block -->
                                                </div><!-- end columns -->

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="service-block">
                                                        <span><i class="fa fa-leaf"></i></span>
                                                        <h2 class="service-name">Parcels</h2>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti sit dicta quae
                                                            natus quasi ratione quis id, tenetur atque blanditiis.</p>
                                                    </div><!-- end service-block -->
                                                </div><!-- end columns -->
                                            </div><!-- end row -->
                                        </div><!-- end service-blocks -->

                                    </div><!-- end columns -->
                                </div><!-- end row -->
                            </div><!-- end container -->
                        </section><!-- end services -->

                        <br><br>


                        <!--=============== TESTIMONIALS ==============-->
                        <section id="testimonials" class="banner-padding">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">

                                        <div class="carousel slide review-carousel" data-ride="carousel">

                                            <div class="row">
                                                <div class="col-3 col-md-1 col-lg-1 col-xl-1">
                                                    <ol class="carousel-indicators">
                                                        <li data-target=".review-carousel" data-slide-to="0" class="active"></li>
                                                        <li data-target=".review-carousel" data-slide-to="1"></li>
                                                        <li data-target=".review-carousel" data-slide-to="2"></li>
                                                    </ol>
                                                </div><!-- end columns -->

                                                <div class="col-12 col-md-11 col-lg-11 col-xl-11">
                                                    <div class="row">
                                                        <div class="col-12 offset-md-4 col-md-8 offset-lg-3 col-lg-7 offset-xl-3 col-xl-7">
                                                            <h2>What People Say About Us</h2>
                                                        </div><!-- end columns -->
                                                    </div><!-- end row -->

                                                    <div class="carousel-inner">

                                                        <div class="carousel-item active">
                                                            <div class="row">

                                                                <div class="col-12 col-md-4 col-lg-3 col-xl-3 reviewer-image">
                                                                    <img src="{{ asset('theme_one/images/reviewer-1.jpg') }}" alt="reviewer-image" class="rounded-circle">
                                                                </div><!-- end columns -->

                                                                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                                                                    <p class="review-text">Lorem ipsum dolor sit amet, consectetuer
                                                                        adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
                                                                        dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
                                                                        quis nostrud exerci tation ullamcorper suscipit.</p>
                                                                    <div class="rating">
                                                                        <span><i class="fa fa-star"></i></span>
                                                                        <span><i class="fa fa-star"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                    </div><!-- end rating -->
                                                                    <p class="reviewer-name">Lorem Ipsum</p>
                                                                </div><!-- end columns -->

                                                            </div><!-- end row -->
                                                        </div><!-- end item -->

                                                        <div class="carousel-item">
                                                            <div class="row">

                                                                <div class="col-12 col-md-4 col-lg-3 col-xl-3 reviewer-image">
                                                                    <img src="{{ asset('theme_one/images/reviewer-1.jpg') }}" alt="reviewer-image" class="rounded-circle">
                                                                </div><!-- end columns -->

                                                                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                                                                    <p class="review-text">Lorem ipsum dolor sit amet, consectetuer
                                                                        adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
                                                                        dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
                                                                        quis nostrud exerci tation ullamcorper suscipit.</p>
                                                                    <div class="rating">
                                                                        <span><i class="fa fa-star"></i></span>
                                                                        <span><i class="fa fa-star"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                    </div><!-- end rating -->

                                                                    <p class="reviewer-name">Lorem Ipsum</p>
                                                                </div><!-- end columns -->

                                                            </div><!-- end row -->
                                                        </div><!-- end item -->

                                                        <div class="carousel-item">
                                                            <div class="row">

                                                                <div class="col-12 col-md-4 col-lg-3 col-xl-3 reviewer-image">
                                                                    <img src="{{ asset('theme_one/images/reviewer-1.jpg') }}" alt="reviewer-image" class="rounded-circle">
                                                                </div><!-- end columns -->

                                                                <div class="col-12 col-md-8 col-lg-9 col-xl-9">
                                                                    <p class="review-text">Lorem ipsum dolor sit amet, consectetuer
                                                                        adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
                                                                        dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
                                                                        quis nostrud exerci tation ullamcorper suscipit.</p>
                                                                    <div class="rating">
                                                                        <span><i class="fa fa-star"></i></span>
                                                                        <span><i class="fa fa-star"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                        <span><i class="fa fa-star star-opacity"></i></span>
                                                                    </div><!-- end rating -->

                                                                    <p class="reviewer-name">Lorem Ipsum</p>
                                                                </div><!-- end columns -->

                                                            </div><!-- end row -->
                                                        </div><!-- end item -->

                                                    </div><!-- end carousel-inner -->
                                                </div><!-- end columns -->
                                            </div><!-- end row -->
                                        </div><!-- end review-carousel -->
                                    </div><!-- end columns -->
                                </div><!-- end row -->
                            </div><!-- end container -->
                        </section><!-- end testimonials -->


                        <!--================ BANNER-2 =============-->
                        <section id="banner-2" class="banner-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                <div class="highlight-box">
                    <h2>11200</h2>
                    <h4>Total Bookings</h4>
                </div><!-- end highlight-box -->
            </div><!-- end columns -->

            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                <div class="highlight-box">
                    <h2>25400</h2>
                    <h4>Total Parcels</h4>
                </div><!-- end highlight-box -->
            </div><!-- end columns -->

            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                <div class="highlight-box">
                    <h2>150</h2>
                    <h4>Today's Bookings</h4>
                </div><!-- end highlight-box -->
            </div><!-- end columns -->

            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                <div class="highlight-box">
                    <h2>500</h2>
                    <h4>Today's Parcels</h4>
                </div><!-- end highlight-box -->
            </div><!-- end columns -->

            </div><!-- end row -->
            </div><!-- end container -->
            </section><!-- end banner-2 -->


            <!--============== CONTACT-FORM ===============-->
            <section id="contact-form-2" class="banner-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <h2>Contact Us</h2>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-5 col-xl-5">
                        <div class="address-text-icon">
                            <div class="a-icon">
                                <span><i class="fa fa-2x fa-map-marker"></i></span>
                            </div><!-- end columns -->

                            <div class="a-text">
                                <p>River Road Next to Shell, Nairobi, Kenya.</p>
                            </div><!-- end columns -->
                        </div><!-- end address-block -->

                        <div class="address-text-icon">
                            <div class="a-icon">
                                <span><i class="fa fa-2x fa-phone"></i></span>
                            </div><!-- end columns -->

                            <div class="a-text">
                                <p>Phone: +254 712345678</p>
                                <p>P.O Box: 123-60200</p>
                            </div><!-- end columns -->
                        </div><!-- end address-block -->

                        <div class="address-text-icon">
                            <div class="a-icon">
                                <span><i class="fa fa-2x fa-envelope"></i></span>
                            </div><!-- end columns -->

                            <div class="a-text">
                                <p>Support: <a href="#">support@shuttleapp.co.ke</a></p>
                                <p>Booking: <a href="#">booking@shuttleapp.co.ke</a></p>
                            </div><!-- end columns -->
                        </div><!-- end address-block -->
                    </div>
                    <div class="col-12 col-md-12 col-lg-7 col-xl-7 text-center">
                        <form>
                            <div class="row">
                                <div class="col-md-6 slide-right-vis">

                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Email" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Subject" required />
                                    </div>
                                </div><!-- end columns -->

                                <div class="col-md-6 slide-left-vis">
                                    <div class="form-group m-0">
                                        <textarea class="form-control" placeholder="Your Message"></textarea>
                                    </div>
                                </div><!-- end columns -->

                                <div class="col-md-12 text-center">
                                    <a href="#" class="btn btn-yellow btn-block">Submit</a>
                                </div><!-- end butn -->
                                </div><!-- end row -->
                        </form>
                    </div><!-- end columns -->
                    </div><!-- end row -->

                    </div><!-- end columns -->
                    </div><!-- end row -->
                    </div><!-- end container -->
                    </section><!-- end newsletter -->
@endsection