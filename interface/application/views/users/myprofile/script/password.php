<script type="text/javascript">

var data_module='myprofile';
$(document).ready(function() {
  save_data();
});


function save_data(){
  var form = '#myForm';
  var url = data_module+"/save_password";
  var ajax_type="button";
  var ajax_text = "Processing...";
  $(form).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules:{
        password:{required:true},
        new_password:{required:true},
        confirm_password:{required:true,equalTo:"[name=new_password]"}
      },
      messages:{
        confirm_password:{equalTo:"New password mismatch"}
      },
      submitHandler: function(){
        ajax_request(form,url,ajax_type,ajax_text,renderdata);
      }
  });
  
}

function renderdata(returnData){
  if(returnData.status == "success"){
    swal_alert('success',returnData.message,'Success','reload','');
  }else{
    failureResult('#myForm',returnData.message,false);
  }
}


</script>