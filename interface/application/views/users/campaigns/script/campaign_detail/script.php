<script src="<?php echo base_url() ?>ui/assets/plugins/dropzone/dropzone.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/form-render.min.js"></script>
<script>
  jQuery(function($) {

    // ajax_modal('.addTemplate', 'campaigns/add_campaign_template', 'Add Template', 'small', save_data);

    $('.sectionHeader').parent().addClass('builder-section-box');
    $(".dropify").dropify();
    // alert("HIE")
    $(".removeTemplate").on('click', function(){
      var id = $(this).attr('data-id');
      var c_id = $(this).attr('data-cid');
        swal({
          title: 'Are you sure ?', 
          text: 'This is irreversible', 
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, I am sure!',
          cancelButtonText: "No, cancel it!"
        }).then(function(isConfirm){
          if(isConfirm.value){
            $.post('delete_template', {id: id, c_id: c_id}, function(data){
              if(data.status=='success'){
                swal_alert('success', data.message, '');
              }else{
                swal_alert('failure', data.message, '')
              }
            }, 'json')

          }
        })
    })
  });


</script>