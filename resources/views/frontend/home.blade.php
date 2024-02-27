@extends('layouts.app')
@section('content')
@if(@$banner->banner_status)
      <div class="banner">
         <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="{{url('/')}}/public/images/banner/{{@$banner->banner_image}}" type="video/mp4" />
         </video>
          <div class="vertical-space-150"></div>
         <div class="banner-text" data-aos="fade-right" data-aos-delay="300" data-aos-duration="500">
            <div class="container text-center">
                <h2>
                   {{@$banner->banner_name}}
                </h2>
                <p>
                  {{@$banner->banner_description}}
                </p>
                <a href="{{@$banner->banner_link}}" class="btn btnn mt-3 btn-df"> <span> GET STARDED</span></a>
            </div>
         </div>
      </div>
@endif
      <div class="our-services">
         <div class="container">
            <h2 class="mb-5 text-center"><b>WELCOME TO THE <span class="common"> BEGINNING</span> OF AN <span class="common"> INCREDIBLE DIGITAL EXPERIENCE </span></b></h2>
            <div class="row">
         @if(count($futures)) 
            @foreach($futures as $row)     
               <div class="col-md-4">
                  <div class="services-list" data-aos="zoom-in">
                     <p  class="text-center"><img src="{{URL::to('/')}}/public/images/futures/{{ $row->image_name}}" width="100%"></p>
                     <h3 class="mt-3 mb-2">{{$row->heading}}</h3>
                     <p><span class="common">RS Animates</span> {{$row->description}}</p>
                  </div>
               </div>
            @endforeach   
         @endif
            </div>
         </div>
      </div>
      <div class="our-clients" data-aos="fade-down">
         <div class="container">
            <h2 class="mb-5 heading"><b>Our <span class="common">Clients</span></b></h2>
            <div class="owl-carousel owl-theme our-clients-list ">
         @if(count($clients)) 
            @foreach($clients as $row)   
               <div class="item ">
                 <div class="client-detail-box">
                  <img src="{{URL::to('/')}}/public/images/clients/{{ $row->clients_image}}">
                  </div>
               </div>
           @endforeach   
         @endif 
           </div>    
         </div>
      </div>
   

  
      
      
      <div class="about-together " data-aos="zoom-in">
         <div class="vertical-space-120"></div>
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h2 class="">Let's talk about what we can create together</h2>
                  <p>
                     Tell us what you need and we’ll get it done! Be it a simple <br>
 beginner video, a complex 3D web-series, an Anime Animation, 2D custom video, Logo Animation or a full-fledged Animation movie, we cater to all your needs.
                  </p>
                  <a  href="#" data-toggle="modal" data-target="#myModal" class="btn mt-3 btn-df"> <span class="">Contact Us For Free Quate</span></a>
               </div>
              
         </div>
          <div class="vertical-space-120"></div>
      </div>
      
@endsection     

@push('scripts')
<script type="text/javascript">
         AOS.init();
         
         
         $(".our-clients-list").owlCarousel({
         
            loop:true,
            nav:true,
             margin:0,
             autoplay:true,
             autoplayTimeout:3000,
             autoplayHoverPause:true,
             responsiveClass: true,
             responsive: {
                 0: {
                     items: 1,
                      nav:true,
         
                 },
                 600: {
                     items: 3,
                      nav:true,
                
                 },
                 1000: {
         
                    items: 5,
                     nav:true,
                
                 },
         
             },
         
         });
         
       
         
         $(".owl-prev").html('<i class="fa fa-chevron-left"></i>');
         
         $(".owl-next").html('<i class="fa fa-chevron-right"></i>');
         
         
    
         
      </script>
@endpush('scripts') 
         