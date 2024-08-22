<?php 
   $view_prm=User::check_permission('workorders/view','check');
   $delete_prm=User::check_permission('workorders/delete_data','check');
   $activity_prm=User::check_permission('workorders/get_workorder_activity','check');

?>

<div class="row">
   <div class="col-lg-12">
      <?php if(isset($data_list) && !empty($data_list) && is_array($data_list)){ ?>
      <div class="col-lg-12">
         <p class="mb-1">Total <b><?php if(isset($pagination_data['pagination_links'])){echo $pagination_data['total_rows'];} ?></b> orders found</p>
      </div>
      <?php 
      //print_r($data_list);
         $i=$pagination_data['slno'];
         foreach($data_list as $data_row){ 
      ?>
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-3">
                  <span class="mt-0 mb-0 font-14"><b>Sl.No. <?php echo $i ?></b></span>
               </div>
               <div class="col-lg-9 text-end">
                  <span class="mt-0 mb-0 font-14">
                     <b>ID: <?php echo $data_row['code'] ?></b>
                  </span>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-7">
                  <h5 class="mt-0 mb-0 font-14">
                     <i class="mdi mdi-home"></i>
                     <?php echo $data_row['customers_name'] ?> | <?php echo $data_row['customer_branches_name'] ?>
                  </h5>
                  <p class="mb-0">
                     <span class="w-100 text-muted font-12">
                     <i class="mdi mdi-account"></i> 
                     <?php echo $data_row['customer_branch_person_name'] ?> | <?php echo $data_row['customer_branch_person_email'] ?> | <?php echo $data_row['customer_branch_person_phone'] ?>
                     </span>
                  </p>
                  <p class="mb-0">
                     <span class="w-100 text-muted font-12">
                        <i class="mdi mdi-tag"></i> <?php echo $data_row['plan_code'] ?>
                     </span>
                  </p>
                  <p class="mb-0">
                     <span class="w-100 text-muted font-12">
                        <i class="mdi mdi-timer-sand"></i> 
                        <?php echo '<span class="'.$data_row['status_color_name'].'">'.$data_row['status_name'].'</span>' ?>
                     </span>
                  </p>
               </div>
               <div class="col-lg-5 text-end">
                  <p class="time mb-0 ">
                     <span class=" text-muted font-12"><b>Created</b>: 
                        <?php echo custom_date('d-M-Y h:i:s A',$data_row['created_at']); ?>
                        <?php if(!empty($data_row['created_username'])){ echo "| ".ucwords($data_row['created_username']);} ?>
                     </span>
                  </p>
                  <?php if(!empty($data_row['updated_at'])){ ?>
                  <p class="time mb-0 ">
                     <span class=" text-muted font-12"><b>Last Updated</b>: 
                        <?php echo custom_date('d-M-Y h:i:s A',$data_row['updated_at']); ?>
                        <?php if(!empty($data_row['updated_username'])){ echo "| ".ucwords($data_row['updated_username']);} ?>
                     </span>
                  </p>
                  <?php } ?>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <div class="data-card-actions mt-1">
                     <?php if($view_prm){ ?>
                     <button type="button" class="btn btn-sm btn-outline-primary btn-url-load rounded-pill mb-0" onclick="window.location.href='<?php echo base_url().'workorders/view?id='.$data_row['id'] ?>'">View</button>
                     <?php } ?>
                     
                     <?php if($delete_prm){ ?>
                     <button type="button" class="btn btn-sm btn-outline-danger rounded-pill mb-0 deleteData" data-id="<?php echo $data_row['id'] ?>">Delete</button>
                     <?php } ?>

                     <?php if($activity_prm){ ?>
                     <button type="button" class="btn btn-sm btn-outline-dark rounded-pill mb-0 workorderActivity" data-id="<?php echo $data_row['id'] ?>">Activity</button>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php $i++; } ?> 
      <div id="page_result" class="mt-0">
         <?php if(isset($pagination_data['pagination_links'])){ echo $pagination_data['pagination_links'];} ?>
      </div>
      <?php }else{ ?>
         <div class="row">
            <div class="col-lg-12">
               <div class="alert alert-info text-center">No workorders found...</div>
            </div>
         </div>
      <?php } ?>
   </div>
</div>