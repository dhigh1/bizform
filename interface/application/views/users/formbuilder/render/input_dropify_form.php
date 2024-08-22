<div class="row">
  <div class="col-12">
    <div class="card-box formBuilder-box">
      <div id="render-container" class="fields-form-render"></div>

    </div>
  </div>
</div>
<?php if (isset($uploads_json)) { ?>
  <div class="row">
    <div class="col-12">
      <div id="" class="upload-form-render">
        <input type="hidden" id="profile_id" name="<?php if (isset($profile_id)) { echo $profile_id; } ?>">
        <input type="hidden" id="check_id" name="<?php if (isset($check_id)) { echo $check_id; } ?>">
        <div class="row">
          <?php
          if ($uploads_json != '') {
            $form_json = json_decode($uploads_json, true);
            //print_r($form_json);
            foreach ($form_json as $json_data) {
          ?>
              <?php if ($json_data['type'] == 'header' && $json_data['className'] == 'sectionHeader') { ?>
                <div class="col-lg-12 col-12">
                  <h2 class="mb-3 pb-2" style="font-size: 22px;border-bottom: solid 1px #ddd;"><?php echo $json_data['label'] ?></h2>
                </div>
              <?php } ?>

              <?php if ($json_data['type'] == 'file' && $json_data['className'] == 'dropify') { ?>
                <div class="col-lg-4 col-12 mb-3">
                  <div class="card file-uploads-box">
                    <div class="card-header"><?php echo $json_data['label'] ?> <?php if ($json_data['required'] > 0) { echo "<span class='text-white'>*</span>"; } ?></div>
                    <div class="card-box">
                      <?php
                      if (!empty($input_uploads)) {
                        foreach ($input_uploads as $uploads) {
                          if ($json_data['name'] == $uploads['file_input_name']) {
                      ?>
                            <input type="file" id="input-file-now" name="<?php echo $json_data['name'] ?>" class="dropify" data-height="150" data-show-remove="true" data-default-file="<?php echo base_url() . $uploads['file_path'] . $uploads['file_name'] ?>" data-allowed-file-extensions="<?php if (isset($json_data['allowedTypes'])) { echo str_replace(",", " ", $json_data['allowedTypes']); } ?>" />
                            <?php if ($uploads['is_valid'] == 0) { ?>
                              <p class="alert alert-danger ">Invalid</p>
                            <?php } ?>
                        <?php }
                        } ?>
                      <?php } else { ?>
                        <input type="file" id="input-file-now" name="<?php echo $json_data['name'] ?>" class="dropify" data-height="150" data-show-remove="true" data-default-file="" data-allowed-file-extensions="<?php if (isset($json_data['allowedTypes'])) {echo str_replace(",", " ", $json_data['allowedTypes']); } ?>" />
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php } ?>

          <?php }
          } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>


<?php
$states = $this->curl->execute("state", "GET", array('country_id' => 101));
$states_data = array();
foreach ($states['data_list'] as $rows) {
  $states_data[] = array(
    'id' => $rows['name'],
    'text' => $rows['name'],
  );
}
$states_data = json_encode($states_data, true);
?>

<script type="text/javascript">
  function render_form() {
    var formInstance = $('#render-container').formRender({
      container: false,
      formData: <?php if ($html_json != '') {
                  echo $html_json;
                } else {
                  echo "''";
                } ?>,
      dataType: 'json',
      label: {
        formRendered: 'Form Rendered',
        noFormData: 'No form data.',
        other: 'Other',
        selectColor: 'Select Color'
      },
      render: true,
      notify: {
        error: function(message) {
          return console.error(message);
        },
        success: function(message) {
          return console.log(message);
        },
        warning: function(message) {
          return console.warn(message);
        }
      }
    });

    $('input.form-control').each(function() {
      $attr = $(this).attr('is_valid');
      if ($attr != '' && $attr == 'false') {
        $(this).css('background', '#dfb4b4');
      }
    });

    $('textarea.form-control').each(function() {
      $attr = $(this).attr('is_valid');
      if ($attr != '' && $attr == 'false') {
        $(this).css('background', '#dfb4b4');
      }
    });

    $('select.form-control').each(function() {
      $attr = $(this).attr('is_valid');
      if ($attr != '' && $attr == 'false') {
        $(this).css('background', '#dfb4b4');
      }
    });

    // $('.sectionHeader').parent().addClass('builder-section-box');

    init_dropbox();
    input_datepicker();
    get_check_state_select2();
    return formInstance;
  }




  function init_dropbox() {
    // Basic
    var drEvent = $('.dropify').dropify();

    <?php if (isset($delete_url) && !empty($delete_url)) { ?>
      drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
      });

      drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
      });
    <?php } ?>

    drEvent.on('dropify.errors', function(event, element) {
      //$('button[type=submit]').disabled();
    });
  }

  function input_datepicker() {

    $('.mydatepicker').datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      yearRange: "1930:2030"
    });
  }

  function get_check_state_select2() {
    $(".select2_state").select2({
      dropdownParent: $('#userModalView'),
      placeholder: "--select--",
      allowClear: true,
      data: <?php print_r($states_data) ?>,
      formatNoMatches: function(term) {
        return '<div class="text-center">No state found...</div>';
      },
    }).on('change', function(e) {
      var id = $(this).val();
      get_check_city_select2(id);
    });
    $(".select2_city").select2({
      dropdownParent: $('#userModalView'),
      placeholder: "--select--",
      allowClear: true,
      formatNoMatches: function(term) {
        return '<div class="text-center">No city found...</div>';
      },
    });

  }


  function get_check_city_select2(id) {
    $("#city").select2("val", "");
    $("#s2id_city").find('.select2-chosen').html('<option>Loading cities</option>');
    $.post(urljs + "utils/get_city_by_state_name", {
      'id': id
    }, function(datas) {
      //closeajax();
      if (datas.status == "success") {
        var tableitems = '';
        var data = datas.data_list;
        if (data.length > 0) {
          for (var i = 0; i < data.length; i++) {
            tableitems += '<option value="' + data[i].name + '">' + data[i].name + '</option>';
          }
          $("#s2id_city").find('.select2-chosen').html('--select city--');
          $("#city").html('');
          $("#city").append('<option></option>');
          $("#city").append(tableitems);
        } else {
          $("#s2id_city").find('.select2-chosen').html('No city found...');
          $("#city").html('');
          $("#city").append('<option></option>');
        }
      } else {
        $("#s2id_city").find('.select2-chosen').html('No city found...');
        $("#city").html('');
        $("#city").append('<option></option>');
      }

    }, "json");
  }

  // if(("#save_check").length>0){
  //   save_check();
  // }


  // function save_check(){
  // 	$('#export_form').validate({
  // 		errorClass: 'error',
  // 		validClass: 'valid',
  // 		rules: {
  // 		},
  // 		messages:{
  // 		},	
  // 		submitHandler: function(){
  // 			if($("[name=from]").val() == "" || $("[name=to]").val() == ""){
  //         alert("Select the range")
  // 			}else{
  //         ajaxloading('Loading...');
  // 				var admin=$('#export_form').serializeArray();
  // 				$.post(urljs+"vendor/checks/download_cases",admin,function(data){
  // 					if(data.result=='success' && data.url!=''){
  //             closeajax();
  //             $(".bootbox.reportsModalView").find('.bootbox-close-button').trigger('click');
  //             // swal_alert('success', data.message, 'Success', '', '');
  //             window.location.href = data.url;
  // 					}else{
  //             $(".bootbox.reportsModalView").find('.bootbox-close-button').trigger('click');
  // 						// failureResult('export_form',data.message);
  //             closeajax();
  //             swal_alert('error', data.message, 'Fail', '', '')
  // 					}					
  // 				},"json");
  // 			}

  // 		}
  // 	});
  // }
</script>