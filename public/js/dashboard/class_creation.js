$(function() {

  showLoader(false);
  $('.select2_drop').select2({
      "language": {
         "noResults": function(){
             return $('#no_result_text').val();
         }
      },
      placeholder: $('#select_txt').val(),
      allowClear: true
  });

  $('#student_listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    }).DataTable({
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
            "url": base_url+"/employee/getClassStudents",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_student').val();
              d.pkClr = $('#pkClr').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "index",sortable:!1,
              render: function (data, type, mb) {
                if(mb.student.stu_StudentID == '' || mb.student.stu_StudentID == null){
                  return mb.student.stu_TempCitizenId;
                }else{
                  return mb.student.stu_StudentID;
                }
              }
            },
            { "data": "index",sortable:!1,
              render: function (data, type, mb) {
                return mb.student.stu_StudentName+' '+mb.student.stu_StudentSurname;
              }
            },
            { "data": "index", sortable:!1, 
              render: function (data, type, mb) {
                  return mb.grade.gra_GradeName;
              }
            },
            { "data": "index",sortable:!1,
              render: function (data, type, mb) {
                return mb.education_program.edp_Name + ' - ' + mb.education_plan.epl_EducationPlanName;
              }
            },
            { "data": "cla_ClassName", sortable:!1,
              render: function (data, type, mb) {
                    if(mb.student.stu_StudentID == '' || mb.student.stu_StudentID == null){
                      var suid = mb.student.stu_TempCitizenId;
                    }else{
                      var suid = mb.student.stu_StudentID;
                    }
                    return'<button type="button" cid="'+mb.pkSte+'" suid="'+suid+'" sname="'+mb.student.stu_StudentName+' '+mb.student.stu_StudentSurname+'" gra_id="'+mb.grade.gra_GradeName+'" ep_id="'+mb.education_program.edp_Name + ' - ' + mb.education_plan.epl_EducationPlanName+'" class="theme_btn min_btn" onclick="addStudent(this)">'+$('#add_txt').val()+'</button>'
              }
            },
      ],

  });

  var imagepath='http://gaudeamus.hertronic.com/public/images/';

  $("#search_student").on('keyup', function () {
    //if($(this).val() != ''){
        $('#student_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    $("form").trigger("reset");
    $("#pkCla").val('');
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $("form[name='class-creation-step-1']").validate({
    errorClass: "error_msg",
     rules: {
        fkClrSye:{
          required:true,
        },
        fkClrEdp:{
          required:true,
        },
        fkClrGra:{
          required:true,
        },
        fkClrCla:{
          required:true,
        },
        fkClrVsc:{
          required:true,
        },
     },
      errorPlacement: function (error, element) {
        if(element.hasClass('select2_drop') && element.next('.select2-container').length) {
            error.insertAfter(element.next('.select2-container'));
        }else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form, event) {
        event.preventDefault();
        $('#fkClrSye').prop('disabled',false);
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("fkClrSch", $("#fkClrSch").val());
        formData.append("pkClr", $("#pkClr").val());
        formData.append("class_step", 1);
        $.ajax({
            url: base_url+'/employee/classCreation',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  $('.sel_stu_elem').addClass('hide_content');
                  $('.sel_stu_elem .stu').remove();
                  activaTab(2);
                  $('#pkClr').val(result.pkClr);
                  $('#student_listing').DataTable().ajax.reload()
                  
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
        $('#fkClrSye').prop('disabled',true);
    }
  });

  $("form[name='class-creation-step-2']").validate({
      errorClass: "error_msg",

      submitHandler: function(form, event) {
        event.preventDefault();
        if($('.stu').length == 0){
          toastr.error($('#stu_sel_txt').val());
          return;
        }
        $('#fkClrSye').prop('disabled',false);
        showLoader(true);
        var values = $("input[name='stu_ids[]']").map(function(){return $(this).val();}).get();
        var formData = new FormData($(form)[0]);
        formData.append("pkClr", $("#pkClr").val());
        // formData.append("classStu", values);
        formData.append("class_step", 2);
        $.ajax({
            url: base_url+'/employee/classCreation',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  activaTab(3);
                  $('#pkClr').val(result.pkClr);
                  $('.step_3_resp').html(result.step_3_data);
                  $('.select2').select2({
                    "language": {
                       "noResults": function(){
                           return $('#no_result_text').val();
                       }
                   },
                  });
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

  $("form[name='class-creation-step-3']").validate({
      errorClass: "error_msg",
      errorPlacement: function (error, element) {
        if(element.hasClass('select2') && element.next('.select2-container').length) {
          error.insertAfter(element.next('.select2-container'));
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form, event) {
        event.preventDefault();

        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkClr", $("#pkClr").val());
        formData.append("class_step", 3);
        $.ajax({
            url: base_url+'/employee/classCreation',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  activaTab(4);
                  $('#pkClr').val(result.pkClr);
                  $('.step_4_resp').html(result.step_4_data);
                  $('.select2').select2({
                    "language": {
                       "noResults": function(){
                           return $('#no_result_text').val();
                       }
                   },
                  });
                  $("#start_date").datepicker({
                    format: "mm/dd/yyyy",
                    autoclose: true, 
                    startDate: '+0d'
                  }).on('changeDate', function(){
                      $('#end_date').datepicker('setStartDate', new Date($(this).val()));
                  });

                  $('#end_date').datepicker({
                    format: "mm/dd/yyyy",
                    autoclose: true,
                    startDate: $("#start_date").val(),
                  }).on('changeDate', function(){
                    if($("#start_date").val() != ''){
                      $('#start_date').datepicker('setEndDate', new Date($(this).val()));
                    }
                  });
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

  $("form[name='class-creation-step-4']").validate({
      errorClass: "error_msg",
      rules: {
        hrt_WeeklyHoursRate:{
          maxlength:12,
          required:true,
        },
        start_date:{
          required:true,
        },
        fkHrtEty:{
          required:true,
        },
      },
      errorPlacement: function (error, element) {
        if(element.hasClass('select2') && element.next('.select2-container').length) {
            error.insertAfter(element.next('.select2-container'));
        } else {
            error.insertAfter(element);
        }
      },
      submitHandler: function(form, event) {
        event.preventDefault();

        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkClr", $("#pkClr").val());
        formData.append("class_step", 4);
        $.ajax({
            url: base_url+'/employee/classCreation',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  activaTab(5);
                  $('#pkClr').val(result.pkClr);
                  $('.step_5_resp').html(result.step_5_data);
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

  $("form[name='class-creation-step-5']").validate({
      errorClass: "error_msg",
      errorPlacement: function (error, element) {
        if(element.hasClass('select2') && element.next('.select2-container').length) {
          error.insertAfter(element.next('.select2-container'));
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form, event) {
        event.preventDefault();

        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkClr", $("#pkClr").val());
        formData.append("class_step", 5);
        $.ajax({
            url: base_url+'/employee/classCreation',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  // activaTab(4);
                  $('#pkClr').val(result.pkClr);
                  // $('.step_4_resp').html(result.step_4_data);
                  $('.select2').select2({
                    "language": {
                       "noResults": function(){
                           return $('#no_result_text').val();
                       }
                   },
                  });

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


  //Class Creation Listing 
  $('#class_creation_listing').on( 'processing.dt', function ( e, settings, processing ) {
       if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    }).DataTable({
        "columnDefs": [{
          
          
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
            "url": base_url+"/employee/getClassCreations",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_class_creations').val();
              d.grade = $('#searchGrade').val();
              d.schoolYear = $('#search_sch_year').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "class_creation_classes.cla_ClassName",sortable:!1 },
            { "data": "grade",sortable:!1 },
            { "data": "total_stu",sortable:!1 },
            { "data": "class_creation_school_year.sye_NameNumeric",sortable:!1 },
            { "data": "fkClrSye",sortable:!1 ,
                render: function (data, type, mb) {
                  return 'Mr. R Ragvan';
                }
            },
            { "data": "pkClr", sortable:!1,
              render: function (data, type, mb) {
                return'<a class="ajax_request no_sidebar_active" data-slug="admin//'+mb.pkClr+'" href="/'+mb.pkClr+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a cid="'+mb.pkClr+'" onclick="triggerEdit('+mb.pkClr+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDeleteClsCre('+mb.pkClr+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>';
              }
            },
      ],

  });

  $("#search_class_creations").on('keyup', function () {
    //if($(this).val() != ''){
        $('#class_creation_listing').DataTable().ajax.reload()
   // }
  });

  $("#searchGrade").on('change', function () {
    //if($(this).val() != ''){
        $('#class_creation_listing').DataTable().ajax.reload()
   // }
  });

  $("#search_sch_year").on('change', function () {
    //if($(this).val() != ''){
        $('#class_creation_listing').DataTable().ajax.reload()
   // }
  });

});

function addStudent(elem){

  if($('.stu_'+$(elem).attr('cid')).length != 0){
    toastr.error($('#stu_sel_valid_txt').val());
    return;
  }

  var count = $('.stu').length;
  count = count+1;

  $('.class_seleted_students tr:last').after('<tr class="stu stu_'+$(elem).attr('cid')+'"><td><input type="hidden" name="stu_ids[]" value="'+$(elem).attr('cid')+'">'+count+'</td><td>'+$(elem).attr('suid')+'</td><td>'+$(elem).attr('sname')+'</td><td>'+$(elem).attr('gra_id')+'</td><td>'+$(elem).attr('ep_id')+'</td><td><a data-id="'+$(elem).attr('cid')+'" onclick="removeSelStu(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">'+$('#delete_txt').val()+'</a></td></tr>');
   
  $("#eid").val($(elem).attr('emp-id'));
  $(".sel_stu_elem").removeClass('hide_content');
}

function removeSelStu(elem){
  var i = 1;
  var id = $(elem).attr('data-id');
  $('.stu_'+id).remove();

  if($('.stu').length == 0){
    $(".sel_stu_elem").addClass('hide_content');
  }

  $.each($('.stu'), function( index, value ) {
    $(value).children('td:first').text(i++);
  });
  // console.log('fcg',FCG);
}

function prevTab(tab){
  var currTab = tab+1;
  $('.tab-pane').removeClass('active show');
  $('#menu' + tab).addClass('active show');
  $('.btn-round-' + currTab).removeClass('active');
  // $('.select2_drop').select2({
  //     "language": {
  //        "noResults": function(){
  //            return $('#no_result_text').val();
  //        }
  //     },
  //     placeholder: $('#select_txt').val(),
  //     allowClear: true
  // });
}

function activaTab(tab){
    $('.tab-pane').removeClass('active show');
    $('#menu' + tab).addClass('active show');
    $('.btn-round-' + tab).addClass('active');
};

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/admin/deleteClass',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#classes_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getClass',
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

$('#is_village_school').click(function(){
  $('#fkClrVsc').val('');
  if($(this). prop("checked") == true){
    $('.village_schools_drp').removeClass('hide_content');
  }
  else if($(this). prop("checked") == false){
    $('.village_schools_drp').addClass('hide_content');
  }
});

// Class Creation listing Delete
function triggerDeleteClsCre(cid) {
  $('#did').val(cid);   
  $( ".show_delete_modal" ).click();
}

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/employee/deleteClassCreations',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#class_creation_listing').DataTable().ajax.reload();
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