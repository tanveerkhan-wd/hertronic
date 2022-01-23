@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_main_books'] ?? 'Main Books')
@section('script', url('public/js/dashboard/mainbook.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><span>{{$translations['sidebar_nav_school'] ?? 'School'}} ></span> <a class="ajax_request no_sidebar_active" data-slug="employee/mainBooks" href="{{url('/employee/mainBooks')}}"><span>{{$translations['sidebar_nav_main_books'] ?? 'Main Books'}} ></span></a>  {{$translations['sidebar_nav_students'] ?? 'Students'}}</h2>
            </div>   
            <div class="col-md-4 mb-3">
                <input type="text" id="search_student" class="form-control without_border icon_control search_control" placeholder="{{$translations['gn_search'] ?? 'Search'}}">
            </div>  
            <div class="col-md-4 text-md-right mb-3">
                <div class="row">
                    <div class="col-4 text-right pt-1 p-0">
                        <label class="blue_label">{{$translations['gn_joining_date'] ?? 'Joining Date'}}</label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="mdate_filter" class="form-control datepicker date_control icon_control">
                    </div>
                </div>
                <input type="hidden" id="fkSteMbo" value="{{$mid}}">
            </div> 
            <div class="col-md-2 col-6 mb-3">
                
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="student_listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>{{$translations['gn_student_name'] ?? 'Student Name'}}</th>
                                    <th>{{$translations['gn_father_name'] ?? 'Father Name'}}</th>
                                    <th>{{$translations['gn_mother_name'] ?? 'Mother Name'}}</th>
                                    <th>{{$translations['gn_joining_date'] ?? 'Joining Date'}}</th>
                                    <th>{{$translations['gn_grade'] ?? 'Grade'}}</th>
                                    <th>{{$translations['gn_dob'] ?? 'Date of Birth'}}</th>
                                    <th>{{$translations['gn_phone_number'] ?? 'Phone Number'}}</th>
                                    <th>{{$translations['gn_status'] ?? 'Status'}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>


</div>


<!-- End Content Body -->
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endsection

@push('datatable-scripts')
<!-- Include datatable Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/mainbook.js') }}"></script>
@endpush