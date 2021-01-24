@extends('layouts.main')
@section('title', 'Home')
@section('body')
<div class="intro-section" id="home">
    <div class="slide-1" style="background-image: url('images/hero_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4">
                            <h1 data-aos="fade-up" data-aos-delay="100">Book unique express</h1>
                            <p class="mb-4" data-aos="fade-up" data-aos-delay="200">
                                We are the best because we offer the best
                            </p>
                            <p data-aos="fade-up" data-aos-delay="300"><a href="#" class="btn btn-primary py-3 px-5 btn-pill">Contact Us</a></p>
                        </div>
                        <div class="col-lg-5 ml-auto" data-aos="fade-up" data-aos-delay="500">
                            <form action="" method="post" class="form-box">
                                <h3 class="h4 text-black mb-4">Search Route</h3>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3 mb-lg-0">
                                        <input type="text" class="form-control" placeholder="Departure">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Destination">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Travel Date">
                                </div>
                                {{-- <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Email Addresss">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group mb-4">
                                    <input type="password" class="form-control" placeholder="Re-type Password">
                                </div> --}}
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
<div class="site-section courses-title" id="work">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
                <h2 class="section-title">Recommended routes</h2>
            </div>
        </div>
    </div>
</div>
<div class="site-section courses-entry-wrap" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="owl-carousel col-12 nonloop-block-14">
                <div class="course bg-white h-100 align-self-stretch">
                    <figure class="m-0">
                        <a href="course-single.html"><img src="images/img_1.jpg" alt="Image" class="img-fluid"></a>
                    </figure>
                    <div class="course-inner-text py-4 px-4">
                        <span class="course-price">1000.00</span>
                        <h3><a href="#">Meru ~ Nakuru</a></h3>
                    </div>
                    <div class="d-flex border-top stats">
                        <div class="py-3 px-4"><span class="icon-users"></span> 16 Seaters</div>
                        <div class="py-3 px-4 w-25 ml-auto border-left"><span class="icon-chat">16</span> </div>
                    </div>
                </div>
                <div class="course bg-white h-100 align-self-stretch">
                    <figure class="m-0">
                        <a href="course-single.html"><img src="images/img_2.jpg" alt="Image" class="img-fluid"></a>
                    </figure>
                    <div class="course-inner-text py-4 px-4">
                        <span class="course-price">1250.00</span>
                        <h3><a href="#">Nairobi ~ Meru</a></h3>
                    </div>
                    <div class="d-flex border-top stats">
                        <div class="py-3 px-4"><span class="icon-users"></span> 14 seaters</div>
                        <div class="py-3 px-4 w-25 ml-auto border-left"><span class="icon-chat"></span> 14</div>
                    </div>
                </div>
                <div class="course bg-white h-100 align-self-stretch">
                    <figure class="m-0">
                        <a href="course-single.html"><img src="images/img_3.jpg" alt="Image" class="img-fluid"></a>
                    </figure>
                    <div class="course-inner-text py-4 px-4">
                        <span class="course-price">3000.00</span>
                        <h3><a href="#">Nairobi ~ Mombasa</a></h3>
                    </div>
                    <div class="d-flex border-top stats">
                        <div class="py-3 px-4"><span class="icon-users"></span> 16 seaters</div>
                        <div class="py-3 px-4 w-25 ml-auto border-left"><span class="icon-chat"></span> 16</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row justify-content-center">
            <div class="col-7 text-center">
                <button class="customPrevBtn btn btn-primary m-1">Prev</button>
                <button class="customNextBtn btn btn-primary m-1">Next</button>
            </div>
        </div> --}}
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
                        <h3 class="m-0">22,931 Yearly Graduates</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center custom-icon-wrap">
                    <span class="custom-icon-inner mr-3"><span class="icon icon-university"></span></span>
                    <div>
                        <h3 class="m-0">150 Universities Worldwide</h3>
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
                        <h3 class="m-0">22,931 Yearly Graduates</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center custom-icon-wrap">
                    <span class="custom-icon-inner mr-3"><span class="icon icon-university"></span></span>
                    <div>
                        <h3 class="m-0">150 Universities Worldwide</h3>
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
                            <h3 class="m-0">22,931 Yearly Graduates</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-university"></span></span></div>
                        <div>
                            <h3 class="m-0">150 Universities Worldwide</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-graduation-cap"></span></span></div>
                        <div>
                            <h3 class="m-0">Top Professionals in The World</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-university"></span></span></div>
                        <div>
                            <h3 class="m-0">Expand Your Knowledge</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light mb-3">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-graduation-cap"></span></span></div>
                        <div>
                            <h3 class="m-0">Best Online Teaching Assistant Courses</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center custom-icon-wrap custom-icon-light">
                        <div class="mr-3"><span class="custom-icon-inner"><span class="icon icon-university"></span></span></div>
                        <div>
                            <h3 class="m-0">Best Teachers</h3>
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
                            <input type="text" class="form-control" placeholder="Subject">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea class="form-control" id="" cols="30" rows="10" placeholder="Write your message here."></textarea>
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