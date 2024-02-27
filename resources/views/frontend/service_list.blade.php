@extends('layouts.app')
@section('content')
<div class="service">
    <div class="container">
        <div class="service-2d">
            <div class="vertical-space-80"></div>
            <h2 class="heading text-center">{{$service->service_name}}</h2>
            <div class="service-content">
                <p>
                    {!!$service->service_description!!}
                </p>
                <p class="text-center mt-5">
                    <a  href="#" data-toggle="modal" data-target="#myModal"  class="btn-df text-decoration-none"><span>Get In Quote</span></a>
                </p>
            
            <div class="vertical-space-50"></div>
        
        <div class="service2d-detail">
              <div class="row ">
        
        @if(count($service_list))
          @foreach($service_list as $key=> $row)    
          
                <div class="col-md-6 mt-5">
                     <img src="{{url('/')}}public/images/servicelist/{{$row->service_list_image}}"  />
                    <div class="service-2d-box p-4">
                        <h2 class="text-center">{{$row->service_list_name}}</h2>
                        <p class="">
                            {!! strip_tags($row->service_list_description) !!}
                        </p>
                    </div>
                </div>



          
           @endforeach
        @endif   
        </div>
    </div>
</div>
    </div>
</div>

<div class="vertical-space-60"></div>


@endsection 