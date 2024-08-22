<script type="text/javascript">

var data_module='workorders';

$(document).ready(function() {
  assignValueToFilter();
  getdatas();
  ajax_modal('.addData',data_module+'/add','Create Workorder','medium',save_data);
});

function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
}

function renderfilter(datas) {
  if(datas.status=="success"){
    $('#Tbl').html(datas.message);
    filterdata();
    btn_url_load();
    get_all_report();
    ajax_modal('.editData',data_module+'/edit','Edit Workorder','medium',save_data);
    delete_data(data_module,'Workorder','code','');
    ajax_modal('.workorderActivity',data_module+'/get_workorder_activity','Workorder Activity Log','large','');
  }else{
    show_toast('error',datas.message);
  }
}

function save_data(){
  get_customer_select2();
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
    getdatas();
    $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');    
    swal_alert('success',returnData.message,'Success','','');
  }else{
    failureResult('#myForm',returnData.message,false);
  }
}

function get_all_report(){
  $('.getAllReport').on('click',function(){
    ajaxloading('Please wait...');
    var id=$(this).attr('data-id');
    $.post(urljs+data_module+'/get_all_reports',{'id':id},function(data){
      closeajax();
      if(data.status='success' && data.report_url!=''){
        window.location.href=urljs+data.report_url;
      }else{
        swal('Failed',data.message,'warning');
      }
    },'json');
  });
}

</script>