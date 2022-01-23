/**
* Colleges
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

$(".datepicker-year").datepicker({
    format: "yyyy",
    viewMode: "years", 
    autoclose: true,
    endDate: '+0d',
    autoclose: true,
    minViewMode: "years"
});



$("#upload_profile").on('change', function () { 
  if( document.getElementById("upload_profile").files.length == 0 ){
      $('#college_img').attr('src', $('#img_tmp').val());
  }
    selectProfileImage(this);
});

$("[name='col_BelongsToUniversity']").on('change', function () { 
  if( $(this).val() == 'Yes' ){
      $('.university_option').show();
  }else{
      $("#fkColUni").val('');
      $('.university_option').hide();
  }
});

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#colleges_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getColleges",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_college').val();
              d.year = $('#year_filter').val();
              d.country = $('#country_filter').val();
              d.ownership = $('#ownership_filter').val();
              d.university = $('#university_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "col_Uid" },
            { "data": "col_CollegeName" },
            { "data": "col_CollegeName", sortable:!1,
              render: function (data, type, college) {
                if(college.university != null){
                   return college.university.uni_UniversityName;
                }else{
                   return '-';
                }
              }
            },
            { "data": "col_CollegeName", sortable:!1,
              render: function (data, type, college) {
                 return college.country.cny_CountryName;
              }
            },
            { "data": "col_YearStartedFounded" },
            { "data": "col_CollegeName", sortable:!1,
              render: function (data, type, college) {
                 return college.ownership_type.oty_OwnershipTypeName;
              }
            },
            { "data": "col_Notes", sortable:!1, 
              render: function (data, type, college) {
                if(college.col_Notes != null){
                  if(college.col_Notes.length > 30){
                      return college.col_Notes.substring(0, 45)+' . . .';
                  }else{
                      return college.col_Notes;
                  }
                }else{
                  return college.col_Notes;
                }
              }
            },
            { "data": "uni_UniversityName", sortable:!1,
              render: function (data, type, college) {
                    return'<a cid="'+college.pkCol+'" onclick="triggerEdit('+college.pkCol+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+college.pkCol+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_college").on('keyup', function () {
    //if($(this).val() != ''){
        $('#colleges_listing').DataTable().ajax.reload()
   // }
  });

  $("#country_filter").on('change', function () {
      $('#colleges_listing').DataTable().ajax.reload()
  });

  $("#year_filter").on('change', function () {
      $('#colleges_listing').DataTable().ajax.reload()
  });

  $("#ownership_filter").on('change', function () {
      $('#colleges_listing').DataTable().ajax.reload()
  });

  $('#university_filter').on('change', function () {
      $('#colleges_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    var validator = $( "form[name='add-college-form']" ).validate();
    validator.resetForm();
    $('#college_img').attr('src', $('#img_tmp').val());
    $("form").trigger("reset");
    $("#pkCol").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-college-form']").validate({
    errorClass: "error_msg",
     rules: {
        col_CollegeName_en:{
          required:true,
          minlength:3
        },
        fkColOty:{
          required:true,
        },
        fkColCny:{
          required:true,
        },
        col_YearStartedFounded:{
          required:true,
          digits: true,
          minlength:4,
          maxlength:4,
        },
        fkColUni:{
          required:true,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkCol", $("#pkCol").val());
        $.ajax({
            url: base_url+'/admin/addCollege',
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
                  //$("#country_filter").val('');
                  $('#colleges_listing').DataTable().ajax.reload();
                  //fetchState('',1);
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
    url: base_url+'/admin/deleteCollege',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#colleges_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getCollege',
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
        $("#pkCol").val(result.data.pkCol);
        if(result.data.col_PicturePath != null && result.data.col_PicturePath != ''){
          $('#college_img').attr('src',result.data.col_PicturePath);
        }
        $("#col_CollegeName_en").val(result.data.col_CollegeName_en);
        $("#col_CollegeName_sp").val(result.data.col_CollegeName_sp);
        $("#col_CollegeName_de").val(result.data.col_CollegeName_de);
        $("#col_CollegeName_hr").val(result.data.col_CollegeName_hr);
        $("#fkColCny").val(result.data.fkColCny);
        $("#col_YearStartedFounded").val(result.data.col_YearStartedFounded);
        $("input[name=col_BelongsToUniversity][value='"+result.data.col_BelongsToUniversity+"']").prop("checked",true);
        if(result.data.col_BelongsToUniversity == 'Yes'){
          $('.university_option').show();
        }else{
          $('.university_option').hide();
        }
        $("#col_Notes").val(result.data.col_Notes);
        $("#fkColOty").val(result.data.fkColOty);
        $("#fkColUni").val(result.data.fkColUni);
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

function selectProfileImage(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#college_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
