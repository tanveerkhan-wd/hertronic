/**
* Education Program
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#educationProgram_listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    } ).DataTable({
        "columnDefs": [{
          "targets": 4,
          "createdCell": function (td, cellData, rowData, row, col) {
            if ( cellData == 'Active' ) {
              $(td).addClass('active_status');
            }else{
              $(td).addClass('disable_status');
            }
          }
        }],
        "language": {
          "emptyTable": $('#msg_no_data_available_table').val(),
        },
        "lengthMenu": [10,20,30,50],
        "searching": false,
        "serverSide": true,
        "deferRender": true,
        "ajax": {
            "url": base_url+"/admin/getEducationPrograms",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_educationProgram').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "edp_Uid" },
            { "data": "edp_Name" },
            { "data": "edp_ParentId" , sortable:!1,
              render: function (data, type, educationProgram) {
                    if (educationProgram.parent==null) {
                      return 'Self';
                    }else{
                      return educationProgram.parent.edp_Name_en;
                    }
              }

            },
            { "data": "edp_Notes", sortable:!1, 
              render: function (data, type, educationProgram) {
                if(educationProgram.edp_Notes != null){
                  if(educationProgram.edp_Notes.length > 30){
                      return educationProgram.edp_Notes.substring(0, 45)+' . . .';
                  }else{
                      return educationProgram.edp_Notes;
                  }
                }else{
                  return educationProgram.edp_Notes;
                }
              }
            },
            { "data": "edp_Name", sortable:!1,
              render: function (data, type, educationProgram) {
                    return'<a class="ajax_request no_sidebar_active" data-slug="admin/editEducationProgram/'+educationProgram.pkEdp+'" cid="'+educationProgram.pkEdp+'"  href="'+base_url+'/admin/editEducationProgram/'+educationProgram.pkEdp+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+educationProgram.pkEdp+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_educationProgram").on('keyup', function () {
    //if($(this).val() != ''){
        $('#educationProgram_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkEdp").val('');
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-educationProgram-form']").validate({
    errorClass: "error_msg",
     rules: {
        edp_Name_en:{
          required:true,
          minlength:3
        },
        edp_ParentId:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkEdp", $("#pkEdp").val());
        if($('#aid').length){
          var url = '/admin/addEducationProgram';
          formData.append("pkEdp", $('#aid').val());
        }else{
          var url = '/admin/addEducationProgram';
        }
        $.ajax({
            url: base_url+url,
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  $('a[data-slug="admin/educationProgram"]').trigger("click");
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

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/admin/deleteEducationProgram',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#educationProgram_listing').DataTable().ajax.reload();
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

function triggerEdit(cid){
  showLoader(true);
  $.ajax({
    url: base_url+'/admin/getEducationProgram',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $.each(result.data, function(index, value) {
            $("#"+index).val(value);
          });
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

function triggerDelete(cid){
   $('#did').val(cid);   
   $( ".show_delete_modal" ).click();
}

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
