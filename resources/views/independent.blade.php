

@extends('layouts.main')
@section('title', 'Home')
<style>
    .hero-text{
      border:none;
    }
    .navbar.header-1 {
        background-color: transparent;
        
    }
   
    .button{
        padding:10px 12px;
        cursor: pointer;
        border-radius:5px;
        transition:.3s;
        background-color:#6a1b9a;
        margin:5px;
        font-weight: 500;
        width: 100px;
        
        
    }
    .buttona{
        padding:10px 12px;
        cursor: pointer;
        border-radius:5px;
        transition:.3s;
        background-color:#6a1b9a;
        margin:5px;
        width: 100px;
        font-weight: 500;
        
        
    }
    .button:hover{
        scale: 1.1;
        color:white;
        font-weight:700;
    }
    .button:focus {
        scale:1.1;
        color:white;
        font-weight:700;
    }
    .buttona:hover{
        scale: 1.1;
        color:white;
        font-weight:700;
    }
    .buttona:focus {
        scale:1.1;
        color:white;
        font-weight:700;
    }
    span{
        color:#ce93d8;
        font-weight:700;

    }
</style>
@section('body')
    <div class="home-container tw-bg-gray-900 tw-border-b-2 tw-border-gray-900">

        <!-- Hero -->
<div class="p-5 text-center pt-7 bg-image rounded-3" style="
    background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/041.webp');
    height: 500px;
  ">
  <div class="mask">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="text-white">
        <h1 class="mt-6 mb-3 tw-font-sans " style="font-size:3rem">Karibu <br>
    <span class="tw-font-bold tw-p-4 tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-sans">Meru Artist</span> </h1>
        <h4 class="mb-3 text-lg tw-font-mono" style="font-size: 26px;font-weight:400">Where comfort meets class</h4>
        <div class=" d-flex justify-content-center align-items-center tw-font-sans"><a class="buttona button tw-font-bold tw-p-2 tw-border tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-sans" href="#gallery" role="button">Gallery</a>
    <a href="#book" class="button tw-font-bold tw-p-2 tw-border tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-sans"
    "> Book Now</a>
 </div>
        
      </div>
    </div>
  </div>
   </div><!-- end slider -->
    </div><!-- end home-container -->
    
   

 <section class="tw-bg-gray-900 tw-border-2 tw-border-gray-900 ">
 <div class="tw-m-4 tw-rounded-md" id="book">
    <h1 class=" tw-font-mono tw-text-3xl tw-block tw-m-auto tw-text-center tw-text-white">Experience The Magic With Us <br>
<span class="tw-font-bold tw-p-4 tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-sans">Book Now!</span></h1>
            @include('layouts.search_form')
            
        </div><!-- end hero text -->>
</div>
        </section>   
   
                          
       


    <!--================ ROOMS ==============-->
    <section id="rooms" class="">
        <div class="">
            <div class="">
                <div class="">
                    <div class="">
                        <h2 style="">Today's Scheduled Fleets</h2>
                        <p style="color:white">List of fleets scheduled today...</p>
                    </div><!-- end page-heading -->

                    <div class="owl-carousel owl-theme" id="owl-rooms">

                        @forelse($routes as $item)
                            <div>
                                <div class="grid">
                                    <div class="room-block">
                                        <div class="room-img">
                                            <img src="{{ asset('booking_.png') }}" class="img-fluid"
                                                alt="room-image" />
                                            <div class="room-title">
                                                <a href="/route/booking/{{ base64_encode($item->id) }}">
                                                    <h3>{{ $item->departure }} ~ {{ $item->destination }}</h3>
                                                </a>
                                               
                                            </div><!-- end room-title -->
                                        </div><!-- end room-img -->

                                        <div class="room-price">
                                            <ul class="list-unstyled">
                                                <li style="font-size: 13px;">Kes {{ number_format($item->amount, 2) }}<span
                                                        class="link"><a
                                                            href="/route/booking/{{ base64_encode($item->id) }}"
                                                            style="color:white;" class="btn btn-warning">Book</a></span>
                                                </li>
                                            </ul>
                                        </div><!-- end room-price -->
                                    </div><!-- end room-block -->
                                </div><!-- end grid -->
                            </div>
                        @empty
                            <div>
                                <div class="grid">
                                    <p style="color:white">Oops, no fleet available!</p>
                                </div>
                            </div>
                        @endforelse

                        {{-- <div>
                                <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
<img src="{{ asset('theme_one/images/logo.png') }}" class="img-fluid" alt="room-image" />
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
</div><!-- end item --> --}}

                        {{-- <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
<img src="{{ asset('theme_one/images/logo.png') }}" class="img-fluid" alt="room-image" />
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
</div><!-- end item --> --}}

                        {{-- <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
<img src="{{ asset('theme_one/images/meru2.webp') }}" class="img-fluid" alt="room-image" />
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
</div><!-- end item --> --}}

                        {{-- <div>
                        <div class="grid">
                            <div class="room-block">
                                <div class="room-img">
<img src="{{ asset('theme_one/images/logo.png') }}" class="img-fluid" alt="room-image" />
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
</div><!-- end item --> --}}

                    </div><!-- end owl-rooms -->
                </div><!-- end columns -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end rooms -->

    <div id="gallery">
        @include('layouts.gallery')

   
    </div>
<div id="services">
     <section id="" class=" tw-bg-gray-900">
        <div class="">
            <div class="">
                <div class=" tw-block tw-m-auto tw-text-center">
                    <div class="">
                        <h2 class="tw-font-bold tw-p-4 tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-mono">Our Services</h2>
                        <p class=" tw-p-7 tw-font-sans">As an organization, we are committed to providing our customers with the highest quality of
                            service and safety in the
                            transport industry.</p>
                    </div><!-- end page-heading -->

                    <div id="">
                        <div class="p-3 tw-block tw-m-auto">

                            <div class="" >
                                <div class="mt-4 mb-6 border tw-w-full tw-text-center tw-m-auto tw-flex tw-flex-col tw-justify-around tw-items-center tw-h-64 tw-shadow-2xl tw-rounded-md" >
                                    <span class=""><i style="color:white" class="fa fa-bus tw-text-3xl "></i></span>
                                    <h2 class="tw-p-4 tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500">Tickets Booking</h2>
                                    <p>You book, we preserve seat for you all at click of the button. Our committment is to
                                        serve you better.</p>
                                </div><!-- end service-block -->
                            </div><!-- end columns -->
                            </div><!-- end row -->

                            <div class="p-3 tw-block tw-m-auto">

                            <div class="" >
                                <div class="mt-4 mb-4 border tw-w-full tw-text-center tw-m-auto tw-flex tw-flex-col tw-justify-around tw-items-center tw-h-64 tw-shadow-2xl tw-rounded-md" >
                                    <span class=""><i style="color:white" class="fa fa-truck tw-text-3xl "></i></span>
                                    <h2 class="tw-p-4 tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500">Parcel Deliveries</h2>
                                    <p>Affordable rates and security of your parcel is our concerns. Send parcel with us
                                        today.</p>
                                </div><!-- end service-block -->
                            </div><!-- end columns -->

    
                            
                        </div><!-- end row -->
                    </div><!-- end service-blocks -->

                </div><!-- end columns -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end services -->

</div>
 
   
    <br><br>
<!-- Gallery -->

<div id="testimonials " class =" tw-block tw-m-auto tw-text-center">
    @include('layouts.testimonials')
</div>

    <!--================ BANNER-2 =============-->
    <section id="banner-2" class="banner-padding" >
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="highlight-box">
                        <h2>{{ $total_booking }}</h2>
                        <h4>Total Bookings</h4>
                    </div><!-- end highlight-box -->
                </div><!-- end columns -->

                <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="highlight-box">
                        <h2>{{ $total_parcel }}</h2>
                        <h4>Total Parcels</h4>
                    </div><!-- end highlight-box -->
                </div><!-- end columns -->

                <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="highlight-box">
                        <h2>{{ $today_booking }}</h2>
                        <h4>Today's Bookings</h4>
                    </div><!-- end highlight-box -->
                </div><!-- end columns -->

                <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="highlight-box">
                        <h2>{{ $today_parcel }}</h2>
                        <h4>Today's Parcels</h4>
                    </div><!-- end highlight-box -->
                </div><!-- end columns -->

            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end banner-2 -->

    <section id="contact" class=" tw-h-fit tw-bg-gray-900 sm:tw-flex sm:tw-justify-center sm:tw-items-center tw-block">
        <div class=" sm:tw-w-1/2">
          <h1 class="tw-text-4xl tw-text-white tw-font-bold tw-p-4 tw-m-auto tw-block tw-text-center">Love to Hear from you! <br/>
            <span class="tw-font-bold tw-p-4 tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-sans">Lets get in touch</span>
          </h1>

        </div>
        <div  class="sm:tw-w-1/2 ">
<form action="mailto:nzaih18@gmail.com" method="POST" type="text" class="  tw-flex tw-flex-col tw-justify-around  tw-h-full tw-mb-6 tw-bg-gray-900 tw-text-white sm:tw-w-96 tw-w-[90%]">
    <div class="tw-flex tw-justify-between tw-items-center" >
 <label for="name" class="tw-font-bold">  Name</label>
<input type="email" name="email" placeholder="Email" class=" tw-m-2 tw-px-4 tw-py-3 tw-outline-none tw-rounded tw-text-gray-900 tw-w-72" />
    
    </div >

    <div class=" tw-flex tw-justify-between tw-items-center">
    <label for="name" class="tw-font-bold"> Email</label>
    
    <input type="text" name="name" placeholder="Name" class=" tw-m-2 tw-px-4 tw-py-3 tw-border tw-rounded tw-outline-none tw-text-gray-900 tw-w-72"/>
    </div>
    <div class="tw-flex tw-justify-between tw-items-center">
    <label for="message" class="tw-font-bold"> Info</label>
    <input type="textarea" name="message" placeholder="Message" class=" tw-m-2 tw-px-4 tw-py-7 tw-border tw-rounded tw-outline-none tw-text-gray-900 tw-w-72"/>
    </div>
    <button type="submit" class="py-2 border tw-mt-3 tw-mb-5 tw-block tw-px-3 tw-items-center tw-m-auto tw-rounded">Submit</button>
</form>

        </div>
    </section>


    <script>
    document.querySelector('img').addEventlistener('click', ()=>console.log('clicked'))
 //zoom image on click
    
  // Or with jQuery
  

  
</script>
 <!-- Or use the minified version -->
    <script src="js/lightgallery.min.js"></script>

    <!-- lightgallery plugins -->
    <script src="js/plugins/lg-thumbnail.umd.js"></script>
    <script src="js/plugins/lg-zoom.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>


@endsection
