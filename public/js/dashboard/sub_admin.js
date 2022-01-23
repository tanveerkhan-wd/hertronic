/**
* Sub Admin
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


  if($('.datepicker').length){
    $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true});
  }

  $("form[name='add-ministry-form']").validate({
    errorClass: "error_msg",
     rules: {
        email:{
          required:true,
          email: true,
          emailfull: true
        },
        fname:{
          required:true,
          minlength:3
        },
        lname:{
          required:true,
          minlength:3
        },
        adm_Gender:{
          required:true,
        },
        fkAdmCan:{
          required:true,
        },
        adm_Status:{
          required:true,
        },
        adm_GovId:{
          required:true,
          minlength:5
        },
        adm_DOB:{
          required:true,
        },
     },
      // messages: {
      //   password: {
      //     required: "Please provide a password",
      //     minlength: "Password must be at least 6 characters long."
      //   },
      //   confirm_password:{
      //     equalTo:'New password and Confirm password does not match',
      //   },
      // },

      submitHandler: function(form, event) {
       event.preventDefault();
       showLoader(true);
      var formData = new FormData($(form)[0]);
      if($('#aid').length){
        var url = base_url+'/admin/editSubAdmin';
        formData.append("id", $('#aid').val());
      }else{
        var url = base_url+'/admin/addSubAdmin';
      }
      $.ajax({
          url: url,
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
              console.log('result',result);
              if(result.status){
                // window.location.href = result.redirect;
                toastr.success(result.message);
                setTimeout(function(){ 
                   window.location.href = result.redirect;
                }, 3000);
              }else{
                toastr.error(result.message);
              }
              
              showLoader(false);
          },
          error: function(data)
          {
              toastr.error('Something went wrong');
              showLoader(false);
          }
      });
    }
  });

  jQuery.validator.addMethod("emailfull", function(value, element) {
     return this.optional(element) || /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i.test(value);
    }, "Please enter valid email address!");

});

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


function selectProfileImage(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#user_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
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
            "url": base_url+"/admin/getSubAdmins",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_sub_admin').val();
              // d.state = $('#state_filter').val();
              // d.country = $('#country_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "adm_Uid" },
            { "data": "adm_Name",
              render: function (data, type, admin) {
                var name = admin.adm_Name.split(" ");
                return name[0];
              }
            },
            { "data": "adm_Name",
              render: function (data, type, admin) {
                var name = admin.adm_Name.split(" ");
                return name[1];
              }
            },
            { "data": "adm_GovId" },
            { "data": "email" },
            { "data": "adm_Statu", className: "status",  sortable:!1,
              render: function (data, type, admin) {
                return'<span></span>'+admin.adm_Status+'';
              }
            },
            { "data": "adm_Status", className: "status",  sortable:!1,
              render: function (data, type, admin) {
                return'<button class="btn btn-success" data_id="'+admin.id+'">'+$('#access_txt').val()+'</button>';
              }
            },
            { "data": "adm_Name", sortable:!1,
              render: function (data, type, admin) {
                return'<a class="ajax_request no_sidebar_active" data-slug="admin/viewSubAdmin/'+admin.id+'" href="viewSubAdmin/'+admin.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a class="ajax_request no_sidebar_active" data-slug="admin/editSubAdmin/'+admin.id+'" href="editSubAdmin/'+admin.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+admin.id+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
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
    url: base_url+'/admin/deleteSubAdmin',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#sub_admin_listing').DataTable().ajax.reload();
        }else{
          toastr.error('Something went wrong');
        }
        
        showLoader(false);
    },
    error: function(data)
    {
        toastr.error('Something went wrong');
        showLoader(false);
    }
  });
}
