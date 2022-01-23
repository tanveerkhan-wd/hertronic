<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ @csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - Hertronic</title>
  <!-- Tell the browser to be responsive to screen width -->
<!--   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
  <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/animate.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="{{ url('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
  <link href="{{ url('public/plugins/select2/select2.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('public/css/custom.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/custom-rt.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('public/css/msdropdown/dd.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ url('public/css/msdropdown/flags.css') }}" />

  <style type="text/css">
    .alert a{
    text-decoration: none;
   }
  </style>    
  @stack('custom-styles')
</head>
<body class="hold-transition sidebar-mini @if(Session::has('previous_login')) no_scroll @endif @if($logged_user->utype == 'employee') is_employee @endif">
  <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
  <input type="hidden" id="msg_no_data_available_table" value="{{$translations['msg_no_data_available_table'] ?? 'No data available in table'}}">
  
  <div class="inner-container" id="contents" style="opacity: 0;">
    @if (Session::has('middleware_error'))
        <input type="hidden" id="error_msg" value="{!! session('middleware_error') !!}">
    @endif
    @if(Session::has('previous_user'))
    <?php 
      $uimg = url('public/images/user.png');
      if($logged_user->utype == 'admin'){
        $type = $translations['gn_ministry_super_admin'] ?? 'Ministry Super Admin';
        if(!empty($logged_user->adm_Photo)){
          $uimg = url('public/images/users/').'/'.$logged_user->adm_Photo; 
        }
        $name = $logged_user->adm_Name;
      }else{
        if($logged_user->type == 'SchoolCoordinator'){
          $type = $translations['gn_school_coordinator'] ?? "School Coordinator";
        }elseif($logged_user->type == 'Teacher'){
          $type = $translations['gn_teacher'] ?? "Teacher";
        }elseif($logged_user->type == 'Principal'){
          $type = $translations['gn_principal'] ?? "Principal";
        }
        if(!empty($logged_user->emp_PicturePath)){
          $uimg = url('public/images/users/').'/'.$logged_user->emp_PicturePath; 
        }
        $name = $logged_user->emp_EmployeeName;
      }
    ?>
    <div class="sticky_login">
        <div class="profile-cover">
            <img id="logged_user_img" src="{{$uimg}}">
        </div>
        <p>{{$translations['gn_logged_in_as'] ?? "You are logged in as"}} {{$name}} - {{$type}}</p>
    </div>
    @endif
    <div class="wrapper @if(Session::has('previous_user')) loginAs @endif">

      <input type="hidden" id="web_base_url" value="{{url('/')}}">
      <!-- Left side column. contains the logo and sidebar -->
      {!!Session::get('previous_login')!!}
      @include('common.sidebar')
      <div id="content">
        <div id="preloader_new" style="opacity: 0; display: none;"><div id="status_new"><div class="spinner"></div></div></div>
        <div class="overlay" onclick="closeOverlay()"></div>
        @include('common.header')
        @yield('content') 
      </div>  
      
    </div>
  </div>
<!-- ./wrapper -->
<input type="hidden" id="previous_txt" value="{{$translations['gn_previous'] ?? 'Previous'}}">
<input type="hidden" id="next_txt" value="{{$translations['gn_next'] ?? 'Next'}}">
<input type="hidden" id="showing_txt" value="{{$translations['gn_showing'] ?? 'Showing'}}">
<input type="hidden" id="to_txt" value="{{$translations['gn_to'] ?? 'to'}}">
<input type="hidden" id="of_txt" value="{{$translations['gn_of'] ?? 'of'}}">
<input type="hidden" id="entries_txt" value="{{$translations['gn_entries'] ?? 'entries'}}">
<input type="hidden" id="show_txt" value="{{$translations['gn_show'] ?? 'Show'}}">
<input type="hidden" id="add_txt" value="{{$translations['gn_add'] ?? 'Add'}}">
<input type="hidden" id="access_txt" value="{{$translations['gn_access'] ?? 'Access'}}">
<input type="hidden" id="delete_txt" value="{{$translations['gn_delete'] ?? 'Delete'}}">
<input type="hidden" id="select_txt" value="{{$translations['gn_select'] ?? 'Select'}}">
<input type="hidden" id="active_txt" value="{{$translations['gn_active'] ?? 'Active'}}">
<input type="hidden" id="inactive_txt" value="{{$translations['gn_inactive'] ?? 'Inactive'}}">
<input type="hidden" id="something_wrong_txt" value="{{$translations['msg_something_wrong'] ?? 'Something Wrong Please try again Later'}}">
<input type="hidden" id="field_required_txt" value="{{$translations['validate_field_required'] ?? 'This field is required'}}">
<input type="hidden" id="email_validate_txt" value="{{$translations['validate_email_field'] ?? 'Please enter a valid email address'}}">
<input type="hidden" id="minlength_validate_txt" value="{{$translations['validate_minlength'] ?? 'Please enter at least {0} characters.'}}">
<input type="hidden" id="maxlength_validate_txt" value="{{$translations['validate_maxlength'] ?? 'Please enter no more than {0} characters.'}}">
<input type="hidden" id="max_validate_txt" value="{{$translations['validate_max'] ?? 'Please enter no more than {0} characters.'}}">
<input type="hidden" id="min_validate_txt" value="{{$translations['validate_min'] ?? 'Please enter a value greater than or equal to {0}.'}}">
<input type="hidden" id="validate_password_txt" value="{{$translations['validate_password'] ?? 'The password must be a combination of characters, numbers, one uppercase letter and special characters'}}">
<input type="hidden" id="validate_password_equalto_txt" value="{{$translations['validate_password_equalto'] ?? 'New password and Confirm password does not match'}}">
<input type="hidden" id="validate_equalto_txt" value="{{$translations['validate_equalto'] ?? 'Please enter the same value again'}}">
<input type="hidden" id="no_result_text" value="{{$translations['msg_no_result_found'] ?? 'No result found'}}">

<!-- jQuery 3 -->
<!-- <script type="text/javascript" src="{{ url('public/js/jquery-3.4.1.min.js') }}"></script> -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ url('public/js/all.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/owl.carousel.js') }}"></script>  
<script type="text/javascript" src="{{ url('public/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/custom.js') }}"></script>  
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ url('public/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ url('public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<!-- <script src="http://www.marghoobsuleman.com/misc/jquery.js"></script> -->
<script src="{{ url('public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ url('public/bower_components/chart.js/Chart.js') }}"></script>

<script src="{{ url('public/js/jquery.validate.js') }}"></script>
<script src="{{ url('public/js/custom_validation_msg.js') }}"></script>
<script src="{{ url('public/js/sweetalert2.min.js') }}"></script>
<script src="{{ url('public/js/promise.min.js') }}"></script>
<script src="{{ url('public/js/additional-methods.js') }}"></script>
<script type="text/javascript" src="{{ url('public/') }}/plugins/select2/select2.full.min.js"></script>
<!-- <script
  src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"
  integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw="
  crossorigin="anonymous"></script> -->
<script type="text/javascript" src="{{ url('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>


<script type="text/javascript">
  //show middleware authentication error
    if ($('#error_msg').val()) {
        toastr.error($('#error_msg').val());
    }
  //end
  
  var base_url = '{{ url('/') }}';
  $(document).ready(function () {
    $('.checkActive').find('.active').closest('.treeview').addClass('active');
    setTimeout(function(){
      $('.alert.alert-success').fadeOut( "slow", function() {});
      $('.alert.alert-danger').fadeOut( "slow", function() {});
    },2500)

  });
  $('.select2').select2({
    "language": {
       "noResults": function(){
           return $('#no_result_text').val();
       }
   },
  });
  // $('meta[name="viewport"]').prop('content', 'width=1440');
  // $.fn.digits = function(){ 
  //   return this.each(function(){ 
  //       $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
  //     })
  // }
  // setTimeout(function(){
  //   $('td.amountVal').digits();  
  // },1000);
  
  // function digitAdd(){
  //   setTimeout(function(){
  //     $('td.amountVal').digits();  
  //   },1000);
  // }

  function ReplaceNumberWithCommas(yourNumber) {
    //Seperates the components of the number
    var n= yourNumber.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return n.join(".");
}

$(document).on('click','.deleteNotification',function(){

    var notification_id = $(this).attr('data-notification-id'),
        user_id = '{{ $logged_user->id }}';

        if((parseFloat($('.noti_counter').html())-1) > 0)
        {
            $('.noti_counter').html((parseFloat($('.noti_counter').html())-1))
        }        
        //parseFloat($('.noti_counter').html())-1);
        $(this).parent().fadeOut();
        
    $('.loader-outer-container').css('display','table');
        var form_data = new FormData();      
        form_data.append('notification_id',notification_id);         
        form_data.append('user_id',user_id);
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: "POST",
            url: base_url+'/deleteNotification',
            datatype: JSON,
            processData: false,
            contentType: false,
            cache: false,
            data: form_data, // a JSON object to send back                
            success: function (data) {
                $('.loader-outer-container').css('display','none');
                if(data.code == 201){
                    //toastr.error(data.message);
                    //swal(data.message);
                    return false;
                }else{              
                    //toastr.success(data.message);
                    /*setTimeout(function(){
                        location.reload(true);
                    },1500)*/
                }
                
            }
        });     
});
</script>
<div id="dataTable_script">@stack('datatable-scripts')</div>
@stack('custom-scripts')
</body>
</html>
