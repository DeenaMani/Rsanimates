@extends('layouts.app')
@section('content')
<div class="work-banner">
    <div class="container">
        <div class="vertical-space-100"></div>
        <h2 class="heading">Our Works</h2>
        <ul class="list-unstyled d-flex">
            <li>
                <a href="service.html" class="btn btnn mt-3 btn-df"><span>All</span></a>
            </li>
            <li>
                <a href="#" class="btn btnn mt-3 btn-df"><span>2D Animations</span></a>
            </li>
            <li>
                <a href="#" class="btn btnn mt-3 btn-df"><span>3D Animations</span></a>
            </li>
            <li>
                <a href="#" class="btn btnn mt-3 btn-df"><span>Visual Effects</span></a>
            </li>
            <li>
                <a href="#" class="btn btnn mt-3 btn-df"><span>Motion Graphics</span></a>
            </li>
            <li>
                <a href="#" class="btn btnn mt-3 btn-df"><span>Graphic Design</span></a>
            </li>
        </ul>
        <div class="work-details">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{url('/')}}/public/images/animate.jpg" />
                    <div class="work-body">
                        <a href="#">See Projects <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                        <h4>2D Animations</h4>
                        <p>Rs Animates</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{url('/')}}/public/images/animate.jpg" />
                    <div class="work-body">
                        <a href="#">See Projects <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                        <h4>3D Animations</h4>
                        <p>Rs Animates</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{url('/')}}/public/images/animate.jpg" />
                    <div class="work-body">
                        <a href="#">See Projects <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                        <h4>Visual Effects</h4>
                        <p>Rs Animates</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <img src="{{url('/')}}/public/images/animate.jpg" />
                    <div class="work-body">
                        <a href="#">See Projects <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                        <h4>Motion Graphics</h4>
                        <p>Rs Animates</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{url('/')}}/public/images/animate.jpg" />
                    <div class="work-body">
                        <a href="#">See Projects <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                        <h4>Graphic Design</h4>
                        <p>Rs Animates</p>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
    <div class="vertical-space-30"></div>
</div>
@endsection 