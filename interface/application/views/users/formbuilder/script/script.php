<!-- <script src="<?php //echo base_url() ?>ui/assets/plugins/dropify/js/dropify.min.js"></script> -->
<script src="<?php echo base_url(); ?>ui/assets/plugins/custom_app/import/excel_progress.js"></script>

<script type="text/javascript">

  var data_module = 'formbuilder';
  $(document).ready(function () {
    assignValueToFilter();
    getdatas();
    ajax_modal('.addTemplate', 'formbuilder/add', 'Create Forms', 'large', save_data);

    // ajax_modal('.editForm','formbuilder/edit', 'Edit Form', 'large', save_data);
  });

  function getdatas(page) {
    ajaxloading('Loading...');
    ajax_filter(data_module, page, renderfilter)
  }

  function renderfilter(datas) {
    if (datas.status == "success") {
      $('#Tbl').html(datas.message);
      filterdata();
      ajax_modal('.editForm', data_module + '/edit', 'Edit Form', 'large', save_data);
      delete_data(data_module, 'Customer', 'name', '');
    } else {
      show_toast('error', datas.message);
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

  function save_data() {
    const category_id = GetURLParameter('category_id');
    if (category_id != null) {
      $(".select2_form_categories").select2('enable', false);
      $(".select2_form_categories").select2('val', category_id);
    }
    var formName = '#myForm';
    var ajax_type = 'button';
    var ajax_text = 'Processing...';
    var url = data_module + '/save_data';
    $(formName).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules: {
        form_code: { required: true, minlength: 3, maxlength: 100 },
        name: { required: true, minlength: 3, maxlength: 100 },
        description: { minlength: 3, maxlength: 200 }
      },
      messages: {
      },
      errorPlacement: function (error, element) {
        if (element.parent().hasClass('input-group')) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function () {
        // ajax_request(formName,url,ajax_type,ajax_text,render_save_data);
        $(formName).find('.div_res').html('');
        var formdata = new FormData($(formName)[0]);
        if(category_id){
          formdata.append('category_id', category_id)
        }
        $["ajax"]({
          url: urljs + url,
          type: "POST",
          dataType: "json",
          data: formdata,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
            button_load(myForm, 'Processing...', '');
          },
          success: function (data) {
            render_save_data(data);
            // end_button_load(myForm, '');
            // if (data.status == 'success' && data.urlredirect != '') {
            //   successResult(myForm, data.message, false);
            //   $(myForm).find('button[type=submit]').attr('disabled', 'true');
            //   window.location = data.urlredirect;
            // } else {
            //   if (data.token) {
            //     $(".token").val(data.token);
            //   }
            //   failureResult(myForm, data.message, false);
            // }
          },
          error: function () { }
        })
      }
    });
  }


  function render_save_data(returnData) {
    if (returnData.status == "success") {
      $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
      show_toast('success', returnData.message);
      if (returnData.url != '' && returnData.saveType == 'add') {
        window.location = returnData.url;
      } else {
        getdatas();
      }
    } else {
      failureResult('#myForm', returnData.message, false);
    }
  }


</script>