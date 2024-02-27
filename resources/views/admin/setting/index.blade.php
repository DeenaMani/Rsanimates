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

                           @if($errors->any())
                        <div class="alert alert-success alert-dismissible">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           {{ implode('', $errors->all('<div>:message</div>')) }}  
                        </div>
                          @endif
                            
                         <form method="post" action="{{ route('setting.index') }}/{{$result->id}}" enctype="multipart/form-data" >
                          @csrf  

                            @method('PATCH') 

                         <input type="hidden" name="id" value="{{ $result->id }}">

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">

                                            <div class="form-group m-form__group row">
                                            <label class="col-lg-3 col-form-label">
                                               Company Logo 1

                                           </label>
                                           <div class="col-lg-6">
                                         
                                            <img src="{{ URL::to('/')}}/public/images/{{$result->image_name}}" alt="" width="100" height="100" >

                                            <input type="file" class="form-control m-input" placeholder="" name="company_logo"  >
                                            <input type="hidden" name="company_logo_old" value="{{$result->image_name}}">
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">
                                           Company Logo 2
                                       </label>
                                       <div class="col-lg-6">
                                            <img src="{{ URL::to('/')}}/public/images/{{$result->image_name2}}" alt="" width="100" height="100" >
                                            <input type="file" class="form-control m-input" placeholder="" name="company_logo2"  >
                                            <input type="hidden" name="company_logo2_old" value="{{ $result->image_name2}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">
                                           Company Fav Icon
                                       </label>
                                       <div class="col-lg-6">
                                           
                                            <input type="file" class="form-control m-input" placeholder="" name="company_fav"  >
                                            <input type="hidden" name="company_fav_old" value="{{ $result->company_fav}}">
                                        </div>
                                    </div>

                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-3 col-form-label">
                                                   Company Name
                                               </label>
                                               <div class="col-lg-6">
                                                <input type="text" class="form-control m-input" placeholder="" name="company_name" value="{{$result->company_name}}" >

                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-3 col-form-label">
                                              Company Address
                                          </label>
                                          <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder="" name="company_address" value="{{$result->company_address}}" >

                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">
                                          Company Email
                                      </label>
                                      <div class="col-lg-6">
                                        <input type="text" class="form-control m-input" placeholder="" name="company_email"   value="{{ $result->company_email}}" >

                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">
                                      Company Mobile
                                  </label>
                                  <div class="col-lg-6">
                                    <input type="text" class="form-control m-input" placeholder="" name="company_mobile"   value="{{ $result->company_mobile}}" >

                                </div>
                              </div>


                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                   Currency
                               </label>
                               <div class="col-lg-6">
                                <input type="text" class="form-control m-input" placeholder="" name="currency" value="{{ $result->currency}}" >

                              </div>
                              </div>


                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                 Facbook
                              </label>
                              <div class="col-lg-6">
                                <input type="text" class="form-control m-input" placeholder="" name="facbook"   value="{{ $result->facbook}}"  >

                              </div>
                              </div>
                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  What's App
                              </label>
                              <div class="col-lg-6">
                                <input type="text" class="form-control m-input" placeholder="" name="google_plus" value="{{$result->google_plus}}"  >

                              </div>
                              </div>
                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Instrgram
                              </label>
                              <div class="col-lg-6">
                                <input type="text" class="form-control m-input" placeholder="" name="instrgram"  value="{{ $result->instrgram}}"  >

                              </div>
                              </div>

                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Youtube
                              </label>
                              <div class="col-lg-6">
                                <input type="text" class="form-control m-input" placeholder="" name="youtube"  value="{{ $result->youtube}}"  >

                              </div>
                              </div>

                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Indeed
                              </label>
                              <div class="col-lg-6">
                                <input type="text" class="form-control m-input" placeholder="" name="indeed"  value="{{ $result->indeed}}"  >

                              </div>
                              </div>

                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Behance
                              </label>
                              <div class="col-lg-6">
                                <input type="text" class="form-control m-input" placeholder="" name="behance"  value="{{ $result->behance}}"  >

                              </div>
                              </div>


                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Meta Title
                              </label>
                              <div class="col-lg-6">
                                <textarea class="form-control m-input" placeholder="Enter Meta Title" name="meta_title"  >{{ $result->meta_title}} </textarea>


                              </div>
                              </div>

                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Meta Keyword
                              </label>
                              <div class="col-lg-6">
                                <textarea class="form-control m-input" placeholder="Enter Meta Title" name="meta_keyword"  >{{ $result->meta_keyword}} </textarea>


                              </div>
                              </div>


                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Meta Description
                              </label>
                              <div class="col-lg-6">
                                <textarea class="form-control m-input" placeholder="Enter Meta Description" name="meta_description"  >{{ $result->meta_description}} </textarea>
                              </div>
                              </div>

                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Header script
                              </label>
                              <div class="col-lg-6">
                                <textarea class="form-control m-input" placeholder="Enter Header script" name="header_script"  >{{ $result->header_script}}</textarea>
                              </div>
                              </div>

                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Footer script
                              </label>
                              <div class="col-lg-6">
                                <textarea class="form-control m-input" placeholder="Enter Footer script" name="footer_script"  >{{ $result->footer_script}}</textarea>
                              </div>
                              </div>

                              <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">
                                  Iframe
                              </label>
                              <div class="col-lg-6">
                                <textarea class="form-control m-input" placeholder="Enter Iframe" name="iframe"  >{{ $result->iframe}}</textarea>
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
                                        <a href="{{ url('account/setting') }}" class="btn btn-danger"><span>Cancel</span></a>
                                    
                                    </div>
                                
                                </div>
                            </div>
                        </div>


                    </form>        
                
                           
                        </div>
                    </div>
                </div>
@endsection
