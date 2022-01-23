$(function() {
  var baseUrl = window.location.origin;
  var old_img = [];
  var newFileList = [];

  showLoader(false);

  $("#upload_profile").on('change', function () { 
    if( document.getElementById("upload_profile").files.length == 0 ){
        $('#user_img').attr('src', $('#img_tmp').val());
    }
      selectProfileImage(this);
  });

  $("[name='sel_exists_employee']").on('change', function () { 
    if( $(this).val() == 'Yes' ){
        $('.exists_employee').show();
        $('.add_new_principal').hide();
    }else{
        $("#principal_sel").val('');
        $('.add_new_principal').show();
        $('.exists_employee').hide();
    }
  });

  $("#upload_link").on('click', function(e){
      e.preventDefault();
      $("#school_imgs:hidden").trigger('click');
  });

  $("#school_imgs").on("change", function(e) {
      let files = e.target.files,
      filesLength = files.length;
  
      newFileList = Array.from(e.target.files);
      var len = newFileList.length;
      if(len==0){
          document.getElementById('school_imgs').value="";
            $('.img_show_div .sch_imgs').remove();
      }

      for(var j=0; j<len; j++) {
          var src = "";
          var name = newFileList[j].name;
          var mime_type = newFileList[j].type.split("/");
          if(mime_type[0] == "image") {
            src = URL.createObjectURL(newFileList[j]);
          } else if(mime_type[0] == "video") {
            src = 'icons/video.png';
          } else {
            src = 'icons/file.png';
          }

          $('.img_show_div').append('<div class="col-md-2 sch_imgs" id="sch_img_'+ j +'"><img title="'+name+'" src="'+src+'"><span class="close_spn" rid="'+j+'"><img src="'+baseUrl+'/public/images/ic_delete.png"></span></div>')
      }

  });

  $(document).on('click','.close_spn', function() {
      var id = $(this).attr('rid');
      var oid = $(this).attr('oid');
      if(oid != ''){
        old_img.push(oid);
      }
      //newFileList.splice(id,1);
      delete newFileList[id];

      $('#sch_img_'+id).remove();
      $('#sch_img_'+oid).remove();
      if($('.img_show_div .sch_imgs').length == 0){
          console.log('empty');
           document.getElementById('school_imgs').value="";
      }
      console.log('files_delete_after',newFileList);
  });


  $('#change_pass').on('hidden.bs.modal', function () {
    var validator = $( "form[name='change-password-form']" ).validate();
    validator.resetForm();
    $("form").trigger("reset");
  });

  $('.datepicker').datepicker({format: "mm/dd/yyyy",autoclose: true, endDate: '+0d',});
  $('.start_date').datepicker({format: "mm/dd/yyyy",autoclose: true});

  $("form[name='school-basic']").validate({
    errorClass: "error_msg",
     rules: {
        sch_SchoolEmail:{
          required:true,
          email: true,
          emailfull: true
        },
        sch_SchoolId:{
          required:true,
          minlength:5,
          maxlength:30
        },
        sch_Founder:{
          required:true,
          minlength:5,
          maxlength:30
        },
        sch_PhoneNumber:{
          required:true,
          minlength:9,
          maxlength:12
        },
        fkSchPof:{
          required:true,
        },
        fkSchOty:{
          required:true,
        },
        sch_FoundingDate:{
          required:true,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        $.ajax({
            url: '/employee/mySchool',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
              if(result.status){
                toastr.success(result.message);
                $('a[data-slug="employee/mySchool"]').trigger("click");
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

  $("form[name='school-about']").validate({
    errorClass: "error_msg",
     rules: {
        // fkSchOty:{
        //   required:true,
        // },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        formData.append("old_img", old_img);
        for (var i = 0; i < newFileList.length; i++) {
          formData.append('sch_images[]', newFileList[i]);
        }
        $.ajax({
          url: '/employee/mySchool',
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,              
          data: formData,
          success: function(result)
          {
            if(result.status){
              toastr.success(result.message);
              $('a[data-slug="employee/mySchool"]').trigger("click");
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

  $("form[name='school_principal']").validate({
    errorClass: "error_msg",
     rules: {
        principal_email:{
          required:true,
          email: true,
          emailfull: true
        },
        principal_name:{
          required:true,
          minlength: 3,
          maxlength: 40
        },
        start_date:{
          required:true,
        },
        principal_sel:{
          required:true,
        },
     },
      submitHandler: function(form, event) {
        event.preventDefault();
        showLoader(true);
        var formData = new FormData($(form)[0]);
        $.ajax({
            url: '/employee/mySchool',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
              if(result.status){
                toastr.success(result.message);
                $('a[data-slug="employee/mySchool"]').trigger("click");
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
