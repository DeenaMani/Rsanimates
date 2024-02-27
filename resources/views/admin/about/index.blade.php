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
                            
                         <form method="post" action="{{ route('about.index') }}/{{$result->id}}" enctype="multipart/form-data" >
                          @csrf  

                            @method('PATCH') 

                         <input type="hidden" name="id" value="{{ $result->id }}">

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">

                              <div class="form-group m-form__group row">
                                <label class="col-lg-12 col-form-label">
                                  About Content
                              </label>
                              <div class="col-lg-12">
                                <textarea class="form-control m-input" placeholder="Enter About Content" name="about_content"  id="content">{{ $result->about_content}} </textarea>
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

@push('scripts')
<script type="text/javascript">
    $("#content").summernote();
</script>
@endpush
