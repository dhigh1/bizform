<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/form-builder.min.js"></script>
<script>        
jQuery(function($) {
    var formBuilder_fields = [
        {
          type: 'header',
          subtype: 'h2',
          label: 'Section Header',
          className: 'sectionHeader',
          icon: '<i class="fa fa-header"></i>'
        },
        {
          type: 'file',
          subtype:'file',
          label: 'Upload Box',
          className: 'dropify',
          icon: '<i class="fa fa-upload"></i>'
        }
        
    ];


    // New attribute for specified fields 'fields' below

    var newAttributes = {
        shareToVendor: {
          label: 'Share with API/Vendor',
          options: {
            'yes': 'Yes',
            'no': 'No',
          }
        },
        shareToReport: {
          label: 'Share with Reporting',
          options: {
            'yes': 'Yes',
            'no': 'No',
          }
        },
        allowedTypes: {
          value: '',
          label: 'Allowed Types (Comma Separated)'
        },
        allowMultiple: {
          label: 'Allow Multiple uploads',
          options: {
            'no': 'No',
            'yes': 'Yes',
          }
        },
        dataEditable: {
          label: 'Data can be editable after execution?',
          options: {
            'yes': 'Yes',
            'no': 'No',
          }
        },
        
    };

    var userAttrs = {};
    const allfields = ["file"];
    allfields.forEach(function (item, index) {
        userAttrs[item] = newAttributes;
    });

    var formBuilder=$('textarea').formBuilder({
      formData: <?php if($data_list['uploads_json']!=''){echo $data_list['uploads_json'];}else{echo "''";} ?>,
      editOnAdd:true,
      fields:formBuilder_fields,
      scrollToFieldOnAdd:true,
      showActionButtons:false,
      disabledAttrs: ['access','subtype','description','placeholder'],
      disableFields: ['autocomplete','header','button','text','textarea','select','checkbox','date','number','radio-group','checkbox-group','paragraph','hidden','file'],
      controlOrder: [
        'header',
        'text',
        'textarea',
        'select',
        'checkbox-group',
        'date',
        'number',
        'radio-group',
        'checkbox-group',
        'paragraph'
      ],
      typeUserAttrs:userAttrs,
      sortableControls:true,
      onAddField: function(field) {
        //console.log(field);
      },
    });

    $('#getClear').on('click', function() {
        formBuilder.actions.clearFields();
    });

    sticky_controlbox();

    $('#myForm').validate({
      errorClass: 'error',
      validClass: 'valid',
      rules: {
      },
      messages:{        
      },
      submitHandler: function(){
          var formdata = new FormData($('#myForm')[0]);          
          var form_json=formBuilder.actions.getData('json', true);
          if(form_json.replace(/ /g,'').length<=2){
            swal('Error','Please add fields to form','warning');
          }else{
            formdata.append('json_data',form_json);
            formdata.append('manage','uploads');
            $["ajax"]({
               url: urljs+'service_templates/save_contents',
               type: "POST",
               dataType: "json",
               data: formdata,
               contentType: false,
               cache: false,
               processData: false,
               beforeSend: function() {
                   button_load('#myForm','Processing...','');
               },
               success: function(returnData) {
                   end_button_load('#myForm','');
                   if(returnData.status == "success"){
                      $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
                      swal_alert('success',returnData.message,'Success','reload');                      
                    }else{
                      show_toast('warning',returnData.message);
                    }
               },
               error: function() {}
           })
        }
      }
  });
});


function sticky_controlbox(){
  var nav = $('.cb-wrap');
  if (nav.length) {
    var top = nav.offset().top - parseFloat(nav.css('marginTop').replace(/auto/, 0));
    var footTop = $('.formBuilder-actions').offset().top - parseFloat($('.formBuilder-actions').css('marginTop').replace(/auto/, 0));
    var maxY = footTop - nav.outerHeight();            
    $(window).scroll(function(evt) {
       var y = $(this).scrollTop();
       if (y > top) { 
          //Quand scroll, ajoute une classe ".fixed" et supprime le Css existant 
          if (y < maxY) {
             nav.addClass('fixed').removeAttr('style');
          }else{                       
             //Quand la sidebar arrive au footer, supprime la classe "fixed" précèdement ajouté
             nav.removeClass('fixed').css({
                position: 'absolute',
                top: (maxY - top) + 'px'
             });
          }
       } else {
           nav.removeClass('fixed');
       }
    });
  }
}


</script>