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
                            
                        <form method="post" id="service_form" action="{{ route('service.index') }}" enctype="multipart/form-data" > 
                            {{ csrf_field() }}
                            <div class="m-portlet__body">
                                <div class="m-form__section m-form__section--first">


                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                           Service Icon
                                        </label>
                                        <div class="col-lg-6">
                                              <input type="file" class="form-control" name="service_image" placeholder="" required>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                           Service Name
                                        </label>
                                        <div class="col-lg-6">
                                              <input type="text" class="form-control" name="service_name" placeholder="" value="{{ old('service_name') }}" required>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                           Service Description
                                        </label>
                                        <div class="col-lg-6">
                                            <textarea name="service_description" class="form-control" id="content" cols="30" rows="10"></textarea>
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
                                        <a href="{{ url('admin/service') }}" class="btn btn-danger"><span>Cancel</span></a>
                                    
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
    $("#service_form").validate();
    $("#content").summernote();
</script>
@endpush

