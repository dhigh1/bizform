<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>ui/assets/plugins/formBuild/dist/form-builder.min.js"></script>
<script>
  jQuery(function($) {
    var inputSets = [{
        icon: '<i class="mdi mdi-account"></i>',
        label: 'First Name',
        name: 'custom-firstname', // optional - one will be generated from the label if name not supplied
        showHeader: false, // optional - Use the label as the header for this set of inputs
        fields: [{
          icon: '<i class="mdi mdi-account"></i>',
          type: "text",
          label: "First Name",
          name: 'first_name',
          className: "form-control",
          required: true,
        }]
      },
      {
        icon: '<i class="mdi mdi-account"></i>',
        label: 'Last Name',
        name: 'custom-lastname', // optional - one will be generated from the label if name not supplied
        showHeader: false, // optional - Use the label as the header for this set of inputs
        fields: [{
          icon: '<i class="mdi mdi-account"></i>',
          type: "text",
          label: "Last Name",
          name: 'last_name',
          className: "form-control",
          required: true,
        }]
      },
      {
        icon: '<i class="mdi mdi-email"></i>',
        label: 'Email',
        name: 'custom-email', // optional - one will be generated from the label if name not supplied
        showHeader: false, // optional - Use the label as the header for this set of inputs
        fields: [{
          icon: '<i class="mdi mdi-email"></i>',
          type: "text",
          subtype: "email",
          label: "Email",
          className: "form-control",
          name: 'email',
          required: true
        }]
      },
      {
        icon: '<i class="mdi mdi-cellphone"></i>',
        label: 'Mobile',
        name: 'custom-mobile', // optional - one will be generated from the label if name not supplied
        showHeader: false, // optional - Use the label as the header for this set of inputs
        fields: [{
          type: 'text',
          label: 'Mobile',
          className: 'form-control ',
          name: 'mobile'
        }]
      },
      {
        icon: '<i class="mdi mdi-card-account-details"></i>',
        label: 'General Details',
        name: 'custom-details', // optional - one will be generated from the label if name not supplied
        showHeader: false, // optional - Use the label as the header for this set of inputs
        fields: [{
            type: 'text',
            label: 'First Name',
            className: 'form-control ',
            name: 'first_name'
          },
          {
            type: 'text',
            label: 'Last Name',
            name: 'last_name',
            className: 'form-control ',
          },
          {
            type: 'text',
            subtype: 'email',
            label: 'Email',
            className: 'form-control ',
            name: 'email'
          },
          {
            type: 'text',
            label: 'Mobile',
            className: 'form-control ',
            name: 'mobile'
          },
          {
            type: 'text',
            label: 'Date of Birth',
            className: 'form-control mydatepicker ',
            name: 'dob'
          }
        ]
      }
    ]
    var formBuilder_fields = [{
        type: "select",
        label: "Dropdown List",
        className: "form-control form-select ",
        multiple: false,
        required: true,
        values: [{
            label: '--select--',
            value: '',
            selected: true,
          },
          {
            label: 'Option 1',
            value: 'Value-1',
            selected: false,
          }
        ]
      },
      {
        type: "radio-group",
        className: "radio-group form-check-input ",
        required: true,
        label: "Radio Group",
        inline: false,
        access: false,
        other: false,
        values: [{
            label: "Option 1",
            value: "option-1",
            selected: true
          },
          {
            label: "Option 2",
            value: "option-2",
            selected: false
          }
        ]
      },
      {
        type: "checkbox-group",
        required: true,
        label: "Checkbox Group",
        className: "form-check-input ",
        toggle: false,
        inline: false,
        access: false,
        other: false,
        values: [{
          label: "Option 1",
          value: "option-1",
          selected: true
        }]
      },
      {
        type: "paragraph",
        // className: "form-control ",
        subtype: "p",
        label: "Paragraph",
        access: false
      },
      {
        type: "text",
        required: true,
        label: "Date",
        className: "form-control mydatepicker ",
        access: false,
        icon: '<i class="mdi mdi-calendar"></i>'
      },
      {
        required: true,
        type: "text",
        subtype: "email",
        label: "Email",
        name: 'email',
        className: "form-control ",
        access: false,
        icon: '<i class="mdi mdi-email"></i>',
      },
      {
        type: 'file',
        subtype: 'file',
        label: 'Upload Box',
        className: 'dropify form-control',
        icon: '<i class="fa fa-upload"></i>',
      }
    ];
    // New attribute for specified fields 'fields' below
    const typeUserAttrs = {
      select: {
        input_width: {
          label: 'Width',
          value: 12
        }
      },
      "checkbox-group": {
        input_width: {
          label: 'Width',
          value: 12
        }
      },
      "radio-group": {
        input_width: {
          label: 'Width',
          value: 12
        }
      },
      text: {
        maxlength:{
          label: 'Max Length',
          value: ''
        },
        minlength: {
          label: 'Min Length',
          value: 1,
        },
        input_width: {
          label: 'Width',
          value: 12
        },

      },
      textarea: {
        minlength: {
          label: 'Min Length',
          value: 1,
        },
        input_width: {
          label: 'Width',
          value: 12
        },
        rows: {
          label: 'Rows',
          value: 10
        },
        cols: {
          label: 'Columns',
          value: 30
        },
        input_width: {
          label: 'Width',
          value: 12
        }
      },
      number: {
        minlength: {
          label: 'Min Length',
          value: 1
        },
        input_width: {
          label: 'Width',
          value: 12
        }
      },
      email: {
        email: {
          label: 'Valid Email Only',
          value: true
        },
        input_width: {
          label: 'Width',
          value: 12
        }
      },
      file: {
        'data-allowed-file-extensions':{
          label: 'Allowed Types (Comma Separated)',
          value: 'jpg png pdf gif'
        },
        input_width: {
          label: 'Width',
          value: 12
        }
      }
    };
    var userAttrs = {};

    // var date_fromatAttrs={dateFormat: {value: '',label: 'Date Format'}};

    const allfields = ["select", "checkbox-group", "date", "number", "radio-group", "select", "text", "textarea", "paragraph", "email"];
    allfields.forEach(function(item, index) {
      // var appendAttr=newAttributes;
      // if(item==='date'){
      //   appendAttr = Object.assign(appendAttr,date_fromatAttrs);
      //   userAttrs['date'] = appendAttr;
      // }else{
      // userAttrs[item] = newAttributes;
      //}
    });

    function generateFormBuilder() {
      return new Promise((resolve, reject) => {
        var formBuilder = $('textarea').formBuilder({
          formData: <?php if ($data_list['html_json'] != '') {
                      echo $data_list['html_json'];
                    } else {
                      echo "''";
                    } ?>,
          editOnAdd: true,
          fields: formBuilder_fields,
          inputSets: inputSets,
          scrollToFieldOnAdd: true,
          showActionButtons: false,
          disableFields: ['autocomplete', 'header', 'button', 'file', 'hidden', 'radio-group', 'select', 'checkbox-group', 'paragraph', 'date'],
          controlOrder: [
            'text',
            'header',
            'textarea',
            'select',
            'checkbox-group',
            'date',
            'number',
            'radio-group',
            'checkbox-group',
            'paragraph',
            'email'
          ],
          sortableControls: true,
          typeUserAttrs: typeUserAttrs,

        });
        setTimeout(() => {
          resolve(formBuilder);
        }, 500);
      })
    }

    generateFormBuilder().then(formBuilder => {
      $('#getClear').on('click', function() {
        formBuilder.actions.clearFields();
      })
      $(".input-set-control").insertAfter(".input-control:last")
      $("<div class='p-2 m-0 text-center'><p style='margin: 0; padding:0;'>Custom Fields</p> <hr class='text-center bg-danger m-0 p-0' /></div>").insertBefore($(".input-set-control").eq(0))

      // save the form
      $('#myForm').validate({
        errorClass: 'error',
        validClass: 'valid',
        rules: {},
        messages: {},
        submitHandler: function() {
          var formdata = new FormData($('#myForm')[0]);
          console.log(formdata)
          var form_json = formBuilder.actions.getData('json', true);
          if (form_json.replace(/ /g, '').length <= 2) {
            swal('Error', 'Please add html fields to form', 'warning');
          } else {
            formdata.append('json_data', form_json);
            formdata.append('manage', 'html');
            $["ajax"]({
              url: urljs + 'formbuilder/save_contents',
              type: "POST",
              dataType: "json",
              data: formdata,
              contentType: false,
              cache: false,
              processData: false,
              beforeSend: function() {
                button_load('#myForm', 'Processing...', '');
              },
              success: function(returnData) {
                end_button_load('#myForm', '');
                if (returnData.status == "success") {
                  $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
                  swal_alert('success', returnData.message, 'Success', 'reload');
                } else {
                  show_toast('warning', returnData.message);
                }
              },
              error: function() {}
            })
          }
        }
      });

    })

    sticky_controlbox();

  });




  function sticky_controlbox() {
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
          } else {
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