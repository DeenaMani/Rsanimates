     @php
        $setting = \App\Models\Setting::find(1);
        $service = \App\Models\Service::all();
     @endphp

<!DOCTYPE html>
<html>
   <head>
      <title>{{$title}} | {{$setting->company_name}}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="shortcut icon" type="image/icon" href="{{url('/')}}/public/images/{{$setting->company_fav}}" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/font-awesome.min.css" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/owl.carousel.min.css" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/owl.theme.default.min.css" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/aos.css" />
      <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/style.css?v=1.433" />
   </head>
   <body>

       <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title text-centerx">GET A QUOTE</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="modal-form" action="{{url('post_contact')}}" method="post" enctype="multipart/form-data" id="contact">
                                          @csrf  
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Email address</label>
                                                <input type="email" name="email" class="form-control" placeholder="Enter email" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Phone</label>
                                                <input type="number" name="mobile" class="form-control" placeholder="Enter Your Number" required/>
                                            </div>
                                            <div class="form-group">
                                              <label class="form-label">Services</label>
                                               <select class="custom-select form-select mr-sm-2" name="service_name" required>
                                                <option value="">Select Service</option>
                                                @if(count($service))
                                                  @foreach($service as $row)
                                                <option value="{{$row->service_name}}">{{$row->service_name}}</option>
                                                  @endforeach
                                                @endif  
                                              </select>
                                            </div>
                                            <!--   <div class="form-group">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" name="company_name" class="form-control"  placeholder="Company Name" />
                                              </div>
                                            <div class="form-group my-2">
                                                <label class="form-label" for="customFile">Choose file</label>
                                                <input type="file" name="contact_image" class="form-control form-file" id="customFile" name="contact_image" />
                                            </div> -->
                                            <div class="form-group">
                                                <label class="form-label">Message</label>
                                                <textarea class="form-control" name="contact_message"  rows="3" placeholder="Write Your Message" required></textarea>
                                            </div>
                                            <p class="text-center">
                                                <button type="submit" class="btn btn-df"><span>Submit</span></button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
   
   
   <div class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-transparent">
            <div class="container">
                <a href="{{url('/')}}" class="navbar-brand"><img src="{{url('/')}}/public/images/main-logo.png" alt="" /></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse menu-bar" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto float-right">
                        <li class="nav-item"><a href="{{url('/')}}" class="nav-link {{$title=='Home'?'active':''}} effects">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{$title=='About Us'?'active':''}} effects" href="{{url('about-us')}}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link {{$title=='Service'?'active':''}} effects" href="{{url('service')}}">Service</a></li>
                        <li class="nav-item"><a class="nav-link {{$title=='Contact Us'?'active':''}} effects" href="{{url('contact-us')}}">Contact</a></li>
                        <li class="nav-item"><a class="btn quick" href="#" data-toggle="modal" data-target="#myModal">GET A QUOTE</a></li>
                        <!-- The Modal -->
                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
 

     @yield('content')

      <div class="footer">
            <div class="container">
              <div class="footer-detail">
                <div class="row">
                    <div class="col-md-3">
                        <p class=" footer-logo text-center"><img src="{{url('/')}}/public/images/main-logo.png" class="" /></p>
                    </div>
                    <div class="col-md-2">
                        <div class="footer-content">
                        <h4 class="common">Menus</h4>
                        <ul class="list-unstyled links">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{url('about-us')}}">About Us</a></li>
                            <li><a href="{{url('service')}}">Service</a></li>
                            <li><a href="{{url('contact-us')}}">Contact Us</a></li>
                        </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                      <div class="footer-content_2">
                      <!-- <h4 class="mt-5 common">Social<span class=""> Links</span></h4> -->
                  <p class=""><a href="#"><i  class="fa fa-envelope "></i>{{$setting->company_email}}</a></p>
                  <p class=""><a href="#"><i  class="fa fa-phone "></i>{{$setting->company_mobile}}</a></p>
                    <ul class="list-unstyled d-flex mt-4  footer-icon">
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
                    <div class="col-md-3">
                        <div class="footer_content3">
                        <h4 class=" common">Address</h4>
                        <p class="content-foot">{{$setting->company_address}}</p>
                       <!--  <div class="row">
                            <div class="col-md-12 mt-2">
                                <p class="common our-part">Our Part</p>
                                <p class="patner">
                                    <a href="https://softmoksa.com/"><img src="https://softmoksa.com/public/frontend/images/logo.png"  width="150px" style="padding:10px; background: #FFF"></a></p>
                            </div>
                        </div> -->
                         
                    </div>
                    </div>
                </div> 
               </div>
                   <div class="footer-last mt-2">  
                    <p class="text-center mt-2">Copyright &#169; <?php echo date('Y');?>. All Rights Are Reserved. </p> 
                </div>
            </div>
        </div>
       
     
      <script type="text/javascript" src="{{url('/')}}/public/js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript" src="{{url('/')}}/public/js/bootstrap.js"></script>
      <script type="text/javascript" src="{{url('/')}}/public/js/owl.carousel.min.js"></script>
      <script src="{{url('/')}}/public/js/aos.js"></script>
      @stack('scripts')


        <script type="text/javascript" src="{{url('/')}}/public/js/jquery.validate.js"></script>
        <script type="text/javascript">
        $('#contact').validate();    
        </script>
   </body>
</html>