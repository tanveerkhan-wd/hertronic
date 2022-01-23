$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#nationalities_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getNationalities",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_nationality').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "nat_Uid" },
            { "data": "nat_NationalityName" },
            { "data": "nat_NationalityNameMale" },
            { "data": "nat_NationalityNameFemale" },
            { "data": "nat_Notes", sortable:!1, 
              render: function (data, type, nationality) {
                if(nationality.nat_Notes != null){
                  if(nationality.nat_Notes.length > 30){
                      return nationality.nat_Notes.substring(0, 45)+' . . .';
                  }else{
                      return nationality.nat_Notes;
                  }
                }else{
                  return nationality.nat_Notes;
                }
              }
            },
            { "data": "nat_NationalityName", sortable:!1,
              render: function (data, type, nationality) {
                    return'<a cid="'+nationality.pkNat+'" onclick="triggerEdit('+nationality.pkNat+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+nationality.pkNat+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_nationality").on('keyup', function () {
    //if($(this).val() != ''){
        $('#nationalities_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkNat").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-nationality-form']").validate({
    errorClass: "error_msg",
     rules: {
        nat_NationalityName:{
          required:true,
          minlength:3,
          maxlength:50,
        },
        nat_NationalityNameMale:{
          required:true,
          maxlength:50,
        },
        nat_NationalityNameFemale:{
          required:true,
          maxlength:50,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkNat", $("#pkNat").val());
        $.ajax({
            url: base_url+'/admin/addNationality',
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
                  $('#nationalities_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteNationality',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#nationalities_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getNationality',
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
