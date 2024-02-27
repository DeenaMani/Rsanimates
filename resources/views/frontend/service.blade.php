@extends('layouts.app')
@section('content')
<div class="service-banner">
    <div class="container">
        <div class="vertical-space-100"></div>
        <h2 class="heading">Our <span class="common">Services</span></h2>
        <div class="service-details">
            <div class="row">

            @if(count($service))
              @foreach($service as $row)    
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{url('/')}}/public/images/service/{{$row->service_image}}" class="card-img-top" alt="{{$row->service_image}}" />
                        <div class="middle card-img-overlay">
                            <a href="{{url('service-list')}}/{{$row->service_slug}}">View More <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <h5 class="card-title"><a  href="{{url('service-list')}}/{{$row->service_slug}}">{{$row->service_name}}</a></h5>
                </div>
               @endforeach
            @endif   
            </div> 
        </div>
        <div class="vertical-space-30"></div>
    </div>
</div>

@endsection 