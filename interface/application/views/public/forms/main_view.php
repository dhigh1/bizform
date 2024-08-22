<style>
   /* ol.list-steps_te {
      padding: 0;
      margin: 0;
      counter-reset: steps;
      display: flex;
      justify-content: space-evenly;
      align-items: flex-start;
      position: relative;
      margin: 3rem 0;
   }

   ol.list-steps_te li {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      color: #6c757d;
      flex: 1 1 100%;
   }

   ol.list-steps_te li.active {
      color: #212529;
   }

   ol.list-steps_te li::before {
      counter-increment: steps;
      content: "";
      display: inline-block;
      background: #6c757d;
      color: #fff;
      border-radius: 50%;
      border: 0.5rem solid #caced1;
      width: 2rem;
      height: 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 0.5rem;
   }

   ol.list-steps_te li.active::before {
      background: #007bff;
      color: #fff;
      border: 0.3333333333rem solid #b3d7ff;
      -webkit-animation: pulsate 1.5s infinite ease-in-out alternate;
      animation: pulsate 1.5s infinite ease-in-out alternate;
   }

   ol.list-steps_te li.done::before {
      background: #007bff;
      color: #fff;
      border: 0.5rem solid #b3d7ff;
   }

   ol.list-steps_te li::after {
      position: absolute;
      z-index: -1;
      top: 0.75rem;
      display: block;
      content: "";
      width: 100%;
      height: 0.5rem;
      background: #caced1;
   }

   ol.list-steps_te li.active::after {
      background: #b3d7ff;
   }

   ol.list-steps_te li.done::after {
      background: #007bff;
   }

   ol.list-steps_te li:first-child::after {
      border-top-left-radius: 0.25rem;
      border-bottom-left-radius: 0.25rem;
   }

   ol.list-steps_te li:last-child::after {
      border-top-right-radius: 0.25rem;
      border-bottom-right-radius: 0.25rem;
   }

   @-webkit-keyframes pulsate {
      from {
         transform: scale(1);
      }

      to {
         transform: scale(1.2);
      }
   }

   @keyframes pulsate {
      from {
         transform: scale(1);
      }

      to {
         transform: scale(1.2);
      }
   } */

   /* body {
  font-size: 1em;
} */

.steps {
  display: table;
  table-layout: fixed;
  width: 75%;
  margin: auto;
  counter-reset: total 1 done 1;
}
.steps > * {
  counter-increment: total;
  position: relative;
  height: 0.25em;
  top: 0.375em;
  display: table-cell;
  background: lightGray;
}
.steps > *::before {
  content: "";
  background: lightGray;
  position: absolute;
  left: 0;
  top: -0.375em;
  height: 1em;
  width: 0.5em;
  border-radius: 0 1em 1em 0;
}
.steps > *::after {
  content: "";
  background: lightGray;
  position: absolute;
  top: -0.375em;
  right: 0;
  height: 1em;
  width: 0.5em;
  border-radius: 1em 0 0 1em;
}
.steps > *:first-child::before {
  content: "";
  background: green;
  position: absolute;
  top: -0.375em;
  left: -0.5em;
  height: 1em;
  width: 1em;
  border-radius: 50%;
}
.steps > *:last-child::after {
  content: "";
  position: absolute;
  top: -0.375em;
  right: -0.5em;
  height: 1em;
  width: 1em;
  border-radius: 50%;
}
.steps > *.done {
  counter-increment: total done;
  background: green;
}
.steps > *.done::before {
  background: green;
}
.steps > *.done::after {
  background: green;
}
.steps > *.done + *::before {
  background: green;
}

.intervals {
  display: table;
  table-layout: fixed;
  width: 75%;
  margin: auto;
}
.intervals > * {
  display: table-cell;
  text-align: center;
}
.intervals > *.done {
  color: green;
}

.labels {
  display: table;
  table-layout: fixed;
  width: 100%;
  margin: auto;
}
.labels > * {
  display: table-cell;
  text-align: center;
}
.labels > *.done {
  color: green;
}
.labels > .label {
  padding-bottom: 0.5em;
}

.count {
  display: none;
  text-align: center;
  font-size: 3em;
}
.count .done-count::after {
  color: green;
  content: counter(done);
}
.count .total-count::after {
  content: counter(total);
}

@media (max-width: 30em) {
  .steps {
    /* width: 0; */
    overflow: scroll;
  }

  .count {
    display: block;
  }

  .intervals,
.step-labels {
    display: block;
  }
}
</style>

<div class="progress"></div>


<?php 
   $responseData = array();
if(!empty($candidate_id)){
   $filterData['candidate_form_lists-candidate_id'] = $candidate_id;
      $responses = $this->curl->execute("responses/responses", "GET", $filterData); 
      if($responses['status']=='success' && !empty($responses['data_list'])){    
         $responseData = array_reverse($responses['data_list']);
      }
}
?>
<div class="row my-2">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <?php if(!empty($responseData)){ ?>
               <div class="row mb-3">
                  <div class="labels step-label">
                  <?php foreach($responseData as $res){ ?>
                     <div class="<?php echo ($res['status']==76)?'done':'' ?> label"><?php echo $res['form_name'] ?></div>
                  <?php  } ?>
               </div>
               <div class="steps">
                  <?php foreach($responseData as $res){ ?>
                  <div class="<?php echo ($res['status']==76)?'done':'' ?>"></div>
                  <?php } ?>
               </div>
            </div>
            <?php } ?>
            <div class="row">
               <?php if (!empty($error)) {
                  echo $error;
               } else { 
                  $form_json_src = "''";
                  if (!empty($form_template['html_json'])) {
                     $form_json_src = $form_template['html_json'];
                  } 
                  // print_r($form_json_src);
                  // echo "<hr>";
                  ?>
                  <h3 class="text-center text-primary">
                     <?php echo ($form_template['name']); ?>
                  </h3>
                  <form id="myForm">
                     <div class="formBuilder-box">
                        <div class="row">
                           <div class="col-md-12 mt-3">
                              <div id="render-container"></div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center">
                           <button type="submit" class="btn btn-primary">Next</button>
                           <button type="button" class="btn btn-light btn-cancel-case ml-2 cancel" data-id="<?php echo $response_id ?>">Cancel</button>
                        </div>
                     </div>
                  </form>

               <?php } ?>
            </div>
            <div id="Tbl"></div>
         </div>
         <!-- end card-body-->
      </div>
      <!-- end card-->
   </div>
   <!-- end col -->
</div>

<script>
   $(document).ready(function () {
      cancel();
      var formRenderInstance = $('#render-container').formRender({
         container: false,
         formData: <?php echo $form_json_src ?>,
         dataType: 'json',
         render: true,
         notify: {
            error: function (message) {
               return console.error(message);
            },
            success: function (message) {
               return console.log(message);
            },
            warning: function (message) {
               return console.warn(message);
            }
         }
      });
      $('.mydatepicker').datepicker();


      $(".dropify").on('change', function (e) {
         e.preventDefault();
         var formData = new FormData();
         var file = e.target.files[0];
         const thisdata = $(this);
         formData.append('file', file);
         formData.append('name', e.target.name)
         formData.append('formID', '<?php echo $form_template['id'] ?>')
         formData.append('campaignID', '<?php echo $campaign_data['id'] ?>')
         formData.append('user_id', '<?php echo $response_id ?>')
         formData.append("row_id", '<?php echo $response_row['id'] ?>')
         $("#progress-div").css('display', 'block');
         $.ajax({
            xhr: function () {
               var xhr = jQuery.ajaxSettings.xhr();
               if (xhr.upload) {
                  var xhr = new window.XMLHttpRequest();
                  xhr.upload.addEventListener("progress", function (evt) {
                     if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        console.log(percentComplete);
                        $('.progress').text(Math.round(percentComplete * 100) + '%');
                        $('.progress').css({
                           width: percentComplete * 100 + '%'
                        });
                        if (percentComplete === 1) {
                           $('.progress').css('display', 'none');
                        }
                     }
                  }, false);
               }
               return xhr; 
            },
            type: 'POST',
            url: "forms/save_files",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
               var result = JSON.parse(data);
               if (result.status == 'success') {
                  swal('success', result.message, '', '');
               } else {
                  swal('fail', result.message, '', '');
                  $(thisdata).next('.dropify-clear').trigger('click')
                  // fileInput.next('.dropify-wrapper').find('.dropify-clear').trigger('click');

               }
            }
         })
      })

      var isErr = 1;
      $(".rendered-form :input").each((i, e) => {
         $(e).after('<div class="text-danger"></div>')
         var inputwidth = $(e).attr('input_width');
         $(e).closest('.form-group').addClass("col-md-" + inputwidth)
      })


      if ($("#myForm").length > 0) {
         save_data();
      }

      // $.validator.addMethod('mobile', function(value, element) {
      //    return this.optional(element) || /^(\+91-|\+91|0)?\d{10}$/.test(value);
      // }, "Please enter a valid phone number");

      function save_data() {
         var form = '#myForm';
         $(form).validate({
            errorClass: 'error',
            validClass: 'valid',
            rules: {
            },
            messages: {
            },
            submitHandler: function (e) {
               var formdata = new FormData($(form)[0]);
               var formBuilderData = JSON.stringify(formRenderInstance.userData);
               formdata.append("fields_json", formBuilderData);
               formdata.append("user_id", '<?php echo $response_id ?>');
               formdata.append("row_id", '<?php echo $response_row['id'] ?>')
               $["ajax"]({
                  url: "forms/save_data",
                  type: "POST",
                  dataType: "json",
                  data: formdata,
                  contentType: false,
                  cache: false,
                  processData: false,
                  beforeSend: function () {
                     button_load(form, 'Processing...', '');
                     //ajaxloading('Submitting<br>Please wait...');
                  },
                  success: function (data) {
                     end_button_load(form, '');
                     if (data.status == 'success') {
                        window.location.reload();
                     } else {
                        swal('Failed', data.message, 'error');
                     }
                  },
                  error: function () { }
               })
            }
         });
      }


   })
   function cancel(){
      $(".cancel").on('click', function(e){
         e.preventDefault();
         const user_id = $(this).attr('data-id');
         console.log(user_id);
         $.post(urljs+'forms/cancel_case', {user_id}, function(data){
            if(data.status=='success'){
               swal('Success', 'Case Cancelled Successfully', 'success').then(()=>{
                  location.href=data.redirect_url;
               });
            }else{
               swal('Fail', 'Something went wrong', 'error');
               location.reload();
            }
         }, 'json');
      })
   }
</script>