@extends('layouts.admin')

@section('content')

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
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>

                                            @foreach($errors->all() as $error)
                                                <li>{{ $error}}</li>
                                            @endforeach 

                                        </ul>
                                    </div>
                                @endif
                            
                             
                        <form method="post" action="{{ route('profile.index') }}/{{$result->id}}" enctype="multipart/form-data" >
                            @csrf  

                            @method('PUT')

                        <input type="hidden" name="id" value="{{ $result->id }}">
                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">


                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label">
                                       Name
                                    </label>
                                    <div class="col-lg-6">
                                          <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name',$result->name) }}" required>
                                    </div>
                                </div>
                                

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label">
                                       Email
                                    </label>
                                    <div class="col-lg-6">
                                          <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email',$result->email) }}" readonly="" required>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label">
                                       Mobile
                                    </label>
                                    <div class="col-lg-6">
                                          <input type="number" class="form-control" name="mobile_no" placeholder="Mobile"  value="{{ old('mobile_no',$result->mobile_no) }}" required>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label">
                                       Gender
                                    </label>
                                    <div class="col-lg-6">
                                          <select name="gender" class="form-control">
                                              <option value="">Select Gender</option>
                                              <option value="1" {{ old('gender',$result->gender) == 1 ?  'selected'  : '' }} >Male</option>
                                              <option value="2" {{ old('gender',$result->gender) == 2 ?  'selected'  : '' }} >Female</option>
                                          </select>
                                    </div>
                                </div>


                                 <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label">
                                       Date of Birth
                                    </label>
                                    <div class="col-lg-6">
                                            <input type="date" id="dob" name="dob" class="form-control" placeholder="Date of Birth" value="{{ old('dob',$result->dob) }}" required="">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label">
                                       City
                                    </label>
                                    <div class="col-lg-6">
                                          <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city',$result->city) }}" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-6">
                                        
                                        <button class="btn btn-success"><span>Submit</span></button>
                                        <a href="{{ url('account/customer') }}" class="btn btn-danger"><span>Cancel</span></a>
                                    
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </form>        
                
                           
                        </div>
                    </div>
                </div>
@endsection

@push('scripts')

@endpush