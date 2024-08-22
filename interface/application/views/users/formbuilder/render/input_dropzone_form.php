<div class="row">
   <div class="col-12">
        <div class="card-box formBuilder-box">
          <div id="render-container" class="fields-form-render"></div>
        </div>
    </div>
</div>
<?php if(isset($uploads_json)){ ?>
<div class="row">
    <div class="col-12">
        <div id="" class="upload-form-render">

            <input type="hidden" id="id" name="<?php if(isset($id)){echo $id;} ?>">
            <div class="row">
              <?php
                if($uploads_json!=''){
                  $form_json=json_decode($uploads_json,true);
                  //print_r($form_json);
                  foreach ($form_json as $json_data) {
              ?>
              <?php if($json_data['type']=='header' && $json_data['className']=='sectionHeader'){ ?>
                <div class="col-lg-12 col-12">
                  <h2 class="mb-3 pb-2" style="font-size: 22px;border-bottom: solid 1px #ddd;"><?php echo $json_data['label'] ?></h2>
                </div>      
              <?php } ?>

              <?php if($json_data['type']=='file' && $json_data['className']=='dropify'){ ?>
              <div class="col-lg-4 col-12 mb-3">
                <div class="card file-uploads-box">
                  <div class="card-header"><?php echo $json_data['label'] ?> <?php if($json_data['required']>0){ echo "<span class='text-white'>*</span>";} ?></div>
                    <div class="card-box">                                      
                      <div class="custom-dropzone text-center align-items-center my-dropzone" id="<?php echo $json_data['name'] ?>">
                        <input type="hidden" class="dropzone_name" name="<?php echo $json_data['name'] ?>">
                        <div class="dz-default dz-message" data-dz-message>
                            <h3 class="mb-0"><i class="mdi mdi-cloud-upload"></i></h3>
                            <br><p>Drop here or click here to upload</p>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <?php } ?>

              <?php } } ?>
            </div>
          </div>
    </div>
</div>
<?php } ?>


<script type="text/javascript">
  function render_form(){
    var formInstance = $('#render-container').formRender({
      container: false,
      formData: <?php if($html_json!=''){echo $html_json;}else{echo "''";} ?>,
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

    $('.sectionHeader').parent().addClass('builder-section-box');
    
    Dropzone.autoDiscover = false;      
    $(".my-dropzone").dropzone({
      url: urljs+'<?php if(isset($uploads_url) && !empty($uploads_url)){ echo $uploads_url; } ?>',
      //paramName:'file',
      addRemoveLinks:true,
      dictRemoveFile:"Replace",
      maxFiles:2,
      resizeWidth: 1000, 
      resizeHeight: 1000,
      resizeMethod: 'contain',
      resizeQuality: 0.5,
      //dataType:"json",
      sending: function(file,xhr,formData){
        var docname=$(this.element).find("input.dropzone_name").attr("name");
        formData.append("docname",docname);

        //console.log('docname='+docname);
      },
      success: function(file,response){ 
        var obj=jQuery.parseJSON(response);
        if(obj.result=='success'){
          show_toast('success',obj.msg);
          $(this.element).find("input.dropzone_name").attr("value",obj.file_name);
          $(this.element).find('.dz-default.dz-message').hide();
          $(this.element).find("input.dropzone_name").after('<label class="status-label text-success d-block mb-2"><i class="fa fa-check"></i> Uploaded</label>');
          file.previewElement.classList.add("dz-success");  
        }else{
          show_toast('error',obj.msg);  
          file.previewElement.innerHTML = "";
          $(this.element).find("input.dropzone_name").attr("value",obj.file_name);
        }
        
      },
      error: function(file,response){
        var obj=jQuery.parseJSON(response);
        show_toast('error',obj.msg);
        file.previewElement.classList.add("dz-error");
        file.previewElement.innerHTML = "";
      },
      removedfile: function(file) {
        $(this.element).find('.dz-default.dz-message').show();
        $(this.element).find("label.status-label").remove();
        file.previewElement.innerHTML = "";
        $(this.element).find("input.dropzone_name").attr("value","");
      }

    });
    return formInstance;

}
</script>