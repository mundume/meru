

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
    <div class="bg-gray-900 border-b-2 border-gray-900 home-container">

        <!-- Hero -->
<div class="p-5 text-center pt-7 bg-image rounded-3" style="
    background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/041.webp');
    height: 500px;
  ">
  <div class="mask">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="text-white">
        <h1 class="mt-6 mb-3 font-sans " style="font-size:3rem">Karibu <br>
    <span class="p-4 font-sans text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500">Meru Artist</span> </h1>
        <h4 class="mb-3 font-mono text-lg" style="font-size: 26px;font-weight:400">Where comfort meets class</h4>
        <div class="font-sans d-flex justify-content-center align-items-center"><a class="p-2 font-sans font-bold text-transparent border buttona button bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500" href="#gallery" role="button">Gallery</a>
    <a href="#book" class="p-2 font-sans font-bold text-transparent border button bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500"
    "> Book Now</a>
 </div>
        
      </div>
    </div>
  </div>
   </div><!-- end slider -->
    </div><!-- end home-container -->
    
   

  <section class="bg-gray-900 border-2 border-gray-900 ">
 <div class="m-4 rounded-md" id="book">
    <h1 class="block m-auto font-mono text-3xl text-center text-white ">Experience The Magic With Us <br>
<span class="p-4 font-sans text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500">Book Now!</span></h1>
            @include('layouts.search_form')
            

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
     <section id="" class="bg-gray-900 ">
        <div class="">
            <div class="">
                <div class="block m-auto text-center ">
                    <div class="">
                        <h2 class="p-4 font-mono text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500">Our Services</h2>
                        <p class="font-sans p-7">As an organization, we are committed to providing our customers with the highest quality of
                            service and safety in the
                            transport industry.</p>
                    </div><!-- end page-heading -->

                    <div id="">
                        <div class="block p-3 m-auto">

                            <div class="" >
                                <div class="flex flex-col items-center justify-around h-64 m-auto mt-4 mb-6 text-center border rounded-md full shad2xl" >
                                    <span class=""><i style="color:white" class="text-3xl fa fa-bus "></i></span>
                                    <h2 class="p-4 text-4xl text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500">Tickets Booking</h2>
                                    <p>You book, we preserve seat for you all at click of the button. Our committment is to
                                        serve you better.</p>
                                </div><!-- end service-block -->
                            </div><!-- end columns -->
                            </div><!-- end row -->

                            <div class="block p-3 m-auto">

                            <div class="" >
                                <div class="flex flex-col items-center justify-around h-64 m-auto mt-4 mb-4 text-center border rounded-md full shad2xl" >
                                    <span class=""><i style="color:white" class="text-3xl fa fa-truck "></i></span>
                                    <h2 class="p-4 text-4xl text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500">Parcel Deliveries</h2>
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

<div id="testimonials " class ="block m-auto text-center ">
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

    <section id="contact" class="block bg-gray-900 h-fit sm:flex sm:justify-center sm:items-center">
        <div class=" sm:1/2">
          <h1 class="block p-4 m-auto text-4xl font-bold text-center text-white">Love to Hear from you! <br/>
            <span class="p-4 font-sans text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-pink-500">Lets get in touch</span>
          </h1>

        </div>
        <div  class="sm:1/2 ">
<form action="mailto:nzaih18@gmail.com" method="POST" type="text" class="  flex flex-col justify-around  h-full mb-6 bg-gray-900 text-white sm:96 [90%]">
    <div class="flex items-center justify-between" >
 <label for="name" class="font-bold">  Name</label>
<input type="email" name="email" placeholder="Email" class="px-4 py-3 m-2 text-gray-900 rounded outline-none 72" />
    
    </div >

    <div class="flex items-center justify-between ">
    <label for="name" class="font-bold"> Email</label>
    
    <input type="text" name="name" placeholder="Name" class="px-4 py-3 m-2 text-gray-900 border rounded outline-none 72"/>
    </div>
    <div class="flex items-center justify-between">
    <label for="message" class="font-bold"> Info</label>
    <input type="textarea" name="message" placeholder="Message" class="px-4 m-2 text-gray-900 border rounded outline-none py-7 72"/>
    </div>
    <button type="submit" class="items-center block px-3 py-2 m-auto mt-3 mb-5 border rounded">Submit</button>
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
