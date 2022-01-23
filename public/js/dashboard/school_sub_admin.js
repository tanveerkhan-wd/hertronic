/**
* School Sub Admin
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

  $("#upload_profile").on('change', function () { 
    if( document.getElementById("upload_profile").files.length == 0 ){
        $('#user_img').attr('src', $('#img_tmp').val());
    }
      selectProfileImage(this);
  });

  $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true});

  $("#start_date").datepicker({
    format: "mm/dd/yyyy",
    autoclose: true, 
    // startDate: '+0d'
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

  $("#start_date").on('change', function () {
      $('#sub_admin_listing').DataTable().ajax.reload()
  });

  $("#end_date").on('change', function () {
      $('#sub_admin_listing').DataTable().ajax.reload()
  });

  $("form[name='add-subAdmin-form']").validate({
    errorClass: "error_msg",
     rules: {
        email:{
          required:true,
          email: true,
          emailfull: true
        },
        emp_EmployeeName:{
          required:true,
          minlength:3,
          maxlength:30
        },
        emp_PhoneNumber:{
          required:true,
          minlength:10,
          maxlength:13
        },
        emp_Gender:{
          required:true,
        },
        emp_EmployeeID:{
          required:true,
          minlength:5,
          maxlength:13,
        },
        emp_Status:{
          required:true,
        },
        start_date:{
          required:true,
        },
        emp_PlaceOfBirth:{
          required:true,
          minlength:5,
          maxlength:25
        },
        fkEmpCny:{
          required:true,
        },
        fkEenEpty:{
          required:true,
        },
        een_WeeklyHoursRate:{
          required:true,
        },
        fkEenEty:{
          required:true,
        },
     },

      submitHandler: function(form, event) {
       event.preventDefault();
       showLoader(true);
      var formData = new FormData($(form)[0]);
      if($('#aid').length){
        var url = base_url+'/employee/editSubAdmin';
        formData.append("id", $('#aid').val());
      }else{
        var url = base_url+'/employee/addSubAdmin';
      }
      formData.append("sid", $('#sid').val());
      $.ajax({
          url: url,
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
              if(result.status){
                toastr.success(result.message);
                $('a[data-slug="employee/subAdmins"]').trigger("click");
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

  jQuery.validator.addMethod("emailfull", function(value, element) {
     return this.optional(element) || /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i.test(value);
    }, $('#email_validate_txt').val());

});

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


function selectProfileImage(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var filename = input.files[0].name;
        var fileExtension = filename.substr((filename.lastIndexOf('.') + 1));
        var fileExtensionCase = fileExtension.toLowerCase();
        if (fileExtensionCase == 'png' || fileExtensionCase == 'jpeg' || fileExtensionCase == 'jpg' ) {
          reader.onload = function (e) {
              jQuery('#user_img').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);        
        }else{
          toastr.error($('#image_validation_msg').val());
          $('#upload_profile').val('');
          var user_img = base_url+"/public/images/user.png";
          console.log(user_img);
          $('#user_img').attr('src', user_img);
          
        }

    }
}

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#sub_admin_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/employee/getSubAdmins",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_sub_admin').val();
              d.start_date = $('#start_date').val();
              d.end_date = $('#end_date').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "emp_EmployeeID" },
            { "data": "emp_EmployeeName"},
            { "data": "email" },
            { "data": "start_date", sortable:!1},
            { "data": "end_date", sortable:!1},
            { "data": "emp_Status"},
            { "data": "emp_EmployeeName", sortable:!1,
              render: function (data, type, admin) {
                return'<a class="ajax_request no_sidebar_active" data-slug="employee/viewSubAdmin/'+admin.id+'" href="viewSubAdmin/'+admin.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a class="ajax_request no_sidebar_active" data-slug="employee/editSubAdmin/'+admin.id+'" href="editSubAdmin/'+admin.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+admin.id+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("#search_sub_admin").on('keyup', function () {
    //if($(this).val() != ''){
        $('#sub_admin_listing').DataTable().ajax.reload()
   // }
  });

function triggerDelete(cid){
   $('#did').val(cid);   
   $( ".show_delete_modal" ).click();
}

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/employee/deleteSubAdmin',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          toastr.success(result.message);
          $('#delete_prompt').modal('hide');
          $('#sub_admin_listing').DataTable().ajax.reload();
        }else{
          toastr.error($('#something_wrong_txt').val());
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
