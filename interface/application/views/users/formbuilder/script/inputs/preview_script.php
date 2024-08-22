<script src="<?php echo base_url() ?>ui/assets/plugins/dropzone/dropzone.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/form-render.min.js"></script>
<script>
  jQuery(function($) {
    $('#render-container').formRender({
      container: false,
      formData: <?php if ($data_list['html_json'] != '') {
                  echo $data_list['html_json'];
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

    $('.sectionHeader').parent().addClass('builder-section-box');

    $(".rendered-form").addClass('row');
    $(".rendered-form :input").each((i, e) => {
      console.log($(e).attr('input_width'))
      $(e).parent().addClass('col-lg-' + $(e).attr('input_width'))
    })
    $(".dropify").dropify();
  });
</script>