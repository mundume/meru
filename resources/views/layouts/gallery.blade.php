<style>
    .close {
  font-size: 1.5rem;
}

.col-12 img {
  opacity: 0.7;
  cursor: pointer;
  margin: 2rem;
  width: 100%;
}

.col-12 img:hover {
  opacity: 1;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>



<div class="container ">
<div class="flex-wrap row d-flex align-items-center tw-w-full tw-my-5 tw-m-auto tw-text-center" data-toggle="modal" data-target="#lightbox">
    <h1 class=" tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-pink-300 tw-to-purple-300 tw-font-bold tw-p-4 tw-m-auto tw-block tw-text-center">Our fleet gallery</h1>
  <div class=" tw-w-[90%] tw-block tw-m-auto tw-text-center tw-mb-5 ">
    
<img src="{{ asset('theme_one/images/meru2.webp') }}" data-target="#indicators" data-slide-to="0" alt=""  class="tw-w-full tw-rounded tw-max-h-96"    /> 
  </div>
  <div class="tw-w-[90%] tw-block tw-m-auto tw-text-center tw-mb-5">
       <img src= "{{ asset('theme_one/images/meru2.webp') }}" data-target="#indicators" data-slide-to="1" alt=""  class="tw-w-full tw-rounded tw-max-h-96"/>
  </div>
  <div class="tw-w-[90%] tw-block tw-m-auto tw-text-center tw-mb-5">
     <img src="{{ asset('theme_one/images/meru2.webp') }}" data-target="#indicators" data-slide-to="2"  alt=""  class="tw-w-full tw-rounded tw-max-h-96"/>
  </div>
  <div class="tw-w-[90%] tw-block tw-m-auto tw-text-center tw-mb-5">
       <img src="{{ asset('theme_one/images/meru2.webp') }}" data-target="#indicators" data-slide-to="3" alt="" class="tw-w-full tw-rounded tw-max-h-96" />
  </div>
  <div class="tw-w-[90%] tw-block tw-m-auto tw-text-center tw-mb-5">
       <img src="{{ asset('theme_one/images/meru2.webp') }}" data-target="#indicators" data-slide-to="3"  alt="" class="tw-w-full tw-max-h-96 tw-rounded"/>
  </div>
  <div class="tw-w-[90%] tw-block tw-m-auto tw-text-center tw-mb-5">
       <img src="{{ asset('theme_one/images/meru2.webp') }}" data-target="#indicators" data-slide-to="4" alt="" class="tw-w-full tw-rounded tw-max-h-96" />
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="lightbox" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <button type="button" class="p-2 text-right close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div id="indicators" class="carousel slide" data-interval="false">
  <ol class="carousel-indicators">
    <li data-target="#indicators" data-slide-to="0" class="active"></li>
    <li data-target="#indicators" data-slide-to="1"></li>
    <li data-target="#indicators" data-slide-to="2"></li>
    <li data-target="#indicators" data-slide-to="3"></li>
    <li data-target="#indicators" data-slide-to="4"></li>
    <li data-target="#indicators" data-slide-to="5"></li>
  </ol>
  <div class="carousel-inner tw-bg-transparent">
    
    <div class="carousel-item active">
      
      <img class="d-block w-100 tw-max-h-96" src="{{ asset('theme_one/images/meru2.webp') }}" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 tw-max-h-96 " src="{{ asset('theme_one/images/meru2.webp') }}" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 tw-max-h-96 " src="{{ asset('theme_one/images/meru2.webp') }}" alt="Third slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 tw-max-h-96 " src="{{ asset('theme_one/images/meru2.webp') }}" alt="Fourth slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 tw-max-h-96 " src="{{ asset('theme_one/images/meru2.webp') }}" alt="Fifth slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 tw-max-h-96 " src="{{ asset('theme_one/images/meru2.webp') }}" alt="Sixth slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#indicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#indicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

    </div>
  </div>
</div>
                         </div>