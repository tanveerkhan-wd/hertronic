$(function() {

  showLoader(false);

  $("#upload_profile").on('change', function () { 
    if( document.getElementById("upload_profile").files.length == 0 ){
        $('#user_img').attr('src', $('#img_tmp').val());
    }
      selectProfileImage(this);
  });

  $(document).on('change', '.diploma_file', function(){
    var currData = $(this).attr('id');
    var ids = currData.split("_");
    var currId = ids[2];
    if($(this).val() != ''){
      var file = $(this)[0].files[0];
      $('#file_name_'+currId).val(file.name);
    }else{
      $('#file_name_'+currId).val('');
      $('#eed_DiplomaPicturePath_'+currId).prop('required',true);
    }
  });

  $('#Current-tab').on('show.bs.tab', function () {
    $(".datepicker-year").datepicker({
        format: "yyyy",
        viewMode: "years", 
        autoclose: true,
        endDate: '+0d',
        autoclose: true,
        minViewMode: "years"
    });
  })

  $('#tab3-tab').on('show.bs.tab', function () {
    $('.datepicker_future').datepicker({format: "mm/dd/yyyy",autoclose: true, startDate: '+0d',});
  })

  $('.datepicker_norm').datepicker({format: "mm/dd/yyyy",autoclose: true});

  $('#change_pass').on('hidden.bs.modal', function () {
    var validator = $( "form[name='change-password-form']" ).validate();
    validator.resetForm();
    $("form").trigger("reset");
  })

  $('#add_qa').on('click', function () {
    var $ed = $('#profile_de_details .profile_info_container').clone();
    var ind = $('#edit_profile_detail2 .profile_info_container').length+1;
    $ed.find('.rm_ed').attr('data-eed',ind);
    $ed.find('select,input').each(function(key, value)
    {
      this.id = this.id+'_'+ind;
      this.name = this.name+'_'+ind;
    });  

    $('#edit_profile_detail2 .profile_de_details_add .text-center:first').before($ed);
    $(".datepicker-year").datepicker({
        format: "yyyy",
        viewMode: "years", 
        autoclose: true,
        endDate: '+0d',
        autoclose: true,
        minViewMode: "years"
    });
  });

  $('#add_eng').on('click', function () {
    var $ed = $('#profile_eng_details .profile_info_container').clone();
    var ind = $('#edit_profile_detail3 .profile_info_container').length+1;
    $ed.find('.rm_eng').attr('data-eed',ind);
    $ed.find('select,input').each(function(key, value)
    {
      this.id = this.id+'_'+ind;
      this.name = this.name+'_'+ind;
    });  

    $('#edit_profile_detail3 .profile_eng_details_add .text-center:first').before($ed);
    $('.datepicker_future').datepicker({format: "mm/dd/yyyy",autoclose: true, startDate: '+0d',});

    if($('#edit_profile_detail3 .new_emp_eng').length != 0){
      $('.add_eng_btn').hide();
    }

  });

  $(document).on('click', '.rm_ed', function () {
    $(this).closest('.profile_info_container').remove();
    // var ind = $('#edit_profile_detail2 .profile_info_container').length
    var inc = 1;
    $('#edit_profile_detail2 .profile_info_container').each(function(i, obj) {
        $(this).find('select,input').each(function(key, value)
        {
          var old_id = this.id.split("_");
          old_id.splice(-1,1);
          old_id.push(inc);
          var new_id = old_id.join('_');

          this.id = new_id;
          this.name = new_id;
        });
        inc++;  
    });
  
    if($('#edit_profile_detail3 .new_emp_eng').length == 0){
      $('.add_eng_btn').show();
    }
  });

  $(document).on('click', '.rm_eng', function () {
    $(this).closest('.profile_info_container').remove();
    // var ind = $('#edit_profile_detail2 .profile_info_container').length
    var inc = 1;
    $('#edit_profile_detail3 .profile_info_container').each(function(i, obj) {
        $(this).find('select,input').each(function(key, value)
        {
          var old_id = this.id.split("_");
          old_id.splice(-1,1);
          old_id.push(inc);
          var new_id = old_id.join('_');

          this.id = new_id;
          this.name = new_id;
        });
        inc++;  
    });
  
    if($('#edit_profile_detail3 .new_emp_eng').length == 0){
      $('.add_eng_btn').show();
    }
  });


  $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true, endDate: '+0d',});

  //Education detail validation form
  $("form[name='engage-emp-form']").validate({
      errorClass: "error_msg",
     rules: {
        fkEedUni:{
          required:true
        },
        fkEedCol:{
          required:true
        },
        fkEedAcd:{
          required:true
        },
        eed_DiplomaPicturePath:{
          required:true
        }
     },
      submitHandler: function(form, event) {
      //form.submit();
       event.preventDefault();
       if($('.profile_eng_details_add .profile_info_container').length == 0){
        toastr.error($('#add_engagment_txt').val());
        return;
       }
       showLoader(true);
      var formData = new FormData($(form)[0]);
      formData.append("total_details", $('.profile_eng_details_add .profile_info_container').length);
      $.ajax({
          url: '/employee/editEngagementDetails',
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
              //location.reload();
              console.log('result',result);
              if(result.status){
                toastr.success(result.message);
                $('a[data-slug="employee/profile"]').trigger("click");
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

  $("form[name='edit-profile']").validate({
    errorClass: "error_msg",
     rules: {
        email:{
          required:true,
          email: true,
          emailfull: true
        },
        emp_EmployeeName:{
          required:true,
          minlength:5,
          maxlength:30
        },
        emp_EmployeeID:{
          required:true,
          minlength:5,
          maxlength:30
        },
        emp_TempCitizenId:{
          // required:true,
          minlength:5,
          maxlength:30
        },
        emp_PlaceOfBirth:{
          required:true,
          minlength:3,
          maxlength:30
        },
        emp_PhoneNumber:{
          required:true,
          minlength:10,
          maxlength:12
        },
        fkEmpCny:{
          required:true
        },
        fkEmpMun:{
          required:true
        },
        fkEmpNat:{
          required:true
        },
        fkEmpCtz:{
          required:true
        },
        fkEmpPof:{
          required:true
        },
        fkEedEde:{
          required:true
        },
        fkEmpRel:{
          required:true
        },
     },
      submitHandler: function(form, event) {
      //form.submit();
       event.preventDefault();
       showLoader(true);
      var formData = new FormData($(form)[0]);
      $.ajax({
          url: '/employee/editProfile',
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
              //location.reload();
              console.log('result',result);
              if(result.status){
                toastr.success(result.message);
                $('a[data-slug="employee/profile"]').trigger("click");
                $('.profile-cover img').attr('src',$('#user_img').attr('src'));
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

//Education detail validation form
  $("form[name='employee-education-detail-form']").validate({
      errorClass: "error_msg",
     rules: {
        fkEedUni:{
          required:true
        },
        fkEedCol:{
          required:true
        },
        fkEedAcd:{
          required:true
        },
        fkEedQde:{
          required:true
        },
        fkEedEde:{
          required:true
        },
        eed_YearsOfPassing:{
          required:true
        },
        eed_ShortTitle:{
          required:true,
          minlength:2,
          maxlength:10
        },
        eed_SemesterNumbers:{
          required:true,
          number:true,
          maxlength:4
        },
        eed_EctsPoints:{
          required:true,
          number:true,
          maxlength:5
        },
        eed_DiplomaPicturePath:{
          required:true
        }
     },
      submitHandler: function(form, event) {
      //form.submit();
       event.preventDefault();
       if($('.profile_de_details_add .profile_info_container').length == 0){
        toastr.error($('#add_qualification_txt').val());
        return;
       }
       showLoader(true);
      var formData = new FormData($(form)[0]);
      formData.append("total_details", $('.profile_de_details_add .profile_info_container').length);
      $.ajax({
          url: '/employee/editEducationDetails',
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
              //location.reload();
              console.log('result',result);
              if(result.status){
                toastr.success(result.message);
                $('a[data-slug="employee/profile"]').trigger("click");
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

  jQuery.validator.addMethod("emailfull", function(value, element) {
     return this.optional(element) || /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i.test(value);
    }, $('#email_validate_txt').val());

//Validate form for Change Password
  $("form[name='change-password-form']").validate({
    errorClass: "error_msg",
     rules: {
        old_password:{
          required:true,
          minlength:6,
          maxlength:15
        },
        new_password:{
          required:true,
          minlength:6,
          maxlength:15,
          passwordCheck:true
        },
        confirm_password:{
          required:true,
          equalTo: "#new_password",
          minlength:6,
          maxlength:15
        },
     },
      messages: {
        // password: {
        //   required: "Please provide a password",
        //   minlength: "Password must be at least 6 characters long."
        // },
        confirm_password:{
          equalTo: $('#validate_password_equalto_txt').val(),
        },
      },

      submitHandler: function(form, event) {
      //form.submit();
       event.preventDefault();
       showLoader(true);
      var formData = new FormData($(form)[0]);
      $.ajax({
          url: '/changePasswordPost',
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
              //location.reload();
              console.log('result',result);
              if(result.status){
                showMessage(result.message,true);
                window.location.href = result.redirect;
              }else{
                showMessage(result.message,false);
              }
              
              showLoader(false);
          },
          error: function(data)
          {
              showMessage(result.message,false);
              showLoader(false);
          }
      });
    }
  });
});

jQuery.validator.addMethod("passwordCheck",
  function(value, element, param) {
      if (this.optional(element)) {
          return true;
      } else if (!/[A-Z]/.test(value)) {
          return false;
      } else if (!/[a-z]/.test(value)) {
          return false;
      } else if (!/[0-9]/.test(value)) {
          return false;
      } else if (!/[\+\-\_\@\#\$\%\&\*\!]/.test(value)) {
          return false;
      }

      return true;
  },
  $('#validate_password_txt').val());

//Validate file image or not
/*$(document).on('change','input[type="file"]',function(){    
  var file = document.getElementById($(this).attr('id')).files[0];   
    if(file && (file['type'] == "image/jpeg" || file['type'] == "image/png" || file['type'] == "application/jpg" || file['type'] == "application/pdf")){          
      $(this).closest('form').find(':submit').attr('disabled',false);
      $(this).next('.errorImage').html('');
    }else{
      $(this).next('.errorImage').html('Please upload only .jpg, .jpeg, .svg, .png format').css('color','red');
      $(this).closest('form').find(':submit').attr('disabled',true);

    }
});*/


$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

function selectProfileImage(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#user_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


function fetchCollege(val){
  var currData = $(val).attr('id');
  var ids = currData.split("_");
  var currId = ids[1];

  $('#fkEedCol_'+currId).find('option').not(':first').remove();
  var cid = val.value;
  if(cid != ''){
    showLoader(true);
    $.ajax({
      url: base_url+'/employee/fetchCollege',
      type: 'POST',
      dataType:'json',
      cache: false,              
      data: {'cid':cid},
      success: function(result)
      {
        if(result.status){
          $.each(result.data, function(index, value) {
            $('#fkEedCol_'+currId).append($("<option></option>")
                    .attr("value",value.pkCol)
                    .text(value.col_CollegeName)); 
          });
        }else{
          toastr.error(result.message);
        }
        
        showLoader(false);
      },
      error: function(data)
      {
          toastr.error('Something went wrong');
          showLoader(false);
      }
    });

  }
}