@extends('layouts.admin')

@section('content')
<style type="text/css">
  .category_order { width: 100px; }
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
                        
                       
                            <table class="table table-bordered m-table m-table--border-primary" id="datatables">
                                <thead>
                                    <tr>
                                        <th>SNo</th>
                                        <th>Contact Name</th>
                                        <th>Contact email</th>
                                        <th>Contact Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                     @foreach($results as $key => $result)
                                     <tr>
                                         <td>{{$key + 1}}</td>
                                         <td>{{ $result->first_name }} {{ $result->last_name }}</td>
                                         <td>{{ $result->email }}</td>
                                         <td>{{ $result->mobile }}</td>
                                        <td> 
                                             <form method="post" action="{{ route('contact.index') }}/{{$result->id}}" enctype="multipart/form-data" >
                                                <a href="{{ URL::to('/')}}/admin/contact/view/{{$result->id}}" class="btn btn-success btn-sm" title="Edit"><i class="fa fa-eye"></i></a>
                                                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are Sure to Delete')"><i class="fa fa-trash"></i></button>
                                                  <input type="hidden" name="id" value="{{$result->id}}">
                                                  {{ method_field('DELETE') }}
                                                  {!! csrf_field() !!}
                                            </form>
                                     </tr>
                                     @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
@endsection
@push('scripts')
   
<script type="text/javascript">
  $(document).on("change",".update_status",function() {
      if($(this).is(":checked")) { var status = 1;}
      else{   var status = 0;  }  
      var id= $(this).attr("data-id")
      //alert(id);
      $.ajax({
          url: "{{URL('/')}}/admin/contact/status/" + id + "/" +status ,
              success: function(e) {
          }
      });
  });
</script>
 @endpush