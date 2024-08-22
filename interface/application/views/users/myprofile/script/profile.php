<script type="text/javascript">

var data_module='myprofile';
$(document).ready(function() {
  save_data();
  save_picture();
});


function save_data(){
  var form = '#profileForm';
  var url = data_module+"/save_data";
  var ajax_type="button";
  var ajax_text = "Processing...";
  $(form).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules:{
        // login_id: {required: true, minlength: 3, maxlength: 50}
        first_name: {required: true, minlength: 3, maxlength: 50},
        last_name: {required: true, minlength: 3, maxlength: 50},
        email: {required: true, email: true, minlength: 3, maxlength: 50},
        mobile: {required: true, minlength: 10, maxlength: 10}
      },
      messages:{
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
    failureResult('#profileForm',returnData.message,false);
  }
}

function save_picture(){
  var form = '#pictureForm';
  var url = data_module+"/save_picture";
  var ajax_type="button";
  var ajax_text = "Processing...";

  document.getElementById("imageUpload").onchange = function() {
      $(this).attr('readonly',true);
      $('#imagePreview').addClass('ajax-file-loader');
      ajax_request(form,url,ajax_type,ajax_text,render_pic_data);
  };
}

function render_pic_data(returnData){
  $('#imagePreview').removeClass('ajax-file-loader');
  $('#imageUpload').removeAttr('readonly');
  if(returnData.status == "success"){
    swal_alert('success',returnData.message,'Success','reload','');
  }else{
    swal_alert('warning',returnData.message,'Error','','');
  }
}

</script>