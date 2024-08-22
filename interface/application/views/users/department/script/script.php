<script type="text/javascript">
var data_module='department';

$(document).ready(function() {
  ajax_modal('.addData',data_module+'/add','Add Department','medium',save_data);
  ajax_modal('.editData',data_module+'/edit','Edit Department','medium',save_data);
  delete_data(data_module,'Department','name',render_delete_data);
});


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
    swal_alert('success',returnData.message,'Success','reload','');
  }else{
    failureResult('#myForm',returnData.message,false);
  }
}

function render_delete_data(returnData){
  toastr.clear();
  if(returnData.status == "success"){
    swal_alert('success',returnData.message,'Success','reload','');
  }else{
    swal_alert('warning',returnData.message,'Success','','');
  }
}


</script>