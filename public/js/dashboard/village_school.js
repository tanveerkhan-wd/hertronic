/**
* Village School
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
if($('.is_HSA').length == 0){
  var list_url = base_url+"/employee/getVillageSchools";
}else{
  var list_url = base_url+"/admin/getVillageSchools";
}
  $('#village_school_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": list_url,
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_village_school').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "vsc_Uid" },
            { "data": "vsc_VillageSchoolName" },
            { "data": "vsc_Residence", sortable:!1,
              render: function (data, type, vs) {
                if(vs.school != null){
                  return vs.school['sch_SchoolName_'+$('#custom-flag-drop-down select').val()];
                }else{
                  return '';
                }
              }
            },
            { "data": "vsc_Residence", sortable:!1,
              render: function (data, type, vs) {
                if(vs.vsc_Address != null){
                  if(vs.vsc_Address.length > 30){
                      return vs.vsc_Address.substring(0, 45)+' . . .';
                  }else{
                      return vs.vsc_Address;
                  }
                }else{
                  return vs.vsc_Address;
                }
              }
            },
            { "data": "vsc_Notes", sortable:!1, 
              render: function (data, type, vs) {
                if(vs.vsc_Notes != null){
                  if(vs.vsc_Notes.length > 30){
                      return vs.vsc_Notes.substring(0, 45)+' . . .';
                  }else{
                      return vs.vsc_Notes;
                  }
                }else{
                  return vs.vsc_Notes;
                }
              }
            },
            { "data": "vsc_VillageSchoolName", sortable:!1,
              render: function (data, type, vs) {
                    return'<a cid="'+vs.pkVsc+'" onclick="triggerEdit('+vs.pkVsc+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+vs.pkVsc+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_village_school").on('keyup', function () {
    //if($(this).val() != ''){
        $('#village_school_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkVsc").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-village-school-form']").validate({
    errorClass: "error_msg",
     rules: {
        vsc_VillageSchoolName_en:{
          required:true,
          minlength:3,
          maxlength:40
        },
        vsc_Residence:{
          required:true,
          minlength:3,
          maxlength:40
        },
        vsc_PhoneNumber:{
          required:true,
        },
        vsc_Address:{
          required:true,
        },
        fkVscPof:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkVsc", $("#pkVsc").val());
        formData.append("fkVscSch", $("#fkVscSch").val());
        $.ajax({
            url: base_url+'/employee/addVillageSchool',
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
                  $('#village_school_listing').DataTable().ajax.reload();
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
    url: base_url+'/employee/deleteVillageSchool',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#village_school_listing').DataTable().ajax.reload();
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

function triggerEdit(cid){
  showLoader(true);
  $.ajax({
    url: base_url+'/employee/getVillageSchool',
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
