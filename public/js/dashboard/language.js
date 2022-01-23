/**
* Languages
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

$("#upload_flag").on('change', function () { 
  if( document.getElementById("upload_flag").files.length == 0 ){
      $('#flag_img').attr('src', $('#img_tmp').val());
  }
    selectFlagImage(this);
});

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#languages_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": "/admin/getLanguages",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_language').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "language_key" },
            { "data": "language_name" },
            { "data": "language_name", sortable:!1,
              render: function (data, type, language) {
                    return'<a cid="'+language.id+'" onclick="triggerEdit('+language.id+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+language.id+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_language").on('keyup', function () {
    //if($(this).val() != ''){
        $('#languages_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#id").val('');
    $('#flag_img').attr('src', $('#img_tmp').val());
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-language-form']").validate({
    errorClass: "error_msg",
     rules: {
        language_key:{
          required:true,
          minlength:2,
          maxlength:10
        },
        language_name:{
          required:true,
          minlength:3,
          maxlength:10
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("id", $("#id").val());
        $.ajax({
            url: '/admin/addLanguage',
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
                  $('#languages_listing').DataTable().ajax.reload();
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

function selectFlagImage(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#flag_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: '/admin/deleteLanguage',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#languages_listing').DataTable().ajax.reload();
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
    url: '/admin/getLanguage',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        //location.reload();
        console.log('result',result);
        if(result.status){
          $("#id").val(result.data.id);
          $("#language_key").val(result.data.language_key);
          $("#language_name").val(result.data.language_name);
          if(result.data.flag != null && result.data.flag != ''){
            $('#flag_img').attr('src',result.data.flag);
          }
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
