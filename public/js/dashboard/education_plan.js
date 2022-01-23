/**
* Edit Admin Education Plan
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
// var FCG = [];
// var OCG = [];
// var MCG = [];
$(function() {
var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#education_plan_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": "/admin/getEducationPlans",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_education_plan').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "epl_Uid" },
            { "data": "epl_EducationPlanName" },
            { "data": "epl_EducationPlanName",className: "text-center", sortable:!1,
              render: function (data, type, grades) {
                 return grades.grades.gra_GradeName;
              }
            },
            { "data": "epl_EducationPlanName", sortable:!1,
              render: function (data, type, country) {
                 return'<a class="ajax_request no_sidebar_active" data-slug="admin/viewEducationPlan/'+country.pkEpl+'" href="viewEducationPlan/'+country.pkEpl+'"><img src="'+imagepath+'/ic_eye_color.png"></a>\t\t\t\t\t\t<a class="ajax_request no_sidebar_active" data-slug="admin/editEducationPlan/'+country.pkEpl+'" href="editEducationPlan/'+country.pkEpl+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkEpl+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });

  $('#fkEplEdp').on('change', function () {
    if($(this).val() == ''){
      $('.edp_label').text('');
    }else{
      $('.edp_label').text($("#fkEplEdp option:selected").text().trim());
    }
  })

  $("#search_education_plan").on('keyup', function () {
    //if($(this).val() != ''){
        $('#education_plan_listing').DataTable().ajax.reload()
   // }
  });

  $('#add_new').on('hidden.bs.modal', function () {
    var validator = $( "form" ).validate();
    validator.resetForm();
    $("form").trigger("reset");
    $("#pkEpl").val('');
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-education-plan-form']").validate({
    errorClass: "error_msg",
     rules: {
        epl_EducationPlanName:{
          required:true,
          minlength:3
        },
        fkEplEdp:{
          required:true,
        },
        fkEplNep:{
          required:true,
        },
        fkEplEpr:{
          required:true,
        },
        fkEplQde:{
          required:true,
        },
        fkEplGra:{
          required:true,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();

        if (MCG.length == 0) {
          toastr.error($('#MCG_validate_txt').val());
          return;
        }
        if (OCG.length == 0) {
          toastr.error($('#OCG_validate_txt').val());
          return;
        }
        if (FCG.length == 0) {
          toastr.error($('#FCG_validate_txt').val());
          return;
        }        

        if (!$("form[name='add-education-plan-form']")[0].checkValidity()) {
          $("form[name='add-education-plan-form']")[0].reportValidity();
          return;
        }

        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkEpl", $("#pkEpl").val());
        formData.append("MCG", MCG);
        formData.append("OCG", OCG);
        formData.append("FCG", FCG);
        if($('#edit-education-plan').length == 0){
          var url = '/admin/addEducationPlan';
        }else{
          var url = '/admin/editEducationPlan';
          formData.append("pkEpl", $('#eid').val());
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
                  $('li a[data-slug="admin/educationPlans"]').trigger("click");
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
    url: '/admin/deleteEducationPlan',
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
    url: '/admin/getEducationPlan',
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


function addFCG(elem){

  if($('#fcg_select').val() == ''){
    toastr.error($('#FCG_validate_txt').val());
    return;
  }

  if($('#fcg_hrs').val() == ''){
    toastr.error($('#hours_validate_txt').val());
    return;
  }
  var currFcg = $('#fcg_select').val()

  $('.fcg_table tr:last').before('<tr class="fcg fcg_'+$('#fcg_select').val()+'"><td>'+$('tr.fcg').length+'</td><td>'+$('#fcg_select option:selected').text()+'</td><td><input onkeyup="cleanHrs(this)" required name="fcg_hrs[]" type="text" id="fcg_hrs_'+$('#fcg_select').val()+'" value="'+$('#fcg_hrs').val()+'"></td><td><a data-id="'+$('#fcg_select').val()+'" onclick="removeFCG(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">'+$('#delete_txt').val()+'</a></td></tr>');
  $('.fcg_table .fcg_main td:first').text($('tr.fcg').length);
  $("#fcg_select option[value='"+ $('#fcg_select').val() + "']").attr('disabled', true); 
  if(currFcg != ''){
   FCG.push(currFcg);
  }
  $('#fcg_select').val('');
  $('#fcg_hrs').val('');
  if($('#fcg_select option:not(:disabled)').length == 1){
    $(".fcg_main").hide();
  }
   console.log('fcg',FCG);
   
}


function removeFCG(elem){
  var i = 1;
  var id = $(elem).attr('data-id');
  $("#fcg_select option[value='"+ id + "']").attr('disabled', false);
  $('.fcg_'+id).remove();
  $('.fcg_table .fcg_main td:first').text($('tr.fcg').length);
  if($('#fcg_select option:not(:disabled)').length != 1){
    $(".fcg_main").show();
  }
  FCG = jQuery.grep(FCG, function(value) {
    return value != id;
  });
  $.each($('.fcg:not(:last-child)'), function( index, value ) {
    $(value).children('td:first').text(i++);
  });
  console.log('fcg',FCG);
}

function addOCG(elem){

  if($('#ocg_select').val() == ''){
    toastr.error($('#OCG_validate_txt').val());
    return;
  }

  if($('#ocg_hrs').val() == ''){
    toastr.error($('#hours_validate_txt').val());
    return;
  }
  var currOcg = $('#ocg_select').val()

  $('.ocg_table tr:last').before('<tr class="ocg ocg_'+$('#ocg_select').val()+'"><td>'+$('tr.ocg').length+'</td><td>'+$('#ocg_select option:selected').text()+'</td><td><input onkeyup="cleanHrs(this)" required name="ocg_hrs[]" type="text" id="ocg_hrs_'+$('#ocg_select').val()+'" value="'+$('#ocg_hrs').val()+'"></td><td><a data-id="'+$('#ocg_select').val()+'" onclick="removeOCG(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">'+$('#delete_txt').val()+'</a></td></tr>');
  $('.ocg_table .ocg_main td:first').text($('tr.ocg').length);
  $("#ocg_select option[value='"+ $('#ocg_select').val() + "']").attr('disabled', true); 
  if(currOcg != ''){
   OCG.push(currOcg);
  }
  $('#ocg_select').val('');
  $('#ocg_hrs').val('');
  if($('#ocg_select option:not(:disabled)').length == 1){
    $(".ocg_main").hide();
  }
   console.log('ocg',OCG);
   
}


function removeOCG(elem){
  var i = 1;
  var id = $(elem).attr('data-id');
  $("#ocg_select option[value='"+ id + "']").attr('disabled', false);
  $('.ocg_'+id).remove();
  $('.ocg_table .ocg_main td:first').text($('tr.ocg').length);
  if($('#ocg_select option:not(:disabled)').length != 1){
    $(".ocg_main").show();
  }
  OCG = jQuery.grep(OCG, function(value) {
    return value != id;
  });
  $.each($('.ocg:not(:last-child)'), function( index, value ) {
    $(value).children('td:first').text(i++);
  });
  console.log('ocg',OCG);
}

function addMCG(elem){

  if($('#mcg_select').val() == ''){
    toastr.error($('#MCG_validate_txt').val());
    return;
  }

  if($('#mcg_hrs').val() == ''){
    toastr.error($('#hours_validate_txt').val());
    return;
  }
  var currMcg = $('#mcg_select').val()

  $('.mcg_table tr:last').before('<tr class="mcg mcg_'+$('#mcg_select').val()+'"><td>'+$('tr.mcg').length+'</td><td>'+$('#mcg_select option:selected').text()+'</td><td><input onkeyup="cleanHrs(this)" required name="mcg_hrs[]" type="text" id="mcg_hrs_'+$('#mcg_select').val()+'" value="'+$('#mcg_hrs').val()+'"></td><td><a data-id="'+$('#mcg_select').val()+'" onclick="removeMCG(this)" href="javascript:void(0)" class="theme_btn red_btn min_btn">'+$('#delete_txt').val()+'</a></td></tr>');
  $('.mcg_table .mcg_main td:first').text($('tr.mcg').length);
  $("#mcg_select option[value='"+ $('#mcg_select').val() + "']").attr('disabled', true); 
  if(currMcg != ''){
   MCG.push(currMcg);
  }
  $('#mcg_select').val('');
  $('#mcg_hrs').val('');
  if($('#mcg_select option:not(:disabled)').length == 1){
    $(".mcg_main").hide();
  }
   console.log('mcg',MCG);
   
}


function removeMCG(elem){
  var i = 1;
  var id = $(elem).attr('data-id');
  $("#mcg_select option[value='"+ id + "']").attr('disabled', false);
  $('.mcg_'+id).remove();
  $('.mcg_table .mcg_main td:first').text($('tr.mcg').length);
  if($('#mcg_select option:not(:disabled)').length != 1){
    $(".mcg_main").show();
  }
  MCG = jQuery.grep(MCG, function(value) {
    return value != id;
  });
  $.each($('.mcg:not(:last-child)'), function( index, value ) {
    $(value).children('td:first').text(i++);
  });
  console.log('mcg',MCG);
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
