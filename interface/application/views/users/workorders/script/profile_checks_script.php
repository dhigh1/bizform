<link rel="stylesheet" href="<?php echo base_url(); ?>ui/assets/plugins/jquery-ui/jquery-ui.css">
<script src="<?php echo base_url(); ?>ui/assets/plugins/jquery-ui/jquery-ui.js"></script>

<script src="<?php echo base_url() ?>ui/assets/plugins/dropzone/dropzone.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/custom_app/import/excel_progress.js"></script>

<!-- form builder plugin -->
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/form-builder.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/form-render.min.js"></script>

<!--pqSelect-->
<!-- <script src="<?php echo base_url(); ?>ui/assets/plugins/paramquery/pqTouch/pqtouch.min.js"></script> -->
<script src="<?php echo base_url(); ?>ui/assets/plugins/paramquery/pqgrid.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/paramquery/localize/pq-localize-en.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/paramquery/pqSelect/pqselect.min.js"></script>



<script type="text/javascript">
  var data_module = 'workorders';

  $(document).ready(function() {
    view_toggler();
    //$('.dataViewToggler').attr('disabled',true);
    ajax_modal('.workorderActivity', data_module + '/get_workorder_activity', 'Workorder Activity Log', 'large', '');
    ajax_get_reports('.getAllReport');
    //setTimeout(function(){
    getdatas();
    //},5000);
    do_refresh();
  });

  function do_refresh() {
    $('.refreshData').on('click', function() {
      $(this).hide();
      getdatas();
    });
  }

  function ajax_get_reports(button) {
    $(button).on('click', function() {
      var id = $(this).attr('data-id');
      var module_name = $(this).attr('data-module');
      var code = $(this).attr('data-code');
      var folder = $(this).attr('data-folder');
      ajaxloading('Please wait...');
      $.post(urljs + data_module + '/get_reports_download', {
        'id': id,
        'module_name': module_name,
        'code': code,
        'folder': folder
      }, function(data) {
        closeajax();
        if (data.status == 'success' && data.file_url != '') {
          window.open(urljs + data.file_url, 'Download');
        } else {
          swal(data.message);
        }
      }, 'json');
    })
  }

  function get_service_bulk_edit() {
    $('#get_service_edit').on('change', function() {
      var viewType = getUrlParameter('viewType');
      if (viewType == 'bulk_edit') {
        setURIParam('checkType', $(this).val());
        getdatas();
      }
    });
  }


  function getdatas() {
    var viewType = getUrlParameter('viewType');
    var id = $('#Tbl').attr('data-id');
    //console.log(id);
    $('#Tbl').html('<div class="div-loader alert alert-info text-left text-dark"><div class="spinner-border spinner-border-sm text-info" role="status"></div> <b>Loading the data...</b></div>');
    //ajaxloading('Loading...');
    $.post(urljs + data_module + '/get_profiles_list', {
      'id': id,
      'viewType': viewType
    }, function(datas) {
      //closeajax();
      //$('#Tbl').html('');
      if (datas.status == 'success') {
        $('.refreshData').show();
        $('#Tbl').html(datas.message);
        init_actions(viewType);
      } else {
        init_actions(viewType);
        // swal("Failed!", datas.message,'warning');
        $('#Tbl').html('<div class="alert alert-danger text-center p-1 small"><b>View Profile & Checks</b></br>' + datas.message + '</div>');
      }
    }, "json");
  }


  function init_actions(viewType) {
    $('[data-toggle="popover"]').each(function(t, e) {
      $(this).popover()
    });
    init_accordian();
    get_service_bulk_edit();

    if (viewType == 'buckets') {
      //get_profile_report();
      ajax_modal('.addProfile', data_module + '/add_profile', 'Add Profile', 'medium', save_profile);
      ajax_modal('.editProfile', data_module + '/edit_profile', 'Edit Profile', 'medium', save_profile);
      delete_ajax('.deleteProfile', data_module + '/delete_profile', 'Profile', render_delete_profile);
      ajax_get_reports('.getprofileReport');

      ajax_modal('.addProfileCheck', data_module + '/get_add_check', 'Add check to profile', 'large', save_check);
      ajax_modal('.editProfileCheck', data_module + '/get_edit_check', 'Edit check from profile', 'large', save_check);
      ajax_modal('.viewProfileCheck', data_module + '/get_check_view', 'View profile check', 'large', render_check_view);
      delete_ajax('.deleteProfileCheck', data_module + '/delete_check', 'Profile', render_delete_profile);

      ajax_modal('.profileActivity', data_module + '/get_profile_activity', 'Profile Activity Log', 'medium', '');

      ajax_modal('.editCheckStatus', data_module + '/get_check_status_update', 'Edit Check Status', 'medium', save_check_status);
      $('.addProfile').show();
    } else {
      $('.addProfile').hide();
    }
    ajax_modal('.importProfiles', data_module + '/get_profile_import', 'Import Profiles', 'large', save_profile_import);
  }

  function view_toggler() {
    var viewType = getUrlParameter('viewType');
    if (viewType == undefined || viewType == '') {
      viewType = 'buckets';
      setURIParam('viewType', viewType);
    }
    if (viewType != 'bulk_edit') {
      removeURIParam('checkType');
    }
    $('.dataViewToggler[data-type=' + viewType + ']').addClass('btn-dark');
    $('.dataViewToggler[data-type=' + viewType + ']').attr('disabled', true);

    $('.dataViewToggler').on('click', function(e) {
      e.preventDefault();
      var viewType = $(this).attr('data-type');
      var checkType = $('#get_service_edit').val();
      if (viewType == 'bulk_edit' && checkType == '') {
        swal('Failed', 'Please select the check type', 'warning');
      } else {
        if (viewType != 'bulk_edit') {
          removeURIParam('checkType');
        }
        if (viewType == 'bulk_edit') {
          setURIParam('checkType', checkType);
        }
        $('.dataViewToggler').removeAttr('disabled');
        $('.dataViewToggler').removeClass('btn-dark');
        //$('.dataViewToggler').attr('disabled',true);        
        $(this).addClass('btn-dark');
        $(this).attr('disabled', true);
        setURIParam('viewType', viewType);
        getdatas();
      }
    });
  }

  function save_profile_import() {
    $(".select2_check").select2({
      dropdownParent: $('#userModalView'),
      placeholder: "--select--",
      allowClear: false,
      formatNoMatches: function(term) {
        return '<div class="text-center">No checks found...</div>';
      }
    }).on('change', function() {
      $('.columnPreview').html('<div class="div-loader text-dark"><div class="spinner-border spinner-border-sm text-info" role="status"></div> Loading excel template...</div>');
      var services_id = $(this).val();
      var workorders_id = $('#importForm').find('[name=workorders_id]').val();
      $.post(urljs + data_module + '/get_service_template_column', {
        'workorders_id': workorders_id,
        'services_id': services_id
      }, function(data) {
        closeajax();
        if (data.status = 'success' && data.file_url != '') {
          $('.columnPreview').html('<a href="' + data.file_url + '" class="btn btn-info rounded-pill btn-sm mt-1" download><i class="fa fa-download"></i> Download Template</a>');
        } else {
          $('.columnPreview').html(data.message);
        }
      }, 'json');
    });
    init_excel_dropify();
    save_import(getdatas);
  }

  function get_profile_report() {
    $('.getprofileReport').on('click', function() {
      ajaxloading('Please wait...');
      var id = $(this).attr('data-id');
      $.post(urljs + data_module + '/get_profile_report', {
        'id': id
      }, function(data) {
        closeajax();
        if (data.status = 'success' && data.report_url != '') {
          window.location.href = urljs + data.report_url;
        } else {
          swal('Failed', data.message, 'warning');
        }
      }, 'json');
    });
  }

  function render_check_view() {
    init_accordian();
    save_check_status();
  }


  function save_profile() {
    var formName = '#myForm';
    var ajax_type = 'button';
    var ajax_text = 'Processing...';
    var url = data_module + '/save_profile';
    $(formName).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules: {},
      messages: {},
      submitHandler: function() {
        ajax_request(formName, url, ajax_type, ajax_text, render_save_data);
      }
    });
  }

  function render_save_data(returnData) {
    if (returnData.status == "success") {
      $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
      getdatas();
      show_toast('success', returnData.message);
    } else {
      failureResult('#myForm', returnData.message, false);
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

  function save_check() {
    var formInstance = render_form();
    var formName = '#myForm';
    var ajax_type = 'button';
    var ajax_text = 'Processing...';
    var url = data_module + '/save_check';
    $(formName).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules: {},
      messages: {},
      submitHandler: function() {
        var formdata = new FormData($(formName)[0]);
        var formBuilderData = JSON.stringify(formInstance.userData);
        formdata.append("input_json", formBuilderData);
        $["ajax"]({
          url: urljs + url,
          type: "POST",
          dataType: "json",
          data: formdata,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            button_load(formName, 'Processing...', '');
          },
          success: function(data) {
            //closeajax();
            end_button_load(formName, '');
            if (data.status == 'success') {
              $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
              getdatas();
              swal(data.message);
            } else {
              swal('Failed', data.message, 'error');
            }
          },
          error: function() {}
        })
      }
    });
  }

  function save_check_status() {
    var formName = '#myForm';
    var ajax_type = 'button';
    var ajax_text = 'Processing...';
    var url = data_module + '/save_check_status';
    $(formName).validate({
      errorClass: 'error',
      validClass: 'valid',
      rules: {},
      messages: {},
      submitHandler: function() {
        ajax_request(formName, url, ajax_type, ajax_text, render_check_status);
      }
    });
  }

  function render_check_status(returnData) {
    if (returnData.status == "success") {
      $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
      getdatas();
      swal(returnData.message);
    } else {
      failureResult('#myForm', returnData.message, false);
    }
  }
</script>