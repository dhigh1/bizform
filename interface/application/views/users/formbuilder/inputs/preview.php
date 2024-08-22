<script type="text/javascript">
  $(function() {
    var header = $(".formBuilder-box");

    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      if (scroll >= 380) {
        header.addClass("scrolled");
      } else {
        header.removeClass("scrolled");
      }
    });

  });
</script>
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box">
      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href='<?php echo base_url() . 'formbuilder/inputs?id=' . $data_list['id'] . '&manage=html' ?>'>Forms</a></li>
          <li class="breadcrumb-item active">Preview</li>
        </ol>
      </div>
      <h4 class="page-title">Form Preview</h4>
    </div>
  </div>
</div>
<!-- end page title -->

<div class="row">
  <div class="col-12">
    <div class="alert alert-success text-center">
      Preview of input data template
      <b><?php echo $data_list['name'] ?></b>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card-box formBuilder-box">
      <div class="row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='<?php echo base_url() . 'formbuilder/inputs?id=' . $data_list['id'] . '&manage=html' ?>'"><i class="mdi mdi-pencil"></i> Edit Fields</button>
        </div>
      </div>
      <div id="render-container" class="fields-form-render"></div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div id="render-container" class="upload-form-render">
      <div class="row">
        <?php
        if (isset($data_list['uploads_json']) && $data_list['uploads_json'] != '') {
          $form_json = json_decode($data_list['uploads_json'], true);
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
                  <div class="card-header"><?php echo $json_data['label'] ?> <?php if ($json_data['required'] > 0) {
                                                                                echo "<span class='text-white'>*</span>";
                                                                              } ?></div>
                  <div class="card-box">
                    <div class="custom-dropzone text-center align-items-center my-dropzone" id="<?php echo $json_data['name'] ?>">
                      <div class="dz-default dz-message" data-dz-message>
                        <h3 class="mb-0"><i class="mdi mdi-cloud-upload"></i></h3>
                        <br>
                        <p>Drop here or click here to upload</p>
                      </div>
                    </div>
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