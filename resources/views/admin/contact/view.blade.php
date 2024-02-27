@extends('layouts.admin')



@section('content')

<style type="text/css">

  .sub_category_order { width: 100px; }

  .ml-25{ margin:20px !important; }

</style>

 <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                    <div class="kt-portlet kt-portlet--mobile">

                        <div class="kt-portlet__head kt-portlet__head--lg">

                            <div class="kt-portlet__head-label">

                                <span class="kt-portlet__head-icon">

                                    <i class="kt-font-brand flaticon2-line-chart"></i>

                                </span>

                                <h3 class="kt-portlet__head-title">

                                    {{ $title }}

                                </h3>

                            </div>

                        </div>

                        <div class="kt-portlet__body">



                          @if(Session::has('message'))



                                <div class="row">

                                    <div class="col-lg-12">

                                        <div class="alert alert-success" role="alert">

                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>

                                            <strong>

                                                {{ Session::get('message') }}

                                            </strong>

                                        

                                        </div>

                                    </div>

                                </div>

                            @endif



                            <table class="table table-bordered">    

                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{$result->first_name}}</td>   
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{$result->last_name}}</td>   
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td>{{$result->mobile}}</td>   
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{$result->email}}</td>   
                                    </tr>
                                    <tr>
                                        <th>Service Name</th>
                                        <td>{{$result->service_name}}</td>   
                                    </tr>
                                    <tr>
                                        <th>Company Name</th>
                                        <td>{{$result->company_name}}</td>   
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td>{{$result->contact_message}}</td>   
                                    </tr>
                                    <tr>
                                        <th>Image</th>
                                        <td><img src="{{base_url()}}/public/images/contact/{{$result->contact_image}}" width="50"></td>   
                                    </tr>

                                </thead>  

                            </table>

                        </div>

                    </div>

                </div>

@endsection







@push('scripts')

   

 @endpush

