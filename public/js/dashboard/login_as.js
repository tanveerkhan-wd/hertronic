/**
* Login As
*
* This file is used for admin JS
* 
* @package    Laravel
* @subpackage JS
* @since      1.0
*/
$(function() {

  $("#role_type").on('change', function () {
    $('#login_as_listing').DataTable().ajax.reload()
  });
  

});

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


var imagepath='http://gaudeamus.hertronic.com/public/images/';
  $('#login_as_listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    } ).DataTable({
        "columnDefs": [{
          "targets": 6,
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
            "url": base_url+"/admin/getLoginAs",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search_login_as').val();
              d.role = $('#role_type').val();
              // d.country = $('#country_filter').val();
            }
        },
        columns:[
            { "data": "index",className: "text-center"},
            // { "data": "adm_Uid" },
            { "data": "adm_Uid",
              render: function (data, type, admin) {
                if(admin.adm_Uid){
                  return admin.adm_Uid;
                }else{
                  return '-';
                }
              }
            },
            { "data": "adm_Name",
              render: function (data, type, admin) {
                if(admin.adm_Name){
                  return admin.adm_Name;
                }else{
                  return admin.emp_EmployeeName;
                }
              }
            },
            { "data": "type",
              render: function (data, type, admin) {
                if(admin.type == 'MinistryAdmin'){
                  return $("#msa_txt").val();
                }else if(admin.type == 'SchoolCoordinator'){
                  return $("#school_coordinator_txt").val();
                }else if(admin.type == 'Teacher'){
                  return $("#teacher_txt").val();
                }else{
                  return admin.type
                }
              }
            },
            { "data": "email" },
            { "data": "adm_Status", className: "status",  sortable:!1,
              render: function (data, type, admin) {
                if(admin.adm_Status=='Active'){
                  return'<span></span>'+$("#active_txt").val()+'';
                }else{
                  return'<span></span>'+$("#inactive_txt").val()+'';
                }
              }
            },
            { "data": "adm_Name", sortable:!1,
              render: function (data, type, admin) {
                var btn_txt;
                if(admin.type == 'MinistryAdmin'){
                  btn_txt = 'MSA';
                }else if(admin.type == 'SchoolCoordinator'){
                  btn_txt = 'SC';
                }else if(admin.type == 'Teacher'){
                  btn_txt = $("#teacher_txt").val();
                }else{
                  btn_txt = admin.type
                }

                return'<button class="login_as_ajax_request no_sidebar_active btn btn-success" data-aid="'+admin.id+'" data-atype="'+admin.type+'">'+btn_txt+'</button>'
              }
            },
      ],

  });

  $('#delete_prompt').on('hidden.bs.modal', function () {
    $("#did").val('');
  })

  $("#search_login_as").on('keyup', function () {
    //if($(this).val() != ''){
        $('#login_as_listing').DataTable().ajax.reload()
   // }
  });

function triggerDelete(cid){
   $('#did').val(cid);   
   $( ".show_delete_modal" ).click();
}

$(document).on('click', '.login_as_redir',function () {
  window.location.href = $(this).attr('data-redir');
  // $('li a[data-slug="admin/educationPlans"]').trigger("click");
  // $('html, body').css({
  //     overflow: 'auto',
  //     height: 'auto'
  // });
});

$(document).on('click', '.login_as_ajax_request',function () {
  showLoader(true);
  var id = $(this).attr('data-aid');
  var type = $(this).attr('data-atype');

  $.ajax({
    url: base_url+'/admin/authLoginAs',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'id':id, 'type':type},
    success: function(result)
    {
        if(result.status){
          $(result.data).insertBefore("#sidebar");
          window.scrollTo(0, 0);
          $('body').addClass('no_scroll');
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
});

