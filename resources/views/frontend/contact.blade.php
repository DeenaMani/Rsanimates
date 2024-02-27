  @php
        $setting = \App\Models\Setting::find(1);
        $service = \App\Models\Service::all();
  @endphp
@extends('layouts.app')
@section('content')
<div class="contact-page">
    <div class="container">
        <div class="vertical-space-100"></div>

        <h2 class="heading text-center">Contact <span class="common">Us</span></h2>
        <div class="row mt-5">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <form class="contact-form" action="{{url('post_contact')}}" method="post" enctype="multipart/form-data" id="contacting">
                    @csrf
                    @if(Session::has('success'))

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        <strong>
                                            {{ Session::get('success') }}
                                        </strong>
                                    
                                    </div>
                                </div>
                            </div>
                        @endif
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" required/>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="number" class="form-control" name="mobile" placeholder="Enter  Number" required/>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email" required />
                    </div>
                  <!--   <div class="form-group">
                        <label class="form-label">Services</label>
                        <select class="custom-select mr-sm-2" name="service_name" required>
                            <option value="">Select Services</option>
                            @if(count($service))
                              @foreach($service as $row)
                               <option value="{{$row->service_name}}">{{$row->service_name}}</option>
                              @endforeach
                            @endif   
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" placeholder="Company Name" required/>
                    </div>
                    <div class="form-group my-2">
                        <label class="form-label" for="customFile">Choose file</label>
                        <input type="file" class="form-control form-file" id="customFile" name="contact_image" required/>
                    </div> -->
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="3" name="contact_message" placeholder="Write Your Message" required></textarea>
                    </div>
                    <p class="text-center mt-4">
                        <button type="submit" class="btn btn-md"><span>Submit</span></button>
                    </p>
                </form>
            </div>
            <div class="col-md-5">
                <div class="contact-address">
                    <div class="address1">
                        <h2 class="">{{$setting->company_name}}</h2>
                        <p class="mt-3">{{$setting->company_address}}</p>
                        <p class="mt-3">
                            <a href="#"><i class="fa fa-envelope"></i>{{$setting->company_email}}    </a>
                        </p>
                        <p class="">
                            <a href="#"><i class="fa fa-phone"></i> {{$setting->company_mobile}}</a>
                        </p>
                        <ul class="list-unstyled d-flex mt-4 footer-icon">
                            <li>
                        <a href="{{$setting->facbook}}" target="_new"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="{{$setting->google_plus}}"  target="_new" ><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="{{$setting->youtube}}"  target="_new" ><i class="fa fa-youtube" aria-hidden="true"></i></a>
                     </li>
                     <li>
                        <a href="{{$setting->instrgram}}"  target="_new" ><i class="fa fa-instagram" aria-hidden="true"></i></a>
                     </li>
                      <li>
                        <a href="{{$setting->indeed}}"  target="_new" ><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                     </li>
                      <li>
                       <a href="{{$setting->behance}}"  target="_new" ><i class="fa fa-behance-square" aria-hidden="true"></i></a>
                     </li>
                        </ul>
                    </div>
                </div>
                 <iframe
                    src="{{$setting->iframe}}"
                    width="100%"
                    height="300"
                    frameborder="0"
                    style="border: 0;"
                    allowfullscreen=""
                ></iframe>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="vertical-space-30"></div>
        <div class="vertical-space-60"></div>
    </div>
</div>

@endsection 

@push('scripts')
<script type="text/javascript">
$('#contacting').validate();       
</script>
@endpush('scripts')

          
         