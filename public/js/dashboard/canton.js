/**
* Admin Canton
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#cantons_listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    } ).DataTable({
        "columnDefs": [{
          "targets": 6,
          "createdCell": function (td, cellData, rowData, row, col) {
            console.log('cellData',cellData);
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
            "url": base_url+"/admin/getCantons",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_canton').val();
              d.state = $('#state_filter').val();
              d.country = $('#country_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "can_Uid" },
            { "data": "can_CantonName" },
            { "data": "state", sortable:!1,
              render: function (data, type, country) {
                 return country.state.sta_StateName_en;
              }
            },
            { "data": "state", sortable:!1,
              render: function (data, type, country) {
                 return country.state.country.cny_CountryName_en;
              }
            },
            { "data": "can_Note", sortable:!1, 
              render: function (data, type, country) {
                if(country.can_Note != null){
                  if(country.can_Note.length > 30){
                      return country.can_Note.substring(0, 45)+' . . .';
                  }else{
                      return country.can_Note;
                  }
                }else{
                  return country.can_Note;
                }
              }
            },
            { "data": "can_Statu", className: "status",  sortable:!1,
              render: function (data, type, country) {
                 return'<span></span>'+country.can_Status+'';
              }
            },
            { "data": "can_CantonName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkCan+'" onclick="triggerEdit('+country.pkCan+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkCan+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_canton").on('keyup', function () {
    //if($(this).val() != ''){
        $('#cantons_listing').DataTable().ajax.reload()
   // }
  });

  $("#country_filter").on('change', function () {
      $('#cantons_listing').DataTable().ajax.reload()
  });

  $("#state_filter").on('change', function () {
      $('#cantons_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkCan").val('');
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $("form[name='add-canton-form']").validate({
    errorClass: "error_msg",
     rules: {
        can_CantonName_en:{
          required:true,
          minlength:3
        },
        fkCanSta:{
          required:true,
        },
        selCountry:{
          required:true,
        },
        can_Status:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkCan", $("#pkCan").val());
        $.ajax({
            url: base_url+'/admin/addCanton',
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
                  //$("#country_filter").val('');
                  $('#cantons_listing').DataTable().ajax.reload();
                  //fetchState('',1);
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
    url: base_url+'/admin/deleteCanton',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#cantons_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getCanton',
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
          $("#pkCan").val(result.data.pkCan);
          $("#can_CantonName_en").val(result.data.can_CantonName_en);
          $("#can_CantonName_sp").val(result.data.can_CantonName_sp);
          $("#can_CantonName_de").val(result.data.can_CantonName_de);
          $("#can_CantonName_hr").val(result.data.can_CantonName_hr);
          $("#can_CantonNameGenitive").val(result.data.can_CantonNameGenitive);
          $("#selCountry").val(result.data.selCountry);
          fetchState(result.data.selCountry,2,result.data.fkCanSta);
          //$("#fkCanSta").val(result.data.fkCanSta);
          $("#can_Note").val(result.data.can_Note);
          $("#can_Status").val(result.data.can_Status);
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

function fetchState(cid,type,set=''){
  if(type == 1){
    var select = "state_filter";
  }else{
    var select = "fkCanSta";
  }
  $('#'+select).find('option').not(':first').remove();
  showLoader(true);
  $.ajax({
    url: base_url+'/admin/getStatesByCountry',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        console.log('result',result);
        if(result.status){
          $.each(result.data, function(key,value){
              $('#'+select).append($("<option></option>")
                    .attr("value",value.pkSta)
                    .text(value.sta_StateName_en)); 
          });
          if(set != ''){
            $("#fkCanSta").val(set);
          }
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
