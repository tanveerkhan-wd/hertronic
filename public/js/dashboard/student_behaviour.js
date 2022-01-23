/**
* Behaviour Type
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {


var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#studentBehaviour_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getStudentBehaviours",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_studentBehaviour').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "sbe_Uid" },
            { "data": "sbe_BehaviourName" },
            { "data": "sbe_Notes", sortable:!1, 
              render: function (data, type, studentBehaviour) {
                if(studentBehaviour.sbe_Notes != null){
                  if(studentBehaviour.sbe_Notes.length > 30){
                      return studentBehaviour.sbe_Notes.substring(0, 45)+' . . .';
                  }else{
                      return studentBehaviour.sbe_Notes;
                  }
                }else{
                  return studentBehaviour.sbe_Notes;
                }
              }
            },
            { "data": "sbe_BehaviourName", sortable:!1,
              render: function (data, type, studentBehaviour) {
                    return'<a cid="'+studentBehaviour.pkSbe+'" onclick="triggerEdit('+studentBehaviour.pkSbe+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+studentBehaviour.pkSbe+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_studentBehaviour").on('keyup', function () {
    //if($(this).val() != ''){
        $('#studentBehaviour_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkSbe").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-studentBehaviour-form']").validate({
    errorClass: "error_msg",
     rules: {
        sbe_BehaviourName:{
          required:true,
          minlength:3
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkSbe", $("#pkSbe").val());
        $.ajax({
            url: base_url+'/admin/addStudentBehaviour',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  $('#add_new').modal('hide');
                  $('#studentBehaviour_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteStudentBehaviour',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#studentBehaviour_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getStudentBehaviour',
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
          $( ".show_modal" ).click();
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
