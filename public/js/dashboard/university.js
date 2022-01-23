/**
* Edit Admin University
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
      $('#university_img').attr('src', $('#img_tmp').val());
  }
    selectProfileImage(this);
});

var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#universities_listing').on( 'processing.dt', function ( e, settings, processing ) {
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
            "url": base_url+"/admin/getUniversities",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_university').val();
              d.year = $('#year_filter').val();
              d.country = $('#country_filter').val();
              d.ownership = $('#ownership_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            { "data": "uni_Uid" },
            { "data": "uni_UniversityName" },
            { "data": "country", sortable:!1,
              render: function (data, type, university) {
                 return university.country.cny_CountryName;
              }
            },
            { "data": "uni_YearStartedFounded" },
            { "data": "state", sortable:!1,
              render: function (data, type, university) {
                 return university.ownership_type.oty_OwnershipTypeName;
              }
            },
            { "data": "uni_Notes", sortable:!1, 
              render: function (data, type, university) {
                if(university.uni_Notes != null){
                  if(university.uni_Notes.length > 30){
                      return university.uni_Notes.substring(0, 45)+' . . .';
                  }else{
                      return university.uni_Notes;
                  }
                }else{
                  return university.uni_Notes;
                }
              }
            },
            { "data": "uni_UniversityName", sortable:!1,
              render: function (data, type, country) {
                    return'<a cid="'+country.pkUni+'" onclick="triggerEdit('+country.pkUni+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_mode_edit.png"></a>\t\t\t\t\t\t<a onclick="triggerDelete('+country.pkUni+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>'
              }
            },
      ],

  });


  $("#search_university").on('keyup', function () {
    //if($(this).val() != ''){
        $('#universities_listing').DataTable().ajax.reload()
   // }
  });

  $("#country_filter").on('change', function () {
      $('#universities_listing').DataTable().ajax.reload()
  });

  $("#year_filter").on('change', function () {
      $('#universities_listing').DataTable().ajax.reload()
  });

  $("#ownership_filter").on('change', function () {
      $('#universities_listing').DataTable().ajax.reload()
  });

  $('#add_new').on('hidden.bs.modal', function () {
    var validator = $( "form[name='add-university-form']" ).validate();
    validator.resetForm();
    $('#university_img').attr('src', $('#img_tmp').val());
    $("form").trigger("reset");
    $("#pkUni").val('');
  })

  $('#add_new').on('shown.bs.modal', function () {
    $("form").data('validator').resetForm();
  })

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("form[name='add-university-form']").validate({
    errorClass: "error_msg",
     rules: {
        uni_UniversityName_en:{
          required:true,
          minlength:3
        },
        fkUniOty:{
          required:true,
        },
        fkUniCny:{
          required:true,
        },
        uni_YearStartedFounded:{
          required:true,
          digits: true,
          minlength:4,
          maxlength:4,
        }
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("pkUni", $("#pkUni").val());
        $.ajax({
            url: base_url+'/admin/addUniversity',
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
                  $('#universities_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/deleteUniversity',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#universities_listing').DataTable().ajax.reload();
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
    url: base_url+'/admin/getUniversity',
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
        $("#pkUni").val(result.data.pkUni);
        if(result.data.uni_PicturePath != null && result.data.uni_PicturePath != ''){
          $('#university_img').attr('src',result.data.uni_PicturePath);
        }
        $("#uni_UniversityName_en").val(result.data.uni_UniversityName_en);
        $("#uni_UniversityName_sp").val(result.data.uni_UniversityName_sp);
        $("#uni_UniversityName_de").val(result.data.uni_UniversityName_de);
        $("#uni_UniversityName_hr").val(result.data.uni_UniversityName_hr);
        $("#fkUniCny").val(result.data.fkUniCny);
        $("#uni_YearStartedFounded").val(result.data.uni_YearStartedFounded);
        $("#uni_Notes").val(result.data.uni_Notes);
        $("#fkUniOty").val(result.data.fkUniOty);
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
            jQuery('#university_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
