/**
* Job & Work
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#job_work_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getJobAndWorks",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_job_work').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "jaw_Uid" },
            { "data": "jaw_Name" },
            { "data": "jaw_Notes", sortable:!1, 
              render: function (data, type, country) {
                if(country.jaw_Notes != null){
                  if(country.jaw_Notes.length > 30){
                      return country.jaw_Notes.substring(0, 45)+' . . .';
                  }else{
                      return country.jaw_Notes;
                  }
                }else{
                  return country.jaw_Notes;
                }
              }
            },
            { "data": "jaw_Statu", className: "status",  sortable:!1,
              render: function (data, type, country) {
                 return'<span></span>'+country.jaw_Status+'';
              }
            },
            { "data": "jaw_Name", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkJaw+'" onclick="triggerEdit('+country.pkJaw+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkJaw+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_job_work").on('keyup', function () {
    //if($(this).val() != ''){
        $('#job_work_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkJaw").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-job-work-form']").validate({
    errorClass: "error_msg",
     rules: {
        jaw_Name_en:{
          required:true,
          minlength:2
        },
        jaw_Status:{
          required:true,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkJaw", $("#pkJaw").val());
        $.ajax({
            url: base_url+'/admin/addJobAndWork',
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
                  $('#job_work_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteJobAndWork',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          toastr.success(result.message);
          $('#job_work_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getJobAndWork',
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
          $("#pkJaw").val(result.data.pkJaw);
          $("#jaw_Name_en").val(result.data.jaw_Name_en);
          $("#jaw_Name_sp").val(result.data.jaw_Name_sp);
          $("#jaw_Name_de").val(result.data.jaw_Name_de);
          $("#jaw_Name_hr").val(result.data.jaw_Name_hr);
          $("#jaw_Notes").val(result.data.jaw_Notes);
          $("#jaw_Status").val(result.data.jaw_Status);
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
