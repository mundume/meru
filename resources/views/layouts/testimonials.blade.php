<style>
    .swiper-slide {
 padding: 40px;
  
}
.swiper-button-prev,
.swiper-button-next {
  display: none;
}
.swiper-pagination {
    color:purple;
}



</style>

<div class="tw-mb-7 tw-block tw-m-auto tw-text-center">
<p class="tw-border tw-bg-transparent tw-w-32 tw-rounded-3xl tw-block tw-m-auto">Testimonials</p>
<h1 class=" tw-font-bold tw-p-4 tw-text-4xl tw-text-transparent tw-font-mono tw-text-purple-400 tw-leading-10"> Dont take our word for it. <br/><span class="tw-font-bold tw-p-4 tw-text-4xl tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-sans">
    The whole of the Mountain region trusts us.
</span> </h1>

<div class="swiper tw-w-full tw-h-fit">
  <!-- Additional required wrapper -->
  <div class=" swiper-wrapper">
    <!-- Slides -->
    <div class=" swiper-slide tw-block tw-m-auto tw-text-center tw-w-full">
        <div class="p-2 tw-border tw-rounded tw-shadow-2xl ">
            <div class="tw-pt-6 tw-block tw-m-auto tw-text-center tw-mb-4">
<p class="px-3 tw-block tw-m-auto tw-text-center">I like the customer service,you won't be pushed   around by crew guys. Kudos guys...</p>
            </div>
            <div class="tw-flex tw-justify-between tw-items-center tw-p-2">
                <div class="tw-flex tw-items-center tw-justify-center">
                <img src="https://images.pexels.com/photos/15115627/pexels-photo-15115627.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="tw-w-14 tw-h-14 tw-rounded-full " />
                <p class="tw-px-2 tw-font-bold">Derrick Bundi</p>
                </div>
                 <div class="rating">
                    <span><i class="fa fa-star"></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star star-opacity" ></i></span>
                </div><!-- end rating -->
                
            </div>
</div>
        
    </div>

    <!-- slide 2 -->
    <div class=" swiper-slide tw-block tw-m-auto tw-text-center tw-w-full">
        <div class="p-2 tw-border tw-rounded tw-shadow-2xl ">
            <div class="tw-pt-6 tw-block tw-m-auto tw-text-center tw-mb-4">
<p class="px-3 tw-block tw-m-auto tw-text-center">I sent my parcel through Meru Artist Coaches and guess what, they delivered it into my door. Thank you guys.</p>
            </div>
            <div class="tw-flex tw-justify-between tw-items-center tw-p-2">
                <div class="tw-flex tw-items-center tw-justify-center">
                <img src="https://images.pexels.com/photos/15115627/pexels-photo-15115627.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="tw-w-14 tw-h-14 tw-rounded-full " />
                <p class="tw-px-2 tw-font-bold">Cecil Kendi</p>
                </div>
                 <div class="rating">
                    <span><i class="fa fa-star"></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star star-opacity" ></i></span>
                </div><!-- end rating -->
                
            </div>
</div>
        
    </div>
    <!-- slide 3 -->
    <div class=" swiper-slide tw-block tw-m-auto tw-text-center tw-w-full">
        <div class="p-2 tw-border tw-rounded tw-shadow-2xl ">
            <div class="tw-pt-6 tw-block tw-m-auto tw-text-center tw-mb-4">
<p class="px-3 tw-block tw-m-auto tw-text-center">I like the customer service,you won't be pushed   around by crew guys. Kudos guys...</p>
            </div>
            <div class="tw-flex tw-justify-between tw-items-center tw-p-2">
                <div class="tw-flex tw-items-center tw-justify-center">
                <img src="https://images.pexels.com/photos/15115627/pexels-photo-15115627.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="tw-w-14 tw-h-14 tw-rounded-full " />
                <p class="tw-px-2 tw-font-bold">Steve Ruiz</p>
                </div>
                 <div class="rating">
                    <span><i class="fa fa-star"></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star" ></i></span>
                    <span><i class="fa fa-star star-opacity" ></i></span>
                </div><!-- end rating -->
                
            </div>
</div>
        
    </div>
    
  </div>
  <!-- If we need pagination -->
  <div class="swiper-pagination tw-py-5 ">
    
  </div>

  <!-- If we need navigation buttons -->
 
  <!-- If we need scrollbar -->
 
</div>
</div>

<script type="module">
  import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.esm.browser.min.js'

 const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
    disabledClass: 'disabled_swiper_button'
  },

  autoplay: {
    delay:2000
  }
  
  // And if we need scrollbar
  
});
</script>


