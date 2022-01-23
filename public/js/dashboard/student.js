/**
* Students
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
  if($('#is_HSA').length != 0){
    $type = 'admin';
      var list_url = base_url+"/admin/getStudent";
      var editStu = base_url+'/admin/editStudent';
      var viewStu = base_url+'/admin/viewStudent';
  }else{
    $type = 'employee';
      var list_url = base_url+"/employee/getStudent";
      var editStu = base_url+'/employee/editStudent';
      var viewStu = base_url+'/employee/viewStudent';
  }
$(function() {

// $("#exampleCheck1").change(function() {
  //     if(this.checked) {
  //         $("#stu_StudentID").attr('disabled','disabled');
  //         $('.opt_tmp_id').show();
  //     }else{
  //         $('.opt_tmp_id').hide();
  //         $("#stu_StudentID").removeAttr('disabled');
  //     }
  // });

  $("#upload_profile").on('change', function () { 
    if( document.getElementById("upload_profile").files.length == 0 ){
        $('#user_img').attr('src', $('#img_tmp').val());
    }
      selectProfileImage(this);
  });
  

  if($('.datepicker').length){
    $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true,endDate: '+0d'});
  }

  $("form[name='add-student-form']").validate({
    errorClass: "error_msg",
     rules: {
        stu_StudentName:{
          required:true,
          minlength:3
        },
        stu_StudentSurname:{
          required:true,
          minlength:1
        },
        email:{
          required:true,
          email: true,
          // emailfull: true
        },
        stu_DateOfBirth:{
          required:true
        },
        stu_StudentGender:{
          required:true
        },
        stu_StudentID:{
          required:true
        },
        stu_TempCitizenId:{
          required:true
        },
        stu_ParentsEmail:{
          required:true,
          email: true,
        },
        stu_ParantsPhone:{
          required:true,
          minlength:3,
          maxlength:13
        },
        stu_PlaceOfBirth:{
          required:true,
          minlength:3
        },
        fkStuMun:{
          required:true
        },
        fkStuNat:{
          required:true
        },
        fkStuCtz:{
          required:true
        },
        fkStuRel:{
          required:true
        },
        stu_Address:{
          required:true
        },
        stu_PhoneNumber:{
          required:true,
          minlength:9
        },
        fkStuPof:{
          required:true
        }, 
     },
      submitHandler: function(form, event) {
       event.preventDefault();
       showLoader(true);
      var formData = new FormData($(form)[0]);
      if($('#aid').length){
        var url = editStu;
        formData.append("id", $('#aid').val());
      }else{
        var url = base_url+'/employee/addStudent';
      }
      console.log(formData);
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
                $('a[data-slug="employee/students"]').trigger("click");
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


var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#student_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
              d.search = $('#search_student').val();
              // d.state = $('#state_filter').val();
              // d.country = $('#country_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "stu_StudentID",
              render: function (data, type, row) {
                if(row.stu_StudentID == '' || row.stu_StudentID == null){
                  return row.stu_TempCitizenId;
                }else{
                  return row.stu_StudentID;
                }
              }
            },
            { "data": "stu_StudentName",
              render: function (data, type, row) {
                var name = row.stu_StudentName+' '+row.stu_StudentSurname
                return name;
              }
            },
            { "data": "stu_PlaceOfBirth",
              render: function (data, type, row) {
                var name = row.stu_PlaceOfBirth;
                return name;
              }
            },
            { "data": "stu_StudentGender" },
            { "data": "stu_Address" },
            { "data": "stu_StudentName", sortable:!1,
              render: function (data, type, row) {
                var delet = '';
                if(window.location == base_url+'/employee/students'){
                  var view = '<a class="ajax_request no_sidebar_active" data-slug="employee/viewStudent/'+row.id+'" href="viewStudent/'+row.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t'
                  var edit = '<a class="ajax_request no_sidebar_active" data-slug="employee/editStudent/'+row.id+'" href="editStudent/'+row.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t'
                  var delet = '<a onclick="triggerDelete('+row.id+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
                }else{
                  var view = '<a class="ajax_request no_sidebar_active" data-slug="admin/viewStudent/'+row.id+'" href="viewStudent/'+row.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t'
                  var edit = '<a class="ajax_request no_sidebar_active" data-slug="admin/editStudent/'+row.id+'" href="editStudent/'+row.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t'
                  
                }
                return view+edit+delet;
              }
            },
      ],

  });

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("#search_student").on('keyup', function () {
    //if($(this).val() != ''){
        $('#student_listing').DataTable().ajax.reload()
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
    url: base_url+'/employee/deleteStudent',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#student_listing').DataTable().ajax.reload();
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

$('#havent_identification_number'). click(function(){
  if($(this). prop("checked") == true){
    $('#stu_TempCitizenId').show();
    $('input[name=stu_StudentID]').val('');
    $('input[name=stu_StudentID]').prop('disabled', true);
    $('input[name=stu_TempCitizenId]').prop('disabled', false);
    $('.opt_tmp_id').removeClass('hide_content');
  }
  else if($(this). prop("checked") == false){
    $('#stu_StudentID').show();
    $('input[name=stu_TempCitizenId]').val('');
    $('input[name=stu_TempCitizenId]').prop('disabled', true);
    $('input[name=stu_StudentID]').prop('disabled', false);
    $('.opt_tmp_id').addClass('hide_content');
  }
});