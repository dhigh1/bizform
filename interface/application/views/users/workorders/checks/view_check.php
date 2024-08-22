<link href="<?php echo base_url() ?>ui/assets/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
<style>
   .custom-dropzone {
      min-height: 150px;
      border: 2px dashed #6c8bef;
      background: #fcfcfc;
      padding: 20px 20px;
   }

   .custom-dropzone .dz-message {
      margin-top: 10px;
   }

   .custom-dropzone h3 {
      margin-top: 10px;
      color: #000;
   }

   .custom-dropzone .dz-success-mark,
   .custom-dropzone .dz-error-mark {
      display: none !important;
   }
</style>

<div class="alert alert-info text-center p-1">Showing the check <b><?php echo $data_row['services_name'] ?></b> from the profile <b><?php echo $data_row['workorders_profiles_name'] ?></b></div>
<div class="row">
   <div class="col-md-6">
      <div class="table-responsive">
         <table class="table table-bordered">
            <tbody>
               <tr>
                  <td class="data-label">Check ID</td>
                  <td class="data-value"><?php echo $data_row['check_code'] ?></td>
               </tr>
               <tr>
                  <td class="data-label">Profile ID</td>
                  <td class="data-value"><?php echo $data_row['workorders_profiles_code'] ?></td>
               </tr>
               <tr>
                  <td class="data-label">Workorder ID</td>
                  <td class="data-value"><?php echo $data_row['workorder_code'] ?></td>
               </tr>
               <?php if (!empty($data_row['comments'])) { ?>
                  <tr>
                     <td class="data-label">Comments for Check</td>
                     <td class="data-value"><?php echo $data_row['comments'] ?></td>
                  </tr>
               <?php } ?>
               <?php if ($data_row['execution_count'] > 0) { ?>
                  <tr>
                     <td class="data-label">Executed</td>
                     <td class="data-value"><?php echo $data_row['execution_count'] ?> Time(s)</td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </div>

   <div class="col-md-6">
      <div class="table-responsive">
         <table class="table table-bordered">
            <tbody>
               <tr>
                  <td class="data-label" width="30%">Created</td>
                  <td class="data-value">
                     <?php if (!empty($data_row['created_at'])) {
                        echo custom_date('d-M-Y h:i:s A', $data_row['created_at']);
                     } ?>
                     <?php if (!empty($data_row['created_username'])) {
                        echo ' | ' . ucwords($data_row['created_username']);
                     } ?>
                  </td>
               </tr>
               <tr>
                  <td class="data-label">Last Updated</td>
                  <td class="data-value">
                     <?php if (!empty($data_row['updated_at'])) {
                        echo custom_date('d-M-Y h:i:s A', $data_row['updated_at']);
                     } else {
                        echo "---";
                     } ?>
                     <?php if (!empty($data_row['updated_username'])) {
                        echo ' | ' . ucwords($data_row['updated_username']);
                     } ?>
                  </td>
               </tr>
               <tr>
                  <td class="data-label">Status</td>
                  <td class="data-value">
                     <?php echo $data_row['status_name'] ?>
                  </td>
               </tr>

               <?php if (!empty($data_row['status_comments'])) { ?>
                  <tr>
                     <td class="data-label">Comments for Status Update</td>
                     <td class="data-value"><?php echo $data_row['status_comments'] ?></td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </div>

</div>

<?php if (User::check_permission('workorder_profiles_checks/view_prices', 'check')) { ?>

   <div class="row">
      <div class="col-md-12 mb-3 ">
         <div class="card mb-md-0 mb-3 user_permi_box ">
            <div class="card-body p-0">
               <div class="head_panel d-flex justify-content-between">
                  <h5 class="card-title mb-0">Pricing Information</h5>
                  <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-up"></i></a>
               </div>
               <div class="content_panel p-2">
                  <div class="table-responsive">
                     <table class="table table-bordered mb-1">
                        <tbody>
                           <tr>
                              <td class="data-label">Customer Price</td>
                              <td class="data-label">Vendor/Execution Price</td>
                              <td class="data-label">Discount Price</td>
                           </tr>
                           <tr>
                              <td class="data-value"><?php echo $data_row['customer_price'] ?></td>
                              <td class="data-value"><?php echo $data_row['vendor_price'] ?></td>
                              <td class="data-value"><?php echo $data_row['discount_price'] ?></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="text-sm-end">
                     <button type="button" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i> Edit</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php } ?>

<div class="row">
   <div class="col-lg-12 mb-3">
      <div class="card mb-md-0 user_permi_box ">
         <div class="card-body p-0">
            <div class="head_panel d-flex justify-content-between">
               <h5 class="card-title mb-0">Stored Data</h5>
               <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-down"></i></a>
            </div>
            <div class="content_panel p-2 active">
               <h5 class="mt-0 mb-1">Inputs Collected</h5>
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <tbody>
                        <?php
                        if (!empty($data_row['input_json'])) {
                           $input_json = json_decode($data_row['input_json'], true);
                           $i = 1;
                           foreach ($input_json as $json_data) {
                              $json_class = isset($json_data['className']) ? $json_data['className'] : '';
                        ?>

                              <tr>
                                 <?php if ($json_class == 'sectionHeader') { ?>
                                    <!-- <td colspan="2" class="sectionHeader"><?php echo $json_data['label'] ?></td>   -->
                                 <?php } else { ?>
                                    <td class="data-label"><?php echo $json_data['label'] ?></td>
                                    <td class="data-value">
                                       <?php
                                       if (isset($json_data['userData'])) {
                                          if (isset($json_data['dateFormat'])) {
                                             echo custom_date($json_data['dateFormat'], implode($json_data['userData']));
                                          } else {
                                             echo implode($json_data['userData']);
                                          }
                                       }
                                       ?>
                                    </td>
                                    <td>
                                       <div class="form-check form-switch">
                                          <?php if (isset($json_data['is_valid']) && !empty($json_data['is_valid'] == 'false')) { ?>
                                             <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" data-key="form_fields" style="cursor: pointer;" readonly>
                                          <?php } else { ?>
                                             <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked style="cursor: pointer;" readonly>
                                          <?php } ?>
                                       </div>

                                    </td>
                                 <?php $i++;
                                 } ?>
                              </tr>

                        <?php }
                        } ?>
                     </tbody>
                  </table>
               </div>
               <h5 class="mt-0 mb-1">Input Uploads Collected</h5>
               <?php if (!empty($data_row['input_uploads_json']) && !empty($input_uploads)) { ?>
                  <div class="row">
                     <?php foreach ($input_uploads as $upld) { ?>
                        <div class="col-lg-4 text-center my-1 py-2">
                           <p class="text-primary" style="font-size: 20px;"><?php echo $upld['file_label'] ?></p>
                           <img src="<?php echo base_url() . $upld['file_path'] . $upld['file_name'] ?>" style="height: 150px;" alt="">
                           <div class="form-check form-switch d-flex justify-content-center my-2">
                              <?php if ($upld['is_valid'] == 1) { ?>
                                 <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" data-key="form_fields" checked style="cursor: pointer;" readonly>
                              <?php } else if($upld['is_valid'] == 0) { ?>
                                 <input class="form-check-input text-center" type="checkbox" role="switch" id="flexSwitchCheckChecked" style="cursor: pointer;" readonly>
                              <?php } ?>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
               <?php } ?>
               <?php if ($data_row['status'] > 2) { ?>
                  <h5 class="mt-0 mb-1">Execution Result</h5>
                  <div class="table-responsive">
                     <table class="table table-bordered">
                        <tbody>
                           <?php
                           if (!empty($data_row['output_json']) && $data_row['execution_type'] == 56) {
                              $output_json = json_decode($data_row['output_json'], true);
                              foreach ($output_json as $k => $v) {
                                 //if(!empty($v)){
                                 if (is_array($v)) {
                                    print_json_array($v);
                                 } else { ?>

                                    <tr>
                                       <td class="data-label"><?php echo $k ?></td>
                                       <td class="data-value"><?php echo $v; ?></td>
                                    </tr>

                                 <?php  }
                              }
                           } else if (!empty($data_row['output_json']) && $data_row['execution_type'] != 56) {
                              $output_json = json_decode($data_row['output_json'], true);
                              // print_r($output_json);
                              foreach ($output_json as $output) { ?>
                                 <tr>
                                    <td class="data-label"><?php echo $output['label'] ?></td>
                                    <td class="data-label"><?php if (!empty($output['userData'])) {
                                                               print_r($output['userData'][0]);
                                                            } ?></td>
                                 </tr>
                              <?php }
                           } else { ?>
                              <tr>
                                 <td colspan="2">Nothing found...</td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>

                  <h5 class="mt-0 mb-1">Uploads</h5>
                  <?php
                  if (!empty($uploads)) { ?>
                     <div class="row">
                        <?php foreach ($uploads as $upload) { ?>
                           <div class="col-lg-6 text-center my-1 py-2" style="border: 1px solid black">
                              <p class="text-primary" style="font-size: 24px;"><?php echo $upload['file_label'] ?></p>
                              <p>From Output: </p>
                              <img src="<?php echo base_url() . $upload['file_path'] . $upload['file_name'] ?>" style="height: 150px;" alt="">
                              <div class="dropzone_box_<?php echo $upload['file_input_name'] ?> my-2">
                                 <?php if (!empty($to_customer_uploads)) {
                                    foreach ($to_customer_uploads as $cust_uploads) {
                                       if ($upload['file_label'] == $cust_uploads['file_label'] && $upload['workorder_profiles_checks_id'] == $cust_uploads['workorder_profiles_checks_id']) {
                                 ?> <p>To Customer: </p>
                                          <img src="<?php echo base_url() . $cust_uploads['file_path'] . $cust_uploads['file_name'] ?>" style="height: 150px;" alt="">
                                 <?php }
                                    }
                                 } ?>
                                 <div>
                                    <button class="btn btn-primary change my-2" data-label='<?php echo $upload['file_label'] ?>' data-id="<?php echo $upload['file_input_name'] ?>">Change</button>
                                 </div>
                              </div>
                           </div>
                        <?php } ?>
                     </div>

                     </tr>
                  <?php } ?>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>

<?php if (User::check_permission('workorders/get_check_status_update', 'check')) { ?>
   <div class="row">
      <div class="col-lg-12 mb-3">
         <div class="card mb-md-0 user_permi_box ">
            <div class="card-body p-0">
               <div class="head_panel d-flex justify-content-between">
                  <h5 class="card-title mb-0">Update Status</h5>
                  <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-up"></i></a>
               </div>
               <div class="content_panel p-2">

                  <?php if ($data_row['services_code'] == 'crc' && $data_row['status'] == 7) { ?>
                     <div class="alert alert-info text-center p-1">Please check in CaseQuest app to update.</div>
                  <?php } else if ($data_row['allow_status'] == 1) { ?>
                     <div class="alert alert-info text-center p-1">Since the check is locked by execution you cannot update.</div>
                  <?php } else { ?>
                     <!-- start status update form -->
                     <form class="form" id="myForm" novalidate>
                        <input type="hidden" name="id" value="<?php echo $data_row['id'] ?>">
                        <div class="div_res"></div>
                        <div class="row">
                           <div class="col-lg-12 mb-1">
                              <label>Put check to the flow</label>
                              <select class="form-select" name="transition_id" required>
                                 <option value="">--select--</option>
                                 <?php

                                 $transitions = $this->curl->execute("workflow/transitions/" . $data_row['status'], "GET");
                                 if (!empty($transitions['data_list'])) {
                                    foreach ($transitions['data_list'] as $row) {
                                 ?>
                                       <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                 <?php }
                                 } ?>
                              </select>
                           </div>
                           <div class="col-lg-12 mb-2">
                              <label>Comments</label>
                              <textarea class="form-control" name="comments" rows="1"></textarea>
                           </div>
                           <?php
                           if ($data_row['services_execution_type'] == 55) {
                              $vendors = $this->curl->execute("vendors", "GET", array('sortby' => 'vendors.name', 'orderby' => 'ASC'));
                              if (!empty($vendors['data_list'])) {
                           ?>
                                 <div class="col-lg-6 mb-2">
                                    <label>Vendor to execute</label>
                                    <select class="form-select" name="executor_id" required>
                                       <option value="">--select--</option>
                                       <?php foreach ($vendors['data_list'] as $vendor) { ?>
                                          <option value="<?php echo $vendor['id'] ?>" <?php if ($data_row['services_executor_id'] == $vendor['id']) {
                                                                                          echo "selected";
                                                                                       } ?>><?php echo $vendor['name'] ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                           <?php }
                           } ?>

                           <div class=" col-lg-12  d-flex justify-content-end mt-2">
                              <button type="submit" class="btn btn-primary"><i class="ft-plus"></i> Submit</button>
                           </div>
                        </div>
                     </form>
                     <!-- end status update form -->
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php } ?>


<?php
function print_json_array($data)
{
   foreach ($data as $kk => $vv) {
      if (is_array($vv)) {
         print_json_array($vv);
      } else {
         $html = '<tr>';
         $html .= '<td class="data-label">' . $kk . '</td>';
         $html .= '<td class="data-value">' . $vv . '</td>';
         $html .= '</tr>';
         echo $html;
      }
   }
}
?>


<?php if (isset($reports) && !empty($reports)) { ?>
   <div class="row">
      <div class="col-lg-12 mb-3">
         <div class="card mb-md-0 user_permi_box ">
            <div class="card-body p-0">
               <div class="head_panel d-flex justify-content-between">
                  <h5 class="card-title mb-0">Reports</h5>
                  <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-down"></i></a>
               </div>
               <div class="content_panel p-2 active">
                  <div class="table-responsive">
                     <table class="table table-bordered mb-0">
                        <thead>
                           <th>Sl.No.</th>
                           <th>Type</th>
                           <th>Generated At</th>
                           <th>Download</th>
                        </thead>
                        <tbody>
                           <?php
                           $r = 1;
                           foreach ($reports as $report) {
                           ?>
                              <tr>
                                 <td><?php echo $r ?></td>
                                 <td><?php echo $report['report_type'] ?></td>
                                 <td><?php echo custom_date('d-M-Y h:i:s A', $report['created_at']);
                                       if (!empty($report['created_username'])) {
                                          echo ' | ' . $report['created_username'];
                                       } ?></td>
                                 <td><a href="<?php echo $report['base_path'] . $report['report_url'] ?>" target="_blank" download><i class="fa fa-download"></i></a></td>
                              </tr>
                           <?php $r++;
                           } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php } ?>

<div class="row">
   <div class="col-lg-12 mb-3">
      <div class="card mb-md-0 user_permi_box ">
         <div class="card-body p-0">
            <div class="head_panel d-flex justify-content-between">
               <h5 class="card-title mb-0">Activity Log</h5>
               <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-up"></i></a>
            </div>
            <div class="content_panel p-2">

               <?php if (isset($logs) && !empty($logs['data_list'])) { ?>
                  <div data-simplebar style="max-height: 330px;">
                     <div class="timeline-alt pb-0 pt-0">

                        <?php
                        foreach ($logs['data_list'] as $log_row) {
                        ?>
                           <!-- end timeline item -->
                           <div class="timeline-item">
                              <i class="mdi mdi-check-underline bg-info-lighten text-info timeline-icon"></i>
                              <div class="timeline-item-info">
                                 <small><?php echo $log_row['description'] ?></small>
                                 <p class="mb-0 pb-2">
                                    <small class="text-muted"><?php echo ucwords($log_row['created_username']) . ' | ' . humanTiming($log_row['created_at']) . ' | ' . custom_date('d-M-Y h:i:s A', $log_row['created_at']); ?></small>
                                 </p>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div> <!-- end slimscroll -->
               <?php } else {
                  echo $logs['message'];
               } ?>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="text-sm-end">
   <button type="button" class="btn btn-light bootbox-close-button">Close</button>
</div>

<script src="<?php echo base_url() ?>ui/assets/plugins/dropzone/dropzone.min.js"></script>

<script>
   $('.dropify').dropify();

   $(".dropify").on('change', function(e) {
      var label = $(this).attr('data-label');

   })



   $(".change").on('click', function() {
      // console.log($(this).attr('data-label'))
      var labelName = $(this).attr('data-label');
      var inputName = $(this).attr('data-id');
      $(".dropzone_box_" + inputName).html(`<div class="custom-dropzone text-center align-items-center my-dropzone_${inputName} my-2">
      <input type="hidden" class="dropzone_name">
      <div class="dz-default dz-message" data-dz-message>
         <h3 class="mb-0"><i class="mdi mdi-cloud-upload"></i></h3>
         <br>
         <p>Drop here or click here to upload</p>
      </div>
   </div>`);
      init_dropzone(inputName, labelName);
   })

   function init_dropzone(inputName, labelName) {
      $(".my-dropzone_" + inputName).dropzone({
         url: urljs + 'workorders/save_check_upload',
         //paramName:'file',
         addRemoveLinks: true,
         dictRemoveFile: "Replace",
         maxFiles: 1,
         resizeWidth: 1000,
         resizeHeight: 1000,
         resizeMethod: 'contain',
         resizeQuality: 0.5,
         //dataType:"json",
         sending: function(file, xhr, formData) {
            formData.append("docname", inputName);
            formData.append("check_id", '<?php echo $check_id ?>');
            formData.append("file_label", labelName)
            formData.append("data_input_type", "output");
            //console.log('docname='+docname);
         },
         success: function(file, response) {
            var obj = jQuery.parseJSON(response);
            if (obj.result == 'success') {
               show_toast('success', obj.msg);
               $(this.element).find("input.dropzone_name").attr("value", obj.file_name);
               $(this.element).find('.dz-default.dz-message').hide();
               $(this.element).find("input.dropzone_name").after('<label class="status-label text-success d-block mb-2"><i class="fa fa-check"></i> Uploaded</label>');
               file.previewElement.classList.add("dz-success");
            } else {
               show_toast('error', obj.msg);
               file.previewElement.innerHTML = "";
               $(this.element).find("input.dropzone_name").attr("value", obj.file_name);
            }

         },
         error: function(file, response) {
            var obj = jQuery.parseJSON(response);
            show_toast('error', obj.msg);
            file.previewElement.classList.add("dz-error");
            file.previewElement.innerHTML = "";
         },
         removedfile: function(file) {
            $(this.element).find('.dz-default.dz-message').show();
            $(this.element).find("label.status-label").remove();
            file.previewElement.innerHTML = "";
            $(this.element).find("input.dropzone_name").attr("value", "");
         }
      });
   }
</script>