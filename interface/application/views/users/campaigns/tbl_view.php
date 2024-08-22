<div class="row">
   <div class="col-lg-12">

      <?php if (isset($data_list) && !empty($data_list) && is_array($data_list)) { ?>
         <div class="col-lg-12">
            <p class="mb-1">Total <b><?php if (isset($pagination_data['pagination_links'])) {
                                          echo $pagination_data['total_rows'];
                                       } ?></b> Forms found</p>
         </div>
         <div class="row">
            <?php
            $i = $pagination_data['slno'];
            foreach ($data_list as $data_row) { ?>
               <div class="col-lg-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="row">
                           <div class="col">
                              <h5 class="mt-0 mb-0 font-14">
                                 <i class="mdi mdi-home"></i>
                                 <?php echo $data_row['name'] ?>
                              </h5>
                              <p class="mb-0">
                                 <span class="w-100 text-muted font-12">
                                    <i class="mdi mdi-timer-sand"></i>
                                    <?php echo '<span class="' . $data_row['status_color_name'] . '">' . $data_row['status_name'] . '</span>' ?>
                                 </span>
                              </p>
                              <p class="mb-0">
                                 <span class="w-100 text-muted font-12">

                                    <span class=" text-muted font-12"><b>Description</b>:
                                    <?php
                                    $desc = !empty($data_row['description'])?$data_row['description']:'N/A';
                                    ?>
                                       <?php echo '<span class="">' . $desc . '</span>' ?>
                                    </span>
                              </p>
                              <p class="time mb-0 ">
                                 <span class=" text-muted font-12"><b>Created</b>:
                                    <?php echo custom_date('d-M-Y h:i:s A', $data_row['created_at']); ?>
                                    <?php if (!empty($data_row['created_username'])) {
                                       echo "| " . ucwords($data_row['created_username']);
                                    } ?>
                                 </span>
                              </p> 
                              <p class="time mb-0 ">
                                 <span class=" text-muted font-12"><b>Updated</b>:
                                 <?php if(!empty($data_row['updated_at'])){ ?>
                                       <?php echo custom_date('d-M-Y h:i:s A', $data_row['updated_at']); ?>
                                       <?php 
                                       echo !empty($data_row['updated_username'])?'|'.ucwords($data_row['updated_username']):''
                                       ?>
                                    <?php }else{ ?>
                                       N/A
                                    <?php } ?>
                                    </span>
                                 </p>
                           </div>

                        </div>
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="data-card-actions mt-1">

                                    <button class="btn btn-sm btn-outline-primary btn-url-load rounded-pill mb-0" onclick="window.location.href='<?php echo base_url() . "campaigns/view?id=" . $data_row['id'] ?>'">View</button>
                                    <?php if($data_row['status']!=81){ ?>
                                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill mb-0 editData" data-id="<?php echo $data_row['id'] ?>">Edit</button>
                                    <?php } ?>
                                 
                                    <?php 
                                    if(User::check_permission('campaigns/delete', 'check')){
                                       if($data_row['status_name']=='Stop'){ ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill mb-0 deleteData" data-id="<?php echo $data_row['id'] ?>">Delete</button>
                                    <?php 
                                 } } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php $i++;
            } ?>
         </div>
         <div id="page_result" class="mt-0">
            <?php if (isset($pagination_data['pagination_links'])) {
               echo $pagination_data['pagination_links'];
            } ?>
         </div>
      <?php }else{ ?>
            <div class="alert alert-danger text-center">No Data Found</div>
      <?php } ?>
   </div>
</div>