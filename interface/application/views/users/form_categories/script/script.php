<!-- <script src="<?php //echo base_url() ?>ui/assets/plugins/dropify/js/dropify.min.js"></script> -->
<script src="<?php echo base_url(); ?>ui/assets/plugins/custom_app/import/excel_progress.js"></script>

<script type="text/javascript">
  
  var data_module='form_categories';
  $(document).ready(function() {
  assignValueToFilter();
  getdatas();
  ajax_modal('.addCategory',data_module+'/add', 'Create Forms', 'large', save_data);
  // ajax_modal('.editForm','formbuilder/edit', 'Edit Form', 'large', save_data);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
    ajax_modal('.editData',data_module+'/add','Edit Category','medium',save_data);
    // delete_data(data_module,'Form Categories','name','');
    delete_data(data_module,'Form Category','name','');
  }else{
    show_toast('error',datas.message);
  }
}


function render_delete_profile(returnData) {
    if (returnData.status == "success") {
      getdatas();
      show_toast('success', returnData.message);
    } else {
      failureResult('#myForm', returnData.message, false);
    }
  }

function save_data(){
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