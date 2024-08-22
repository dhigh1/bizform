<script src="<?php echo base_url(); ?>ui/assets/plugins/custom_app/import/excel_progress.js"></script>

<script type="text/javascript">
  
  var data_module='responses';
  $(document).ready(function() {
  get_add_forms_select2();
  assignValueToFilter();
  getdatas();
  ajax_modal('.addData',data_module+'/add','Create Customer','large',save_data);
  delete_ajax('.deleteForm', data_module + '/delete_form', 'Form', render_delete_profile);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
    ajax_modal('.editData',data_module+'/add','Edit Customer','large',save_data);
    delete_data(data_module,'Customer','name','');
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
  console.log(returnData)
  if(returnData.status == "success"){
    $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
    show_toast('success',returnData.message);
    location.href = returnData.url;
    // getdatas();
  }else{
    failureResult('#myForm',returnData.message,false);
  }
}

// alert(data_module)
ajax_modal('.publish',data_module+'/publish_view','Add Forms','large', save_data);


</script>