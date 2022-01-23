$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#religions_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getReligions",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_religion').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "rel_Uid" },
            { "data": "rel_ReligionName" },
            { "data": "rel_Notes", sortable:!1, 
              render: function (data, type, religion) {
                if(religion.rel_Notes != null){
                  if(religion.rel_Notes.length > 30){
                      return religion.rel_Notes.substring(0, 45)+' . . .';
                  }else{
                      return religion.rel_Notes;
                  }
                }else{
                  return religion.rel_Notes;
                }
              }
            },
            { "data": "rel_ReligionName", sortable:!1,
              render: function (data, type, religion) {
                    return'<a cid="'+religion.pkRel+'" onclick="triggerEdit('+religion.pkRel+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+religion.pkRel+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_religion").on('keyup', function () {
    //if($(this).val() != ''){
        $('#religions_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkRel").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-religion-form']").validate({
    errorClass: "error_msg",
     rules: {
        rel_ReligionName_en:{
          required:true,
          minlength:3,
          maxlength:50,
        },
        rel_ReligionNameAdjective:{
          maxlength:50,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkRel", $("#pkRel").val());
        $.ajax({
            url: base_url+'/admin/addReligion',
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
                  $('#religions_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteReligion',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#religions_listing').DataTable().ajax.reload();
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
  console.log(cid);
  $.ajax({
    url: base_url+'/admin/getReligion',
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
