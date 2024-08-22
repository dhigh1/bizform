<script type="text/javascript">
  var data_module = 'organization';
  $(document).ready(function () {
    // get_sm_data();
    save_data();
    save_sm();
    save_picture();
    save_favicon();
  });

  function get_sm_data() {
    var formName = 'smForm';
    var apiUrl = data_module + '/custom_fields';
    var method = 'GET';
    var data_fields = { 'id': 1, 'search': 'sm_links' };
    var ajax_type = 'ajax';
    var ajax_text = 'Loading data...';
    var appendElement = '.sm_links';
    api_get_request(formName, apiUrl, method, data_fields, ajax_type, ajax_text, appendElement);
  }

  function save_data() {
    var form = '#customForm';
    var url = data_module + "/save_data";
    var ajax_type = "button";
    var ajax_text = "Processing...";
    $(form).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules: {
        name: { required: true },
        address: { required: true },
      },
      messages: {

      },
      submitHandler: function () {
        ajax_request(form, url, ajax_type, ajax_text, renderdata);
      }
    });
  }

  function renderdata(returnData) {
    if (returnData.status == "success") {
      swal_alert('success', returnData.message, 'Success', 'reload', '');
    } else {
      failureResult('#customForm', returnData.message, false);
    }
  }


  function save_sm() {
    var form = '#smForm';
    var url = "utils/update_json_data";
    var ajax_type = "button";
    var ajax_text = "Processing...";

    $(form).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules: {
      },
      messages: {

      },
      submitHandler: function () {
        $(form).find('.div_res').html('');
        var id = $(form).find('[name=id]').val();
        var data_fields = createJsonArray('.jsonElements');
        if (ajax_type == 'button') {
          button_load(form, ajax_text, '');
        } else {
          ajaxloading(ajax_text);
        }
        $.post(urljs + url, { 'id': id, 'data_fields': data_fields, 'data_type': 'sm_links', 'module': "organization" }, function (returnData) {
          if (ajax_type == 'button') {
            end_button_load(form, '');
          } else {
            closeajax();
          }
          if (returnData.status == "success") {
            swal_alert('success', returnData.message, 'Success', 'reload', '');
          } else {
            failureResult(form, returnData.message, false);
          }
        }, "json");
      }
    });
  }

  function save_picture() {
    var form = '#pictureForm';
    var url = data_module + "/save_picture";
    var ajax_type = "button";
    var ajax_text = "Processing...";

    document.getElementById("imageUpload").onchange = function () {
      $(this).attr('readonly', true);
      $('#imagePreview').addClass('ajax-file-loader');
      ajax_request(form, url, ajax_type, ajax_text, render_pic_data);
    };
  }

  function render_pic_data(returnData) {
    $('#imagePreview').removeClass('ajax-file-loader');
    $('#imageUpload').removeAttr('readonly');
    if (returnData.status == "success") {
      swal_alert('success', returnData.message, 'Success', 'reload', '');
    } else {
      swal_alert('warning', returnData.message, 'Error', '', '');
    }
  }


  function save_favicon() {
    var form = '#faviconForm';
    var url = data_module + "/save_favicon";
    var ajax_type = "button";
    var ajax_text = "Processing...";

    document.getElementById("faviconUpload").onchange = function () {
      $(this).attr('readonly', true);
      $('#faviconPreview').addClass('ajax-file-loader');
      ajax_request(form, url, ajax_type, ajax_text, render_favicon_data);
    };
  }

  
function render_favicon_data(returnData){
  $('#faviconPreview').removeClass('ajax-file-loader');
  $('#faviconUpload').removeAttr('readonly');
  if(returnData.status == "success"){
    swal_alert('success',returnData.message,'Success','reload','');
  }else{
    swal_alert('warning',returnData.message,'Error','','');
  }
}

</script>