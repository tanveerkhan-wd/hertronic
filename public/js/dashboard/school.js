/**
* Edit Admin School
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
var imagepath='http://gaudeamus.hertronic.com/public/images/';
$(function() {
  $('#school_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": "/admin/getSchools",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_school').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "sch_Uid" },
            { "data": "sch_SchoolName" },
            { "data": "sch_MinistryApprovalCertificate" },
            { "data": "sch_SchoolName",className: "text-center", sortable:!1,
              render: function (data, type, school) {
                 return school.employees_engagement[0].employee.emp_EmployeeName;
              }
            },
            { "data": "sch_SchoolName",className: "text-center", sortable:!1,
              render: function (data, type, school) {
                 return school.employees_engagement[0].employee.email;
              }
            },
            { "data": "sch_SchoolName", sortable:!1,
              render: function (data, type, country) {
                 return'<a class="ajax_request no_sidebar_active" data-slug="admin/viewSchool/'+country.pkSch+'" href="viewSchool/'+country.pkSch+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a class="ajax_request no_sidebar_active" data-slug="admin/editSchool/'+country.pkSch+'" href="editSchool/'+country.pkSch+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkSch+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });

  $("#search_school").on('keyup', function () {
    //if($(this).val() != ''){
        $('#school_listing').DataTable().ajax.reload()
   // }
  });

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-school-form']").validate({
    errorClass: "error_msg",
     rules: {
        sch_SchoolName:{
          required:true,
          minlength:3
        },
        sch_MinistryApprovalCertificate:{
          required:true,
          minlength:5,
          maxlength:25
        },
        sch_CoordName:{
          required:true,
          minlength:5,
          maxlength:25
        },
        sch_CoordEmail:{
          required:true,
          minlength:5,
          maxlength:25,
          email:true
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();

        if (SP.length == 0) {
          toastr.error($('#education_plan_validate_txt').val());
          return;
        }    

        if (!$("form[name='add-school-form']")[0].checkValidity()) {
          $("form[name='add-school-form']")[0].reportValidity();
          return;
        }

        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkSch", $("#pkSch").val());
        formData.append("SP", SP);
        if($('#edit-school').length == 0){
          var url = '/admin/addSchool';
        }else{
          var url = '/admin/editSchool';
          formData.append("pkSch", $('#eid').val());
        }
        $.ajax({
            url: url,
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  $('li a[data-slug="admin/schools"]').trigger("click");
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

function fetchEPlan(pid){
  $('#eplan').find('option').not(':first').remove();
  if(pid != ''){
    showLoader(true);
    $.ajax({
      url: '/admin/fetchEducationPlan',
      type: 'POST',
      dataType:'json',
      cache: false,              
      data: {'pid':pid},
      success: function(result)
      {
          if(result.status){
            $.each(result.data, function(key,value){
                $('#eplan').append($("<option></option>")
                      .attr("value",value.pkEpl)
                      .attr("EPmain",result.EPmain)
                      .attr("EPparent",result.EPparent)
                      .attr("NEP",value.national_education_plan.nep_NationalEducationPlanName)
                      .attr("QAD",value.qualification_degree.qde_QualificationDegreeName)
                      .attr("EPR",value.education_profile.epr_EducationProfileName)
                      .text(value.epl_EducationPlanName)); 
            });
            // $('#school_listing').DataTable().ajax.reload();
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
}

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: '/admin/deleteSchool',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#school_listing').DataTable().ajax.reload();
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

function addPlan(){
  if($('#eplan').val() != ''){
    var currSP = $('#eplan').val()


    if($('.sch_'+$('#eplan').val()).length !=0){
      toastr.error($('#education_plan_add_validate_txt').val());
      return;
    }
    if(currSP != ''){
     SP.push(currSP);
    }

    $('.school_plan_table tbody').append('<tr class="sch sch_'+$('#eplan').val()+'"><td>'+($('tr.sch').length+1)+'</td><td>'+$('#eplan option:selected').attr('EPparent')+'</td><td>'+$('#eplan option:selected').attr('EPmain')+'</td><td>'+$('#eplan option:selected').text()+'</td><td>'+$('#eplan option:selected').attr('NEP')+'</td><td>'+$('#eplan option:selected').attr('QAD')+'</td><td>'+$('#eplan option:selected').attr('EPR')+'</td><td><div class="form-group form-check"><input type="checkbox" class="form-check-input" name="sep_Status[]" value="'+$('#eplan').val()+'" id="exampleCheck'+$('#eplan').val()+'"><label class="custom_checkbox"></label><label class="form-check-label label-text" for="exampleCheck'+$('#eplan').val()+'"><strong></strong></label><a target="_blank" href="viewEducationPlan/'+$('#eplan').val()+'"><i class="fa fa-info-circle" aria-hidden="true"></i></a></div><a data-id="'+$('#eplan').val()+'" onclick="removePlan(this)" href="javascript:void(0)"><i style="color:red" class="fa fa-trash" aria-hidden="true"></i></a></td></tr>');

    if($('tr.sch').length != 0){
      $(".school_plan_table").show();
    }

    console.log('SP',SP);

  }else{
     toastr.error($('#education_plan_validate_txt').val());
  }
}


function triggerDelete(cid){
   $('#did').val(cid);   
   $( ".show_delete_modal" ).click();
}

function removePlan(elem){
  var id = $(elem).attr('data-id');
  $('.sch_'+id).remove();
 
  SP = jQuery.grep(SP, function(value) {
    return value != id;
  });

  var i = 1;
  $.each($('.sch'), function( index, value ) {
    console.log('i_loop_'+i);
    $(value).children('td:first').text(i);
    i++
  });

  if($('tr.sch').length == 0){
    $(".school_plan_table").hide();
  }
  console.log('sp',SP);
}


function cleanHrs(val){
  var vv = val.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
  $(val).val(vv);
}

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
