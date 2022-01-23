$(function() {

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#citizenships_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getCitizenships",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_citizenship').val();
              d.country = $('#country_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "ctz_Uid" },
            { "data": "ctz_CitizenshipName" },
            { "data": "country", sortable:!1,
              render: function (data, type, country) {
                 return country.country.cny_CountryName;
              }
            },
            { "data": "ctz_Notes", sortable:!1, 
              render: function (data, type, country) {
                if(country.ctz_Notes != null){
                  if(country.ctz_Notes.length > 30){
                      return country.ctz_Notes.substring(0, 45)+' . . .';
                  }else{
                      return country.ctz_Notes;
                  }
                }else{
                  return country.ctz_Notes;
                }
              }
            },
            { "data": "ctz_CitizenshipName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkCtz+'" onclick="triggerEdit('+country.pkCtz+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkCtz+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_citizenship").on('keyup', function () {
    //if($(this).val() != ''){
        $('#citizenships_listing').DataTable().ajax.reload()
   // }
  });

  $("#country_filter").on('change', function () {
      $('#citizenships_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkCtz").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-citizenship-form']").validate({
    errorClass: "error_msg",
     rules: {
        ctz_CitizenshipName:{
          required:true,
          minlength:3,
          maxlength:50
        },
        fkCtzCny:{
          required:true,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkCtz", $("#pkCtz").val());
        $.ajax({
            url: base_url+'/admin/addCitizenship',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  $('#add_new').modal('hide');
                  $('#citizenships_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteCitizenship',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#citizenships_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getCitizenship',
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
