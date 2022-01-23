/**
* Engage Employee
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
//var base_url = window.location.origin;
$(function() {

  showLoader(false);

  $("#eng_emp_listing").on('DOMNodeInserted DOMNodeRemoved', function() {
  if ($(this).find('tbody tr td').first().attr('colspan')) {
    $(this).parent().hide();
  } else {
    $(this).parent().show();
  }
});


  var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#eng_emp_listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    } ).DataTable({
        "columnDefs": [{
          "targets": 6,
          "createdCell": function (td, cellData, rowData, row, col) {
            if ( cellData == 'Active' ) {
              $(td).addClass('active_status');
            }else{
              $(td).addClass('disable_status');
            }
          }
        }],
        "language": {
          "sLengthMenu": $('#show_txt').val()+" _MENU_ "+$('#entries_txt').val(),
          "info": $('#showing_txt').val()+" _START_ "+$('#to_txt').val()+" _END_ "+$('#of_txt').val()+" _TOTAL_ "+$('#entries_txt').val(),
          "emptyTable": $('#msg_no_data_available_table').val(),
          "paginate": {
            "previous": $('#previous_txt').val(),
            "next": $('#next_txt').val()
          }
        },
        "lengthMenu": [10,20,30,50],
        "searching": false,
        "serverSide": true,
        "deferRender": true,
        "ajax": {
            "url": base_url+"/employee/getEngageEmployees",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_employee').val();
              d.type = 'Engage';
              d.emp_type = $('#employee_types').val();
              d.emp_eng_type = $('#employee_eng_types').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "emp_EmployeeID" },
            { "data": "emp_EmployeeName"},
            { "data": "email" },
            { "data": "emp_EmployeeName",
              render: function (data, type, emp) {
                if(emp.type == 'Teacher'){
                  return $("#teacher_txt").val();
                }else if(emp.type == 'SchoolCoordinator'){
                  return $("#school_coordinator_txt").val();
                }else if(emp.type == 'Principal'){
                  return $("#principal_txt").val();
                }else if(emp.type == 'Teacher,Principal' || emp.type == 'Principal,Teacher'){
                  return $("#principal_txt").val()+', '+$("#teacher_txt").val();
                }else if(emp.type==''){
                  return $("#emp_not_engaged").val();
                }else{
                  return emp.type
                } 
              }
            },
            { "data": "emp_Status"},
            { "data": "emp_EmployeeName", sortable:!1,
              render: function (data, type, emp) {
                return'<a class="ajax_request no_sidebar_active" data-slug="employee/viewEmployee/'+emp.id+'" href="'+base_url+'/employee/viewEmployee/'+emp.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a href="javascript:void(0)" onclick="selEmp(this)" emp-uid="'+emp.emp_EmployeeID+'" emp-name="'+emp.emp_EmployeeName+'" emp-id="'+emp.id+'"><img src="'+imagepath+'/ic_plus.png"></a>'
              }
            },
      ],

  });

  if($("#employee_eng_types,#employee_types,#search_employee").val()!=''){
    $('.main_table').show();
  }else{
    $('.main_table').hide();
  }

  $("#employee_eng_types").on('change', function () {
        $('#eng_emp_listing').DataTable().ajax.reload();
        if($(this).val() != ''){
          $('.main_table').show();
        }else{
         $('.main_table').hide();
        }
  });

  $("#employee_types").on('change', function () {
        $('#eng_emp_listing').DataTable().ajax.reload();
        if($(this).val() != ''){
          $('.main_table').show();
        }else{
          $('.main_table').hide();
        }
  });


  $("#search_employee").on('keyup', function () {
    if($(this).val() != ''){
        $('.main_table').show();
    }else{
        $('.main_table').hide();
    }
        $('#eng_emp_listing').DataTable().ajax.reload()
  });

  $("#start_date").datepicker({
    format: "mm/dd/yyyy",
    autoclose: true, 
    startDate: '+0d'
  }).on('changeDate', function(){
      $('#end_date').datepicker('setStartDate', new Date($(this).val()));
  });

  $('#end_date').datepicker({
    format: "mm/dd/yyyy",
    autoclose: true,
    startDate: $("#start_date").val(),
  }).on('changeDate', function(){
    if($("#start_date").val() != ''){
      $('#start_date').datepicker('setEndDate', new Date($(this).val()));
    }
  });

  $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true, endDate: '+0d',});

  $("form[name='engage-emp-form']").validate({
    errorClass: "error_msg",
     rules: {
        een_WeeklyHoursRate:{
          required:true,
          maxlength:10
        },
        fkEenEty:{
          required:true,
        },
        fkEenEpty:{
          required:true,
        },
        start_date:{
          required:true
        }
     },
      submitHandler: function(form, event) {
      event.preventDefault();

      if($('.sel_emp_table .ocg').length == 0){
        toastr.error($('#emp_sel_txt').val());
        return;
      }

      showLoader(true);

      var formData = new FormData($(form)[0]);

      $.ajax({
          url: base_url+'/employee/engageEmployee',
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
            if(result.status){
              toastr.success(result.message);
              $('li a[data-slug="employee/employees"]').trigger("click");
            }else{
              toastr.error(result.message);
            }
            
            showLoader(false);
          },
          error: function(data)
          {
              toastr.error($('#something_wrong_txt').val());
              showLoader(false);
          }
      });
    }
  });


});



$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

function selEmp(elem){

  if($('.sel_emp_table .ocg').length != 0){
    toastr.error($('#emp_sel_valid_txt').val());
    return;
  }

  $('.sel_emp_table tr').after('<tr class="ocg ocg_'+$(elem).attr('emp-id')+'"><td>1</td><td>'+$(elem).attr('emp-uid')+'</td><td>'+$(elem).attr('emp-name')+'</td><td><a data-id="'+$(elem).attr('emp-id')+'" onclick="removeSelEmp(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">'+$('#delete_txt').val()+'</a></td></tr>');
   
  $("#eid").val($(elem).attr('emp-id'));
  $(".sel_emp_div").show();
}

function removeSelEmp(elem){
  $('.ocg').remove();
  $("#eid").val('');
  $(".sel_emp_div").hide();
}
