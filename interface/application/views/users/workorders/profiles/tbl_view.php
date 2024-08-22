<?php 
   if(!empty($profiles)){
      $p=0;


      // profile permisisons
      $edit_prm=User::check_permission('workorders/edit_profile','check');
      $delete_prm=User::check_permission('workorders/delete_profile','check');
      $activity_prm=User::check_permission('workorders/get_profile_activity','check');
      $report_prm=User::check_permission('workorders/get_reports_download_profile','check');


      foreach($profiles as $profile){
         $p++;
         $filterData['sortby']='orders';
         $filterData['orderby']='ASC';
         $checks=$this->curl->execute('workorder_profiles_checks?workorder_profiles-id='.$profile['id'],'GET',$filterData);
         $checks_no=0;
         if($checks['status']=='success' && !empty($checks['data_list'])){
            $checks_no=count($checks['data_list']);
         }
?>
   <div class="row">
      <div class="col-lg-12 mb-3">                                         
         <div class="card mb-md-0 mb-3 user_permi_box ">
            <div class="card-body p-0">
               <div class="head_panel d-flex justify-content-between">
                  <h5 class="card-title mb-0">Profile <?php echo $p ?></h5>
                  <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-down"></i></a>
               </div>      
               <div class="content_panel p-2 active">
                  <div class="row">
                     <div class="col-lg-6 col-12">
                        <table class="table table-bordered">
                           <tbody>
                              <tr>
                                 <td class="data-label">Profile ID</td>
                                 <td class="data-value"><?php echo $profile['profile_code'] ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Ref.Id</td>
                                 <td class="data-value"><?php if(!empty($profile['ref_id'])){ echo $profile['ref_id'];}else{ echo "---";} ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Name</td>
                                 <td class="data-value"><?php echo $profile['name'] ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Phone</td>
                                 <td class="data-value"><?php echo $profile['phone'] ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Email</td>
                                 <td class="data-value"><?php echo $profile['email'] ?></td>
                              </tr>
                              <?php if(!empty($profile['comments'])){ ?>
                              <tr>
                                 <td class="data-label">Comments</td>
                                 <td class="data-value"><?php echo $profile['comments']; ?></td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                     <div class="col-lg-6 col-12">
                        <table class="table table-bordered">
                           <tbody>
                              <tr>
                                 <td class="data-label">Created</td>
                                 <td class="data-value"><?php echo custom_date('d-M-Y h:i:s A',$profile['created_at']).' | '.$profile['created_username']; ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Create Type</td>
                                 <td class="data-value"><?php echo $profile['create_type_name'] ?></td>
                              </tr>
                              <?php if(!empty($profile['updated_at'])){ ?>
                              <tr>
                                 <td class="data-label">Last Updated</td>
                                 <td class="data-value"><?php echo custom_date('d-M-Y h:i:s A',$profile['updated_at']).' | '.$profile['updated_username']; ?></td>
                              </tr>
                              <?php } ?>
                              <tr>
                                 <td class="data-label">Status</td>
                                 <td class="data-value"><?php echo '<span class="'.$profile['status_color_name'].'">'.$profile['status_name'].'</span>' ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Actions</td>
                                 <td class="data-actions">

                                    <?php if($edit_prm){ ?>
                                    <span class="badge badge-outline-primary rounded-pill editProfile" data-id="<?php echo $profile['id'] ?>" data-mid="<?php echo $workorders_id ?>"><i class="mdi mdi-pencil"></i> Edit</span>
                                    <?php } ?>

                                    <?php if($checks_no==0){ ?>

                                    <?php if($delete_prm){ ?>
                                    <span class="badge badge-outline-danger rounded-pill ml-1 deleteProfile" data-id="<?php echo $profile['id'] ?>" data-mid="<?php echo $workorders_id ?>"><i class="mdi mdi-delete"></i> Delete</span>
                                    <?php } ?>

                                    <?php } ?>

                                    <?php if($activity_prm){ ?>
                                    <span class="badge badge-outline-dark rounded-pill ml-1 profileActivity" data-id="<?php echo $profile['id'] ?>" data-mid="<?php echo $workorders_id ?>"><i class="mdi mdi-clock"></i> Activity</span>
                                    <?php } ?>
                                    
                                    <?php if($report_prm){ ?>
                                    <span class="badge badge-outline-success rounded-pill ml-1 getprofileReport" data-id="<?php echo $profile['id'] ?>" data-module="profile" data-code="<?php echo $profile['code'] ?>" data-folder="<?php echo create_slug($profile['workorder_code']).'/'.create_slug($profile['code']) ?>"  data-mid="<?php echo $workorders_id ?>"><i class="mdi mdi-file-document"></i> Get Report</span>
                                    <?php } ?>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>

                  
                  
                  <div class="widget-bucket-view">
                     <?php if(isset($services) && !empty($services)){ ?>
                     <div class="d-flex justify-content-left mt-2">
                        <ul class=" d-flex mt-0 mb-0 check_bar row">

                           <?php foreach($services as $service){ ?>



                            <!-- count if the service type is already exists -->
                           <?php 
                              $check_count=0;
                              if($checks['status']=='success' && !empty($checks['data_list'])){ 
                                 foreach($checks['data_list'] as $check_row){
                                    if($check_row['services_id']==$service['services_id']){
                                       $check_count++;
                                    }
                                 }
                              }
                           ?>

                           <!-- conditions to add check -->
                           <?php   
                              $service_title='Click to add'; 
                              $can_add_check=true;
                              $check_dept=User::check_service_view($service['services_departments_id']);

                              //check if status can show to this user
                              if($check_dept==false){
                                 $service_title="You cannot add";
                              }
                              //end  check if status can show to this user

                              if($check_count>0){
                                 $service_title='Already exists';
                              }

                              if(!$add_chk_prm){
                                 $service_title='You dont have permission';
                              }

                              if($check_count==0 && $add_chk_prm && $check_dept){
                                 $can_add_check=true;
                              }else{
                                 $can_add_check=false;
                              }
                           ?>
                           <!-- end conditions to add check -->

                           <li class="col-2 p-2 border  d-flex justify-content-between align-items-center <?php if($can_add_check){echo 'addProfileCheck';}else{ echo "disableAddCheck";} ?>" data-id="<?php echo $service['services_id'] ?>" data-mid="<?php echo $profile['id'] ?>" style="color: <?php echo $service['services_icon_color']; ?>;" title="<?php echo $service_title ?>">
                             <?php if(!empty($service['services_icon'])){ print_icon($service['services_icon'],$service['services_icon_color']); } ?>
                             <?php echo $service['services_name'] ?>

                              
                             <span class=" ms-1 badge rounded-pill" style="background-color: <?php echo $service['services_icon_color']; ?>;"><?php echo $check_count; ?></span>
                           </li>

                           <?php } ?>
                         </ul>
                     </div>
                     <?php }else{ ?>
                        <div class="alert alert-danger text-center p-0 mt-2">Since the customer plan is changed or not found, you cannot add new checks!</div>
                     <?php } ?>

                     <?php 
                     //print_r($workflow);
                        if(isset($workflow) && !empty($workflow)){
                     ?>

                     <ul class="timeline_process mt-2" id="timeline_ul">
                        <?php foreach($workflow as $flow_row){ ?>
                        <li class="<?php echo $flow_row['class_name'] ?>">
                           <?php
                              if($checks['status']=='success' && !empty($checks['data_list'])){
                              foreach($checks['data_list'] as $check_row){
                                 if($check_row['status']==$flow_row['id']){
                           ?>

                           <div class="dropdown">

                              <?php
                                 $popover_html='';
                                 if(!empty($check_row['check_code'])){
                                     $popover_html.='<b>ID</b>: '.$check_row['check_code'];
                                 }
                                 if(!empty($check_row['created_at'])){
                                     $popover_html.='<br/><b>Created</b>: '.custom_date('d-M-Y h:i:s A',$check_row['created_at']);
                                 }
                                 if(!empty($check_row['created_username'])){
                                     $popover_html.=' | '. ucwords($check_row['created_username']);
                                 }
                                 if(!empty($check_row['updated_at'])){
                                     $popover_html.='<br/><b>Last Updated</b>: '.custom_date('d-M-Y h:i:s A',$check_row['updated_at']);
                                 }
                                 if(!empty($check_row['updated_username'])){
                                     $popover_html.=' | '. ucwords($check_row['updated_username']);
                                 }
                                 if(!empty($check_row['execution_count']) && $check_row['execution_count']>0){
                                     $popover_html.='<br/><b>Executed</b>: '.$check_row['execution_count'].' Time(s)';
                                 }
                              ?>
                              <button class="dropdown-toggle" type="button" id="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo $check_row['services_name'] ?>" data-toggle="popover" data-bs-trigger="hover" data-bs-content="<?php echo $popover_html ?>" data-bs-html="true">
                                  <span class="badge rounded-pill" style="color: <?php echo $check_row['services_icon_color']; ?>;">
                                    <?php if(!empty($check_row['services_icon'])){ print_icon($check_row['services_icon'],$check_row['services_icon_color']); } ?>
                                    </span>
                              </button>
                              

                              <!-- check if status can show to this user  -->
                              <?php if(User::check_service_view($check_row['services_departments_id'])){ ?>

                              <?php if($view_chk_prm || $status_chk_prm || $edit_chk_prm || $delete_chk_prm){ ?>              
                              <div class="dropdown-menu" aria-labelledby="">
                                 <?php if($view_chk_prm){ ?>
                                  <a class="dropdown-item viewProfileCheck" data-id="<?php echo $check_row['id'] ?>" data-mid="<?php echo $workorders_id ?>" href="javascript:;"><i class="mdi mdi-eye"></i> View</a>
                                 <?php } ?>

                                 <?php if($status_chk_prm && $check_row['allow_status']==0){ ?>
                                  <a class="dropdown-item editCheckStatus" data-id="<?php echo $check_row['id'] ?>" data-mid="<?php echo $workorders_id ?>" href="javascript:;"><i class="mdi mdi-timer-sand"></i> Status</a>
                                 <?php } ?>

                                  <?php if($check_row['status']<5  && $check_row['allow_status']==0){ ?>

                                 <?php if($edit_chk_prm){ ?>
                                  <a class="dropdown-item editProfileCheck" data-id="<?php echo $check_row['id'] ?>" data-mid="<?php echo $workorders_id ?>" href="javascript:;"><i class="mdi mdi-pencil"></i> Edit</a>
                                  <?php } ?>

                                  <?php if($delete_chk_prm){ ?>
                                  <a class="dropdown-item deleteProfileCheck" data-id="<?php echo $check_row['id'] ?>" data-mid="<?php echo $workorders_id ?>" href="javascript:;"><i class="mdi mdi-delete"></i> Delete</a>
                                  <?php } ?>

                                 <?php } ?>
                              </div>
                              <?php } ?>
                              
                              <?php } ?>
                              <!-- end  check if status can show to this user  -->
                          </div>
                           <?php } } } ?>                    
                           <div class="action_box">
                              <?php echo $flow_row['name'] ?>
                           </div>
                        </li>
                        <?php } ?>
                        
                     </ul>
                     <?php } ?>
                  </div>
               </div>            
            </div>
         </div>
      </div>
   </div>

   <?php } }else{ ?>
   <div class="row">
      <div class="col-lg-12 mb-1 text-center">
         <div class="alert alert-info p-1">No profiles found...</div>
      </div>
   </div>
   <?php } ?>