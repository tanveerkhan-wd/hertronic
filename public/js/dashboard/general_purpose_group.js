/**
* General Purpose Group
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
//Validate form for Country
$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#generalPurposeGroup_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getGeneralPurposeGroups",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_generalPurposeGroup').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "gpg_Uid" },
            { "data": "gpg_Name" },
            { "data": "gpg_Notes", sortable:!1, 
              render: function (data, type, generalPurposeGroup) {
                if(generalPurposeGroup.gpg_Notes != null){
                  if(generalPurposeGroup.gpg_Notes.length > 30){
                      return generalPurposeGroup.gpg_Notes.substring(0, 45)+' . . .';
                  }else{
                      return generalPurposeGroup.gpg_Notes;
                  }
                }else{
                  return generalPurposeGroup.gpg_Notes;
                }
              }
            },
            { "data": "gpg_Name", sortable:!1,
              render: function (data, type, generalPurposeGroup) {
                    return'<a cid="'+generalPurposeGroup.pkGpg+'" onclick="triggerEdit('+generalPurposeGroup.pkGpg+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+generalPurposeGroup.pkGpg+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_generalPurposeGroup").on('keyup', function () {
    //if($(this).val() != ''){
        $('#generalPurposeGroup_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkGpg").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-generalPurposeGroup-form']").validate({
    errorClass: "error_msg",
     rules: {
        gpg_Name:{
          required:true,
          minlength:3
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkGpg", $("#pkGpg").val());
        $.ajax({
            url: base_url+'/admin/addGeneralPurposeGroup',
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
                  $('#generalPurposeGroup_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteGeneralPurposeGroup',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#generalPurposeGroup_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getGeneralPurposeGroup',
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
