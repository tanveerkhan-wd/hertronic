/**
* Postal Code
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#postalCode_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getPostalCodes",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_postalCode').val();
              d.town = $('#town_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "pof_Uid" },
            { "data": "pof_PostOfficeName" },
            { "data": "pof_PostOfficeNumber" },
            { "data": "town", sortable:!1,
              render: function (data, type, town) {
                 return town.municipality.mun_MunicipalityName;
              }
            },
            { "data": "pof_Notes", sortable:!1, 
              render: function (data, type, town) {
                if(town.pof_Notes != null){
                  if(town.pof_Notes.length > 30){
                      return town.pof_Notes.substring(0, 45)+' . . .';
                  }else{
                      return town.pof_Notes;
                  }
                }else{
                  return town.pof_Notes;
                }
              }
            },
            { "data": "pof_PostOfficeName", sortable:!1,
              render: function (data, type, town) {
                    return'<a cid="'+town.pkPof+'" onclick="triggerEdit('+town.pkPof+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+town.pkPof+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_postalCode").on('keyup', function () {
    //if($(this).val() != ''){
        $('#postalCode_listing').DataTable().ajax.reload()
   // }
  });

  $("#town_filter").on('change', function () {
      $('#postalCode_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkPof").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-postal-code-form']").validate({
    errorClass: "error_msg",
     rules: {
        pof_PostOfficeName_en:{
          required:true,
          minlength:2,
          maxlength:50
        },
        pof_PostOfficeNumber:{
          required:true,
          number:true,
          minlength:4,
          maxlength:12
        },
        fkPofMun:{
          required:true,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkPof", $("#pkPof").val());
        $.ajax({
            url: base_url+'/admin/addPostalCode',
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
                  $('#postalCode_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deletePostalCode',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#postalCode_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getPostalCode',
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
          $("#pkPof").val(result.data.pkPof);
          $("#pof_PostOfficeName_en").val(result.data.pof_PostOfficeName_en);
          $("#pof_PostOfficeName_sp").val(result.data.pof_PostOfficeName_sp);
          $("#pof_PostOfficeName_de").val(result.data.pof_PostOfficeName_de);
          $("#pof_PostOfficeName_hr").val(result.data.pof_PostOfficeName_hr);
          $("#pof_PostOfficeNumber").val(result.data.pof_PostOfficeNumber);
          $("#fkPofMun").val(result.data.fkPofMun);
          $("#pof_Notes").val(result.data.pof_Notes);
          $( ".show_modal" ).click();
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

function triggerDelete(cid){
   $('#did').val(cid);   
   $( ".show_delete_modal" ).click();
}

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
