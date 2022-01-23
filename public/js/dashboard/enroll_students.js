/**
* Engage Employee
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
//var base_url = window.location.origin;
$(function() {
  showLoader(false);
  $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true});
  

  $("#enroll_stu_listing").on('DOMNodeInserted DOMNodeRemoved', function() {
    if ($(this).find('tbody tr td').first().attr('colspan')) {
      $(this).parent().hide();
    } else {
      $(this).parent().show();
    }
  });


  var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#enroll_stu_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/employee/getEnrollStudent",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_students').val();
              
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "stu_StudentID",
              render: function (data, type, row) {
                if(row.stu_StudentID == null){
                  return row.stu_TempCitizenId;
                }else{
                  return row.stu_StudentID;
                }
              }
            },
            { "data": "stu_StudentName"},
            { "data": "stu_StudentSurname" },
            { "data": "stu_StudentName", sortable:!1,
              render: function (data, type, student) {
                if(student.stu_StudentID == null){
                  var stuId = student.stu_TempCitizenId;
                }else{
                  var stuId = student.stu_StudentID;
                }
                return'<a class="ajax_request no_sidebar_active" data-slug="employee/viewStudent/'+student.id+'" href="'+base_url+'/employee/viewStudent/'+student.id+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a href="javascript:void(0)" onclick="selEmp(this)" stu-uid="'+stuId+'" stu-name="'+student.stu_StudentName+'" stu-id="'+student.id+'" stu-surname="'+student.stu_StudentSurname+' "><img src="'+imagepath+'/ic_plus.png"></a>'
              }
            },
      ],

  });

  $('.main_table').hide();
  $("#search_students").on('keyup', function () {
      var checkVal = $(this).val();
      if (checkVal) {
        $('.main_table').show();
      }else{
        $('.main_table').hide();
      }
      $('#enroll_stu_listing').DataTable().ajax.reload();
  });


  $("form[name='enroll-stu-form']").validate({
    errorClass: "error_msg",
     rules: {
        ste_EnrollmentDate:{
          required:true
        },
        fkSteMbo:{
          required:true,
        },
        ste_MainBookOrderNumber:{
          required:true,
        },
        fkSteGra:{
          required:true,
        },
        fkSteEdp:{
          required:true,
        },
        fkSteEpl:{
          required:true,
        },
        ste_MainBookOrderNumber:{
          required:true,
          number: true,
          minlength:2,
          maxlength:5,
        },
        fkSteSye:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
      event.preventDefault();
      showLoader(true);
      var formData = new FormData($(form)[0]);
      $.ajax({
          url: base_url+'/employee/enrollStudentPost',
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
            if(result.status){
              toastr.success(result.message);
              $('li a[data-slug="employee/students"]').trigger("click");
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





$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

function selEmp(elem){

  if($('.sel_emp_table .ocg').length != 0){
    toastr.error($('#student_sel_valid_txt').val());
    return;
  }
  $('#students_id').val($(elem).attr('stu-id'));
  $('.sel_emp_table tr').after('<tr class="ocg ocg_'+$(elem).attr('stu-id')+'"><td>1</td><td>'+$(elem).attr('stu-uid')+'</td><td>'+$(elem).attr('stu-name')+'</td><td>'+$(elem).attr('stu-surname')+'</td><td><a data-id="'+$(elem).attr('stu-id')+'" onclick="removeSelEmp(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">'+$('#delete_txt').val()+'</a></td></tr>');
   
  $("#eid").val($(elem).attr('emp-id'));
  $(".sel_emp_div").show();
}

function removeSelEmp(elem){
  $('.ocg').remove();
  $("#eid").val('');
  $(".sel_emp_div").hide();
  $('#students_id').val('');
}

 /*$(".notDisplay").css('display','none');
 $("#fkSteEpl").on('change', function () {
      var epl_value = $(this).val();
      if (epl_value) {
        $(".notDisplay").css('display','block');
      }else{
        $('#fkSteGra').prop("selectedIndex", 0); 
        $('#fkSteEdp').prop("selectedIndex", 0);
        $(".notDisplay").css('display','none');
      }
  });*/

 $("#fkSteEdp").on('change', function () {
      var edp_value = $(this).val();
      if (edp_value) {
          showLoader(true);
          $.ajax({
              url: base_url+'/employee/enrollStudents',
              type: 'GET',
              data: {'fkSteEdp':edp_value},
              success: function(result)
              {
                if (result.status== true) {
                  $(result.educationPlans).each(function( index , element) {
                    $('#fkSteEpl').append(`<option value="${element.pkEpl}">${element.epl_EducationPlanName}</option>`);
                  });
                }else{
                  toastr.error($('#something_wrong_txt').val());
                  showLoader(false);
                }
                showLoader(false);
              },
              error: function(data)
              {
                  toastr.error($('#something_wrong_txt').val());
                  showLoader(false);
              }
          });
      }else{
        $('#fkSteEpl').html(`<option value="" selected>Select</option>`);
        $('#fkSteGra').html(`<option value="" selected>Select</option>`);
      }
  });


 $("#fkSteEpl").on('change', function () {
      var epl_value = $(this).val();
      if (epl_value) {
          showLoader(true);
          $.ajax({
              url: base_url+'/employee/enrollStudents',
              type: 'GET',
              data: {'fkSteEpl':epl_value},
              success: function(result)
              {
                if (result.status== true) {
                    
                    $('#fkSteGra').html(`<option value="${result.grades.pkGra}">${result.grades.gra_GradeName}</option>`);
                  
                }else{
                  toastr.error($('#something_wrong_txt').val());
                  showLoader(false);
                }
                showLoader(false);
              },
              error: function(data)
              {
                  toastr.error($('#something_wrong_txt').val());
                  showLoader(false);
              }
          });
      }else{
        $('#fkSteGra').html(`<option value="" selected>Select</option>`);
      }
  });

 function viewEduPlan(){
    
    var e = document.getElementById("fkSteEpl");
    var selectedPlan = e.options[e.selectedIndex].value;
    if(selectedPlan){
      window.open('viewEducationPlan/'+selectedPlan);
    }else{
      toastr.error($('#msg_select_education_plan').val());
    }
 }

 $('#ste_MainBookOrderNumber').keypress(function(e) {
    var tval = $('#ste_MainBookOrderNumber').val(),
        tlength = tval.length,
        set = 5,
        remain = parseInt(set - tlength);
    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        $('#ste_MainBookOrderNumber').val((tval).substring(0, tlength - 1))
    }
})