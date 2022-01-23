/**
* Country
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#countries_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getCountries",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_country').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "cny_Uid" },
            { "data": "cny_CountryName" },
            { "data": "cny_Note", sortable:!1, 
              render: function (data, type, country) {
                if(country.cny_Note != null){
                  if(country.cny_Note.length > 30){
                      return country.cny_Note.substring(0, 45)+' . . .';
                  }else{
                      return country.cny_Note;
                  }
                }else{
                  return country.cny_Note;
                }
              }
            },
            { "data": "cny_Statu", className: "status",  sortable:!1,
              render: function (data, type, country) {
                 return'<span></span>'+country.cny_Status+'';
              }
            },
            { "data": "cny_CountryName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkCny+'" onclick="triggerEdit('+country.pkCny+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkCny+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_country").on('keyup', function () {
    //if($(this).val() != ''){
        $('#countries_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkCny").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-country-form']").validate({
    errorClass: "error_msg",
     rules: {
        cny_CountryName_en:{
          required:true,
          minlength:3
        },
        cny_Status:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkCny", $("#pkCny").val());
        $.ajax({
            url: base_url+'/admin/addCountry',
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
                  $('#countries_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteCountry',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          $('#countries_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getCountry',
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