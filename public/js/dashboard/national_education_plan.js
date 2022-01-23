/**
* Edit Admin Education Plan
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#education_plan_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getNationalEducationPlans",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_education_plan').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "nep_Uid" },
            { "data": "nep_NationalEducationPlanName" },
            { "data": "nep_Notes", sortable:!1, 
              render: function (data, type, country) {
                if(country.nep_Notes != null){
                  if(country.nep_Notes.length > 30){
                      return country.nep_Notes.substring(0, 45)+' . . .';
                  }else{
                      return country.nep_Notes;
                  }
                }else{
                  return country.nep_Notes;
                }
              }
            },
            { "data": "nep_Statu", className: "status",  sortable:!1,
              render: function (data, type, country) {
                 return'<span></span>'+country.nep_Status+'';
              }
            },
            { "data": "nep_NationalEducationPlanName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkNep+'" onclick="triggerEdit('+country.pkNep+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkNep+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_education_plan").on('keyup', function () {
    //if($(this).val() != ''){
        $('#education_plan_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    var validator = $( "form" ).validate();
    validator.resetForm();
    $("form").trigger("reset");
    $("#pkNep").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-education-plan-form']").validate({
    errorClass: "error_msg",
     rules: {
        nep_NationalEducationPlanName_en:{
          required:true,
          minlength:3
        },
        nep_Status:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkNep", $("#pkNep").val());
        $.ajax({
            url: base_url+'/admin/addNationalEducationPlan',
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
                  $('#education_plan_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteNationalEducationPlan',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#education_plan_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getNationalEducationPlan',
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
