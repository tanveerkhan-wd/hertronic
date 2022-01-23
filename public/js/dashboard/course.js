$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#courses_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getCourses",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_course').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "crs_Uid" },
            { "data": "crs_CourseName" },
            { "data": "crs_CourseAlternativeName" },
            { "data": "crs_Notes", sortable:!1, 
              render: function (data, type, country) {
                if(country.crs_Notes != null){
                  if(country.crs_Notes.length > 30){
                      return country.crs_Notes.substring(0, 45)+' . . .';
                  }else{
                      return country.crs_Notes;
                  }
                }else{
                  return country.crs_Notes;
                }
              }
            },
            { "data": "crs_CourseName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkCrs+'" onclick="triggerEdit('+country.pkCrs+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkCrs+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_course").on('keyup', function () {
    //if($(this).val() != ''){
        $('#courses_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkCrs").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-course-form']").validate({
    errorClass: "error_msg",
     rules: {
        crs_CourseName_en:{
          required:true,
          minlength:3,
          maxlength:50
        },
        crs_Uid:{
          required:true,
          minlength:3,
          maxlength:10,
        },
        crs_CourseType:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkCrs", $("#pkCrs").val());
        $.ajax({
            url: base_url+'/admin/addCourse',
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
                $('#courses_listing').DataTable().ajax.reload();
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
  });



});

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/admin/deleteCourse',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#courses_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getCourse',
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
          $("input[name=crs_IsForeignLanguage][value='"+result.data.crs_IsForeignLanguage+"']").prop("checked",true);
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
