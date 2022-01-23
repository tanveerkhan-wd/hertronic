var imagepath='http://gaudeamus.hertronic.com/public/images/';
$(function() {


  $('#grades_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getGrades",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_grade').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "gra_Uid" },
            { "data": "gra_GradeName" },
            { "data": "gra_GradeNameRoman" },
            { "data": "gra_Notes", sortable:!1, 
              render: function (data, type, grade) {
                if(grade.gra_Notes != null){
                  if(grade.gra_Notes.length > 30){
                      return grade.gra_Notes.substring(0, 45)+' . . .';
                  }else{
                      return grade.gra_Notes;
                  }
                }else{
                  return grade.gra_Notes;
                }
              }
            },
            { "data": "gra_GradeName", sortable:!1,
              render: function (data, type, grade) {
                    return'<a cid="'+grade.pkGra+'" onclick="triggerGradeEdit('+grade.pkGra+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+grade.pkGra+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_grade").on('keyup', function () {
    //if($(this).val() != ''){
        $('#grades_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkGra").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-grade-form']").validate({
    errorClass: "error_msg",
     rules: {
        gra_GradeName:{
          required:true,
          maxlength:6
        },
        gra_GradeNameRoman:{
          maxlength:6
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkGra", $("#pkGra").val());
        $.ajax({
            url: base_url+'/admin/addGrade',
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
                  $('#grades_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteGrade',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#grades_listing').DataTable().ajax.reload();
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

function triggerGradeEdit(cid){
  showLoader(true);
  $.ajax({
    url: base_url+'/admin/getGrade',
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
