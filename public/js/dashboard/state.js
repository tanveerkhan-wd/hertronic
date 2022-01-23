/**
* State
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#states_listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    } ).DataTable({
        "columnDefs": [{
          "targets": 5,
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
            "url": base_url+"/admin/getStates",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_state').val();
              d.country = $('#country_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "sta_Uid" },
            { "data": "sta_StateName" },
            { "data": "country", sortable:!1,
              render: function (data, type, country) {
                 return country.country.cny_CountryName;
              }
            },
            { "data": "sta_Note", sortable:!1, 
              render: function (data, type, country) {
                if(country.sta_Note != null){
                  if(country.sta_Note.length > 30){
                      return country.sta_Note.substring(0, 45)+' . . .';
                  }else{
                      return country.sta_Note;
                  }
                }else{
                  return country.sta_Note;
                }
              }
            },
            { "data": "sta_Statu", className: "status",  sortable:!1,
              render: function (data, type, country) {
                 return'<span></span>'+country.sta_Status+'';
              }
            },
            { "data": "sta_StateName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkSta+'" onclick="triggerEdit('+country.pkSta+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkSta+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_state").on('keyup', function () {
    //if($(this).val() != ''){
        $('#states_listing').DataTable().ajax.reload()
   // }
  });

  $("#country_filter").on('change', function () {
      $('#states_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkSta").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-state-form']").validate({
    errorClass: "error_msg",
     rules: {
        sta_StateName:{
          required:true,
          minlength:3
        },
        fkStaCny:{
          required:true,
        },
        sta_Status:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkSta", $("#pkSta").val());
        $.ajax({
            url: base_url+'/admin/addState',
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
                  $('#states_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteState',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#states_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getState',
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
          $("#pkSta").val(result.data.pkSta);
          $("#sta_StateName_en").val(result.data.sta_StateName_en);
          $("#sta_StateName_sp").val(result.data.sta_StateName_sp);
          $("#sta_StateName_de").val(result.data.sta_StateName_de);
          $("#sta_StateName_hr").val(result.data.sta_StateName_hr);
          $("#sta_StateNameGenitive").val(result.data.sta_StateNameGenitive);
          $("#fkStaCny").val(result.data.fkStaCny);
          $("#sta_Note").val(result.data.sta_Note);
          $("#sta_Status").val(result.data.sta_Status);
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
