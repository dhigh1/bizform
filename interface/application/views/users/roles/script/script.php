<script type="text/javascript">

var data_module='roles';
$(document).ready(function() {
  assignValueToFilter();
  getdatas();
  ajax_modal('.addData',data_module+'/add','Create Role','medium',save_data);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
    ajax_modal('.editData',data_module+'/add','Edit Role','medium',save_data);
    ajax_modal('.getPermission',data_module+'/manage_permission','Manage Role Permissions','extra-large',save_permissions);
    delete_data(data_module,'Role','name','');
  }else{
    show_toast('error',datas.message);
  }
  
}

function save_data(){
  get_org_branch_select2();
  var formName='#myForm';
  var ajax_type='button';
  var ajax_text='Processing...';
  var url=data_module+'/save_data';
   $(formName).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules:{
      },
      messages:{
      },
      submitHandler: function(){
        ajax_request(formName,url,ajax_type,ajax_text,render_save_data);
      }
  });
}


function render_save_data(returnData){
  if(returnData.status == "success"){
    $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
    show_toast('success',returnData.message);
    getdatas();
  }else{
    failureResult('#myForm',returnData.message,false);
  }
}

function save_permissions(){
  init_accordian();
  var formName='#permissionForm';
  var ajax_type='button';
  var ajax_text='Processing...';
  var url=data_module+'/save_permissions';
   $(formName).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules:{
      },
      messages:{
      },
      submitHandler: function(){
        ajax_request(formName,url,ajax_type,ajax_text,render_save_permission);
      }
  });
}

function render_save_permission(returnData){
  if(returnData.status == "success"){
    $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
    swal_alert('success',returnData.message,'Success','','');
  }else{
    show_toast('error',returnData.message);
  }
}

</script>