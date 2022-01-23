/**
* Main Book
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

$('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true, endDate: '+0d',});

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#mainbook_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/employee/getMainBooks",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_mainbook').val();
              d.date_filter = $('#date_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "mbo_Uid" },
            { "data": "mbo_MainBookNameRoman" },
            { "data": "mbo_OpeningDate" },
            { "data": "mbo_Notes", sortable:!1, 
              render: function (data, type, mb) {
                if(mb.mbo_Notes != null){
                  if(mb.mbo_Notes.length > 30){
                      return mb.mbo_Notes.substring(0, 45)+' . . .';
                  }else{
                      return mb.mbo_Notes;
                  }
                }else{
                  return mb.mbo_Notes;
                }
              }
            },
            { "data": "mbo_MainBookNameRoman", sortable:!1,
              render: function (data, type, mb) {
                    return'<a class="ajax_request no_sidebar_active" data-slug="employee/viewMainBook/'+mb.pkMbo+'" href="viewMainBook/'+mb.pkMbo+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a cid="'+mb.pkMbo+'" onclick="triggerEdit('+mb.pkMbo+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+mb.pkMbo+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_mainbook").on('keyup', function () {
    $('#mainbook_listing').DataTable().ajax.reload()
  });

  $("#date_filter").on('change', function () {
      $('#mainbook_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkMbo").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-mainbook-form']").validate({
    errorClass: "error_msg",
     rules: {
        mbo_MainBookNameRoman:{
          required:true,
          minlength:3,
          maxlength:15
        },
        mbo_OpeningDate:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkMbo", $("#pkMbo").val());
        formData.append("fkMboSch", $("#fkMboSch").val());
        
        $.ajax({
            url: base_url+'/employee/addMainBook',
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
                $('#mainbook_listing').DataTable().ajax.reload();
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


  $('#student_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/employee/getMainBookStudents",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_student').val();
              d.fkSteMbo = $('#fkSteMbo').val();
              d.date_filter = $('#mdate_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "mbo_Uid",sortable:!1,
              render: function (data, type, mb) {
                return mb.student.stu_StudentName+' '+mb.student.stu_StudentSurname;
              }
            },
            { "data": "mbo_Uid",sortable:!1,
              render: function (data, type, mb) {
                return mb.student.stu_FatherName;
              }
            },
            { "data": "mbo_Uid",sortable:!1,
              render: function (data, type, mb) {
                return mb.student.stu_MotherName;
              }
            },
            { "data": "ste_EnrollmentDate", sortable:!1 },
            { "data": "mbo_Uid", sortable:!1, 
              render: function (data, type, mb) {
                  return mb.grade.gra_GradeName;
              }
            },
            { "data": "stu_DateOfBirth", sortable:!1 },
            { "data": "mbo_Uid", sortable:!1,
              render: function (data, type, mb) {
                return mb.student.stu_PhoneNumber;
              }
            },
            { "data": "ste_status", sortable:!1},

      ],

  });

  $("#search_student").on('keyup', function () {
    $('#student_listing').DataTable().ajax.reload()
  });

  $("#mdate_filter").on('change', function () {
      $('#student_listing').DataTable().ajax.reload()
  });


});

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/employee/deleteMainBook',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#delete_prompt').modal('hide');
          $('#mainbook_listing').DataTable().ajax.reload();
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
    url: base_url+'/employee/getMainBook',
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
