/**
* Optional Courses Group
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#optionalCoursesGroup_listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    } ).DataTable({
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
            "url": base_url+"/admin/getOptionalCoursesGroups",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_optionalCoursesGroup').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "ocg_Uid" },
            { "data": "ocg_Name" },
            { "data": "ocg_Notes", sortable:!1, 
              render: function (data, type, optionalCoursesGroup) {
                if(optionalCoursesGroup.ocg_Notes != null){
                  if(optionalCoursesGroup.ocg_Notes.length > 30){
                      return optionalCoursesGroup.ocg_Notes.substring(0, 45)+' . . .';
                  }else{
                      return optionalCoursesGroup.ocg_Notes;
                  }
                }else{
                  return optionalCoursesGroup.ocg_Notes;
                }
              }
            },
            { "data": "ocg_Name", sortable:!1,
              render: function (data, type, optionalCoursesGroup) {
                    return'<a cid="'+optionalCoursesGroup.pkOcg+'" onclick="triggerEdit('+optionalCoursesGroup.pkOcg+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+optionalCoursesGroup.pkOcg+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_optionalCoursesGroup").on('keyup', function () {
    //if($(this).val() != ''){
        $('#optionalCoursesGroup_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkOcg").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-optionalCoursesGroup-form']").validate({
    errorClass: "error_msg",
     rules: {
        ocg_Name:{
          required:true,
          minlength:3
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkOcg", $("#pkOcg").val());
        $.ajax({
            url: base_url+'/admin/addOptionalCoursesGroup',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                console.log('result',result);
                if(result.status){
                  toastr.success(result.message);
                  $('#add_new').modal('hide');
                  $('#optionalCoursesGroup_listing').DataTable().ajax.reload();
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



});

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/admin/deleteOptionalCoursesGroup',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#optionalCoursesGroup_listing').DataTable().ajax.reload();
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

function triggerEdit(cid){
  showLoader(true);
  $.ajax({
    url: base_url+'/admin/getOptionalCoursesGroup',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        //location.reload();
        console.log('result',result);
        if(result.status){
          $.each(result.data, function(index, value) {
            $("#"+index).val(value);
          }); 
          $( ".show_modal" ).click();
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

function triggerDelete(cid){
   $('#did').val(cid);   
   $( ".show_delete_modal" ).click();
}

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
