<script type="text/javascript">

var data_module='modules';
$(document).ready(function() {
  assignValueToFilter();
  getdatas();
  ajax_modal('.addData',data_module+'/add','Create Module','medium',save_data);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
    ajax_modal('.editData',data_module+'/add','Edit Module','medium',save_data);
    delete_data(data_module,'Module','name','');
  }else{
    show_toast('error',datas.message);
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