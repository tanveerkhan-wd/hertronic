/**
* Municipality
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#municipalities_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getMunicipalities",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_municipality').val();
              d.canton = $('#canton_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "mun_Uid" },
            { "data": "mun_MunicipalityName" },
            { "data": "can_CantonName", sortable:!1,
              render: function (data, type, country) {
                 return country.canton.can_CantonName;
              }
            },
            { "data": "mun_Notes", sortable:!1, 
              render: function (data, type, country) {
                if(country.mun_Notes != null){
                  if(country.mun_Notes.length > 30){
                      return country.mun_Notes.substring(0, 45)+' . . .';
                  }else{
                      return country.mun_Notes;
                  }
                }else{
                  return country.mun_Notes;
                }
              }
            },
            { "data": "mun_MunicipalityName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkMun+'" onclick="triggerEdit('+country.pkMun+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkMun+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_municipality").on('keyup', function () {
    //if($(this).val() != ''){
        $('#municipalities_listing').DataTable().ajax.reload()
   // }
  });

  $("#canton_filter").on('change', function () {
      $('#municipalities_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkMun").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-municipality-form']").validate({
    errorClass: "error_msg",
     rules: {
        mun_MunicipalityName_en:{
          required:true,
          minlength:2,
          maxlength:20
        },
        mun_MunicipalityNameGenitive:{
          maxlength:20
        },
        fkMunCan:{
          required:true,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkMun", $("#pkMun").val());
        $.ajax({
            url: base_url+'/admin/addMunicipality',
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
                  $('#municipalities_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteMunicipality',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          $('#municipalities_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getMunicipality',
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
          $("#pkMun").val(result.data.pkMun);
          $("#mun_MunicipalityName_en").val(result.data.mun_MunicipalityName_en);
          $("#mun_MunicipalityName_sp").val(result.data.mun_MunicipalityName_sp);
          $("#mun_MunicipalityName_de").val(result.data.mun_MunicipalityName_de);
          $("#mun_MunicipalityName_hr").val(result.data.mun_MunicipalityName_hr);
          $("#mun_MunicipalityNameGenitive").val(result.data.mun_MunicipalityNameGenitive);
          $("#fkMunCan").val(result.data.fkMunCan);
          $("#mun_Notes").val(result.data.mun_Notes);
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
