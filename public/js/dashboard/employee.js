/**
* Employee
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
  if($('#is_admin').val() == 1){
    var list_url = base_url+"/admin/getEmployees";
    var editEmp = base_url+'/admin/editEmployee';
    var viewEmp = base_url+'/admin/viewEmployee';

  }else{
    var list_url = base_url+"/employee/getEmployees";
    var editEmp = base_url+'/employee/editEmployee';
    var addEmp = base_url+'/employee/addEmployee';
    var viewEmp = base_url+'/employee/viewEmployee';
  }
  $("#upload_profile").on('change', function () { 
    if( document.getElementById("upload_profile").files.length == 0 ){
        $('#user_img').attr('src', $('#img_tmp').val());
    }
      selectProfileImage(this);
  });

  $(".datepicker-year").datepicker({
    format: "yyyy",
    viewMode: "years", 
    autoclose: true,
    minViewMode: "years"
  });

  $(document).on('change', '.diploma_file', function(){
    var currData = $(this).attr('id');
    var ids = currData.split("_");
    var currId = ids[2];
    if($(this).val() != ''){
      var file = $(this)[0].files[0];
      $('#file_name_'+currId).val(file.name);
    }else{
      $('#file_name_'+currId).val('');
      $('#eed_DiplomaPicturePath_'+currId).prop('required',true);
    }
  });

  $('#Current-tab').on('show.bs.tab', function () {
    $(".datepicker-year").datepicker({
        format: "yyyy",
        viewMode: "years", 
        autoclose: true,
        endDate: '+0d',
        autoclose: true,
        minViewMode: "years"
    });
  })


  $('#add_qa').on('click', function () {

    var $ed = $('#profile_de_details .profile_info_container').clone();
    var ind = $('.profile_de_details_add .profile_info_container').length+1;
    $ed.find('.rm_ed').attr('data-eed',ind);
    $ed.find('select,input').each(function(key, value)
    {
      this.id = this.id+'_'+ind;
      this.name = this.name+'_'+ind;
    });  

    $('.profile_de_details_add .text-center:first').before($ed);
    $(".datepicker-year").datepicker({
        format: "yyyy",
        viewMode: "years", 
        autoclose: true,
        endDate: '+0d',
        autoclose: true,
        minViewMode: "years"
    });
  });

  $(document).on('click', '.rm_ed', function () {
    $(this).closest('.profile_info_container').remove();
    // var ind = $('#edit_profile_detail2 .profile_info_container').length
    var inc = 1;
    $('.profile_de_details_add .profile_info_container').each(function(i, obj) {
        $(this).find('select,input').each(function(key, value)
        {
          var old_id = this.id.split("_");
          old_id.splice(-1,1);
          old_id.push(inc);
          var new_id = old_id.join('_');

          this.id = new_id;
          this.name = new_id;
        });
        inc++;  
    });
  });

  var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#teacher_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": list_url,
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_teacher').val();
              d.emp_type = $('#employee_types').val();
              d.emp_eng_type = $('#employee_eng_types').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "emp_EmployeeID" },
            { "data": "emp_EmployeeName"},
            { "data": "email" },
            // { "data": "emp_EmployeeName",
            //   render: function (data, type, emp) {
            //     if(emp.employees_engagement[0].employee_type.epty_subCatName != null){
            //       if(emp.employees_engagement[0].employee_type.epty_subCatName == 'Teacher'){
            //         return $("#msa_txt").val();
            //       }else if(emp.employees_engagement[0].employee_type.epty_subCatName == 'SchoolCoordinator'){
            //         return $("#school_coordinator_txt").val();
            //       }else{
            //         return emp.employees_engagement[0].employee_type.epty_subCatName;
            //       } 
            //     }else{
            //       if(emp.employees_engagement[0].employee_type.epty_Name == 'Teacher'){
            //         return $("#teacher_txt").val();
            //       }else if(emp.employees_engagement[0].employee_type.epty_Name == 'SchoolCoordinator'){
            //         return $("#school_coordinator_txt").val();
            //       }else{
            //         return emp.employees_engagement[0].employee_type.epty_Name;
            //       } 
            //     }
            //   }
            // },
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
            /*{ "data": "engType"},*/
            // { "data": "emp_EmployeeName",
            //   render: function (data, type, emp) {
            //     return emp.employees_engagement[0].engagement_type.ety_EngagementTypeName;
            //   }
            // },
            { "data": "emp_Status"},
            { "data": "emp_EmployeeName", sortable:!1,
              render: function (data, type, emp) {
                if(window.location == base_url+'/employee/employees'){

                  var view = '<a class="ajax_request no_sidebar_active" data-slug="employee/viewEmployee/'+emp.id+'" href="'+base_url+'/employee/viewEmployee/'+emp.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t'
                  var edit = '<a class="ajax_request no_sidebar_active" data-slug="employee/editEmployee/'+emp.id+'" href="'+base_url+'/employee/editEmployee/'+emp.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>'

                  var view = '<a class="ajax_request no_sidebar_active" data-slug="employee/viewEmployee/'+emp.id+'" href="'+base_url+'/employee/viewEmployee/'+emp.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t'
                  var edit = '<a class="ajax_request no_sidebar_active" data-slug="employee/editEmployee/'+emp.id+'" href="'+base_url+'/employee/editEmployee/'+emp.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>'
                  
                }else{
                 var view = '<a class="ajax_request no_sidebar_active" data-slug="admin/viewEmployee/'+emp.id+'" href="'+base_url+'/admin/viewEmployee/'+emp.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t'
                  var edit = '<a class="ajax_request no_sidebar_active" data-slug="admin/editEmployee/'+emp.id+'" href="'+base_url+'/admin/editEmployee/'+emp.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>'
                  
                }
                return view+edit;
              }
            },
      ],

  });

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("#search_teacher").on('keyup', function () {
    //if($(this).val() != ''){
        $('#teacher_listing').DataTable().ajax.reload()
   // }
  });

  $("#employee_eng_types").on('change', function () {
        $('#teacher_listing').DataTable().ajax.reload();
  });

  $("#employee_types").on('change', function () {
        $('#teacher_listing').DataTable().ajax.reload();
  });

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

  $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true, endDate: '+0d',});

  $("form[name='add-teacher-form']").validate({
    errorClass: "error_msg",
     rules: {
        email:{
          required:true,
          email: true,
          emailfull: true
        },
        emp_EmployeeName:{
          required:true,
          minlength:5,
          maxlength:30
        },
        emp_EmployeeID:{
          required:true,
          minlength:5,
          maxlength:30
        },
        emp_TempCitizenId:{
          // required:true,
          minlength:5,
          maxlength:30
        },
        emp_PlaceOfBirth:{
          required:true,
          minlength:3,
          maxlength:30
        },
        emp_PhoneNumber:{
          required:true,
          minlength:10,
          maxlength:12
        },
        /*een_WeeklyHoursRate:{
          required:true,
          maxlength:10
        },
        fkEenEty:{
          required:true,
        },*/
        fkEmpCny:{
          required:true
        },
        fkEmpMun:{
          required:true
        },
        fkEmpNat:{
          required:true
        },
        fkEmpCtz:{
          required:true
        },
        fkEmpPof:{
          required:true
        },
        fkEedEde:{
          required:true
        },
        fkEmpRel:{
          required:true
        }/*,
        start_date:{
          required:true
        }*/
     },
      submitHandler: function(form, event) {
      event.preventDefault();

      
      if($('.profile_de_details_add .profile_info_container').length == 0){
        toastr.error($('#add_qualification_txt').val());
        return;
      }
      if ($('#start_date').val()=='' && $('#eid').length==0) {
        toastr.error($('#msg_add_engagemnet_field').val());
        return;
      }

      var formData = new FormData($(form)[0]);
      showLoader(true);
      if($('#eid').length){
        var url = editEmp;
        formData.append("id", $('#eid').val());
        formData.append("engid", $('#engid').val());
      }else{
        var url = addEmp;
      }
      formData.append("total_details", $('.profile_de_details_add .profile_info_container').length);
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

    $("form[name='engage-teacher-form']").validate({
    errorClass: "error_msg",
     rules: {
        email:{
          required:true,
          email: true,
          emailfull: true
        },
        emp_EmployeeName:{
          required:true,
          minlength:5,
          maxlength:30
        },
        emp_EmployeeID:{
          required:true,
          minlength:5,
          maxlength:30
        },
        een_WeeklyHoursRate:{
          required:true,
          maxlength:10
        },
        fkEenEty:{
          required:true,
        },
        start_date:{
          required:true
        }
     },
      submitHandler: function(form, event) {
      event.preventDefault();

      showLoader(true);
      var formData = new FormData($(form)[0]);
      if($('#eid').length){
        var url = base_url+'/employee/editEmployee';
        formData.append("id", $('#eid').val());
      }else{
        var url = base_url+'/employee/addEmployee';
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


  $("form[name='edit_eng_form']").validate({
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

      showLoader(true);
      var formData = new FormData($(form)[0]);
      var url = editEmp;
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
        
        $('#user_img').attr('src', user_img);
        
      }
  }
}


function fetchCollege(val){
  var currData = $(val).attr('id');
  var ids = currData.split("_");
  var currId = ids[1];

  $('#fkEedCol_'+currId).find('option').not(':first').remove();
  var cid = val.value;
  if(cid != ''){
    showLoader(true);
    $.ajax({
      url: base_url+'/employee/fetchCollege',
      type: 'POST',
      dataType:'json',
      cache: false,              
      data: {'cid':cid},
      success: function(result)
      {
        if(result.status){
          $.each(result.data, function(index, value) {
            $('#fkEedCol_'+currId).append($("<option></option>")
                    .attr("value",value.pkCol)
                    .text(value.col_CollegeName)); 
          });
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
}

 $('#add_eng').on('click', function () {

    $('#profile_eng_details').show();
    $('#profile_detail3').hide();
    $('.datepicker_future').datepicker({format: "mm/dd/yyyy",autoclose: true, startDate: '+0d',});
    $('#add_eng').hide();

});

 $('.rm_eng').on('click', function () {
    if ($(this).attr('data-eed')) {
      var data_eed = $(this).attr('data-eed');
      $('#profile_eng_details_'+data_eed).remove();  
      var eng_box = $('#profile_eng_details').find('.rm_eng');
      if (eng_box.length==0) {
        $('#profile_detail3').show();
        $('#profile_eng_details').hide();
        $('#add_eng').show(); 
      }
    }else{
      $('#profile_detail3').show();
      $('#profile_eng_details').hide();
      $('#add_eng').show();
    }
});

$('.engage_cancel').on('click', function () {
    $('#profile_detail3').show();
    $('#profile_eng_details').hide();
    $('#add_eng').show();
});
