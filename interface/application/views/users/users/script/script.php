<script src="<?php echo base_url() ?>ui/assets/plugins/dropify/js/dropify.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/custom_app/import/excel_progress.js"></script>
<script type="text/javascript">

var data_module='users';
$(document).ready(function() {
  assignValueToFilter();
  getdatas();
  ajax_modal('.addData',data_module+'/add','Create User','large',save_data);
  ajax_import('.importData',data_module,'Import Users','medium','');
  ajax_export('.exportData',data_module);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
    ajax_modal('.editData',data_module+'/add','Edit User','large',save_data);
    delete_data(data_module,'User','login_id','');
  }else{
    show_toast('error',datas.message);
  }
  
}

function save_data(){
  initHideShowPassword();
  get_user_role_select2();
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
      errorPlacement: function ( error, element ) {
        if(element.parent().hasClass('input-group')){
          error.insertAfter( element.parent() );
        }else{
            error.insertAfter( element );
        }
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



</script>