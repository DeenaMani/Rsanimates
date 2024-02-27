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
                            
                        <form method="post" id="servicelist_form" action="{{ route('servicelist.index') }}/{{$result->id}}" enctype="multipart/form-data" >
                            @csrf  
                            @method('PUT')
                        <input type="hidden" name="id" value="{{ $result->id }}">

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">
                                 
                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                           Service Name
                                        </label>
                                        <div class="col-lg-6">
                                              <select name="service_id" class="form-control" required=>
                                                  <option value="">Select Service</option>
                                                  @if(count($service))
                                                    @foreach($service as $results)
                                                     <option value="{{$results->id}}" {{$results->id == $result->service_id ? 'selected':''}}>{{$results->service_name}}</option>
                                                    @endforeach
                                                  @endif  
                                              </select>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                        Service list Icon
                                        </label>
                                        <div class="col-lg-6">
                                              <input type="file" class="form-control" name="service_list_image" placeholder="" >
                                              <img src="{{URL::to('/')}}/public/images/servicelist/{{ $result->service_list_image}}" width="50">
                                        </div>
                                        
                                    </div>


                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                        Service list Name
                                        </label>
                                        <div class="col-lg-6">
                                              <input type="text" class="form-control" name="service_list_name" placeholder="" value="{{ old('service_list_name',$result->service_list_name) }}" required>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                           Service list Description
                                        </label>
                                        <div class="col-lg-6">
                                            <textarea name="service_list_description" class="form-control" id="content" cols="30" rows="10">{{$result->service_list_description}}</textarea>
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
                                        <a href="{{ url('admin/servicelist') }}" class="btn btn-danger"><span>Cancel</span></a>
                                    
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
     $("#servicelist_form").validate();
     $("#content1").summernote();
</script>
@endpush