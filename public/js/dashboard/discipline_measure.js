  /**
* Discipline Measure Type
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#disciplineMeasureType_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getDisciplineMeasureTypes",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_disciplineMeasureType').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "smt_Uid" },
            { "data": "smt_DisciplineMeasureName" },
            { "data": "smt_Notes", sortable:!1, 
              render: function (data, type, disciplineMeasureType) {
                if(disciplineMeasureType.smt_Notes != null){
                  if(disciplineMeasureType.smt_Notes.length > 30){
                      return disciplineMeasureType.smt_Notes.substring(0, 45)+' . . .';
                  }else{
                      return disciplineMeasureType.smt_Notes;
                  }
                }else{
                  return disciplineMeasureType.smt_Notes;
                }
              }
            },
            { "data": "smt_DisciplineMeasureName", sortable:!1,
              render: function (data, type, disciplineMeasureType) {
                    return'<a cid="'+disciplineMeasureType.pkSmt+'" onclick="triggerEdit('+disciplineMeasureType.pkSmt+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+disciplineMeasureType.pkSmt+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_disciplineMeasureType").on('keyup', function () {
    //if($(this).val() != ''){
        $('#disciplineMeasureType_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkSmt").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-disciplineMeasureType-form']").validate({
    errorClass: "error_msg",
     rules: {
        smt_DisciplineMeasureName:{
          required:true,
          minlength:3
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkSmt", $("#pkSmt").val());
        $.ajax({
            url: base_url+'/admin/addDisciplineMeasureType',
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
                  $('#disciplineMeasureType_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteDisciplineMeasureType',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#disciplineMeasureType_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getDisciplineMeasureType',
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
