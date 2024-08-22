<style type="text/css">
   .swal2-popup .swal2-title {
      font-size: 17px !important;
      font-weight: 400 !important;
   }
</style>
<?php 
   $report_prm=User::check_permission('workorders/delete_data','check');
   $activity_prm=User::check_permission('workorders/get_reports_download_workorder','check');
?>
<div class="work-order-view-page">

   <!-- start page title -->
   <div class="row">
      <!-- <div class="col-12">
         <div class="text-left">
            <a href="javascript:history.go(-1)"><i class="fa fa-mail-reply"></i> Go back</a>
         </div>
      </div> -->
      <div class="col-12">
           <div class="page-title-box" style="margin-top: 15px;">
               
               <div class="page-title-right">
                   <ol class="breadcrumb m-0">
                       <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                       <li class="breadcrumb-item"><a href="<?php echo base_url() ?>workorders">Workorders</a></li>
                       <li class="breadcrumb-item active">View</li>
                   </ol>
               </div>
               <a href="<?php echo base_url() ?>workorders"><i class="mdi mdi-reply-circle"></i> Go back</a>
               <h4 class="page-title" style="line-height: 30px;">View Workorder</h4>
           </div>
       </div>
   </div>
   <!-- end page title -->

   <div class="row">
      <div class="col-lg-12 mb-2">                                         
         <div class="card mb-md-0 mb-3 user_permi_box ">
            <div class="card-body p-0">
               <div class="head_panel d-flex justify-content-between">
                  <h5 class="card-title mb-0">Details</h5>
                  <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-down"></i></a>
               </div>      
               <div class="content_panel p-2 active">
                  <div class="row">
                     <div class="col-lg-6 col-12">
                        <table class="table table-bordered table-centered mb-0">
                           <tbody>
                              <tr>
                                 <td class="data-label">Workorder ID</td>
                                 <td class="data-value"><?php echo $workorder['code'] ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Created</td>
                                 <td class="data-value">
                                    <?php if(!empty($workorder['created_at'])){echo custom_date('d-M-Y h:i:s A',$workorder['created_at']);} ?>
                                    <?php if(!empty($workorder['created_username'])){echo ' | '. ucwords($workorder['created_username']);} ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="data-label">Last Updated</td>
                                 <td class="data-value">
                                    <?php if(!empty($workorder['updated_at'])){echo custom_date('d-M-Y h:i:s A',$workorder['updated_at']);}else{ echo "---"; } ?>
                                    <?php if(!empty($workorder['updated_username'])){echo ' | '. ucwords($workorder['updated_username']);} ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="data-label">Status</td>
                                 <td class="data-value">
                                    <?php echo '<span class="'.$workorder['status_color_name'].'">'.$workorder['status_name'].'</span>' ?>
                                 </td>
                              </tr>

                              <tr>
                                 <td class="data-label">Actions</td>
                                 <td class="data-actions">
                                    <?php if($activity_prm){ ?>
                                    <span class="badge badge-outline-dark rounded-pill workorderActivity" data-id="<?php echo $workorder['id'] ?>"><i class="mdi mdi-clock"></i> Activity</span>
                                    <?php } ?>

                                    <?php if($report_prm){ ?>
                                    <span class="badge badge-outline-success rounded-pill ml-1 getAllReport" data-module="workorder" data-code="<?php echo $workorder['code'] ?>" data-folder="<?php echo create_slug($workorder['code']) ?>" data-id="<?php echo $workorder['id'] ?>"><i class="mdi mdi-file-document"></i> Get Reports</span>
                                    <?php } ?>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="col-lg-6 col-12">
                        <table class="table table-bordered table-centered mb-0">
                           <tbody>
                              <tr>
                                 <td class="data-label">Customer</td>
                                 <td class="data-value"><?php echo $workorder['customers_name'] ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Branch</td>
                                 <td class="data-value"><?php echo $workorder['customer_branches_name'] ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Contact Person</td>
                                 <td class="data-value"><?php echo $workorder['customer_branch_person_name'] ?></td>
                              </tr>
                              <tr>
                                 <td class="data-label">Contact Details</td>
                                 <td class="data-value"><?php echo $workorder['customer_branch_person_email'].' | '.$workorder['customer_branch_person_phone'] ?></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

<?php 
   $add_profile_prm=User::check_permission('workorders/add_profile','check');
   $profile_import_prm=User::check_permission('workorders/get_profile_import','check');

   $grid_view=User::check_permission('workorders/get_profiles_list_table','check');
   $grid_move=User::check_permission('workorders/get_profiles_list_bulk_move','check');
   $grid_edit=User::check_permission('workorders/get_profiles_list_bulk_edit','check');
?>
   <div class="row">
      <div class="col-lg-6">
         <div class="dataGridHolder">
            <button type="button" class="btn btn-sm btn-light dataViewToggler" title="Individual Profile List" data-type="buckets"><i class="mdi mdi-view-agenda-outline"></i></button>
            
            <?php if($grid_view){ ?>
            <button type="button" class="btn btn-sm btn-light dataViewToggler" title="Table View" data-type="table"><i class="mdi mdi-table-eye"></i></button>
            <?php } ?>
            <?php if($grid_move){ ?>
            <button type="button" class="btn btn-sm btn-light dataViewToggler" title="Bulk Move" data-type="bulk_move"><i class="mdi mdi-folder-move-outline"></i></button>
            <?php } ?>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="text-sm-end mb-2">
            <?php if($add_profile_prm){ ?> 
            <button class="btn btn-primary rounded-pill btn-sm addProfile" data-mid="<?php echo $workorder['id'] ?>"><i class="mdi mdi-plus-circle"></i> Add Profile</button>
            <?php } ?>

            <?php if($profile_import_prm){ ?>
            <button type="button" class="btn btn-dark rounded-pill importProfiles hide btn-sm ml-1" data-id="<?php echo $workorder['id'] ?>"><i class="mdi mdi-cloud-download"></i> Bulk Import</button>
            <?php } ?>

            <button type="button" class="btn btn-success rounded-pill refreshData hide btn-sm ml-1"><i class="mdi mdi-cloud-refresh"></i> Refresh Data</button>
         </div>
      </div>
   </div>

<?php if($grid_view){ ?>
<div class="bulk-actions-sec">
<!-- <hr> -->
   <div class="row">
      <div class="col-lg-12">
         <div class="dataGridHolder pt-0 pb-1">
            <div class="row d-flex align-items-center">
               <div class="col-lg-12">
                  <label>Select check type for bulk operation</label>
               </div>
               <div class="col-lg-4">
                  <select class="form-select padding-custom" name="edit_service" id="get_service_edit">
                     <option value="">--select--</option>
                     <?php 
                        $checkType='';
                        if(isset($_GET['checkType']) && $_GET['checkType']!=''){
                           $checkType=$_GET['checkType'];
                        }
                        if(isset($services) && !empty($services)){ 
                        foreach($services as $service){ 

                     ?>
                     <option value="<?php echo $service['services_code'] ?>" <?php if($checkType>0 && $checkType==$service['services_code']){ echo 'selected';} ?>><?php echo $service['services_name'] ?></option>
                     <?php } } ?>
                  </select>
               </div>
               <div class="col-lg-6">
                  <?php if($grid_edit){ ?>
                  <button type="button" class="btn btn-sm btn-light dataViewToggler" title="Bulk Edit" data-type="bulk_edit"><i class="mdi mdi-table-edit"></i></button>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
<hr>
</div>
<?php } ?>
   <div id="Tbl" data-id="<?php echo $workorder['id'] ?>"></div>

   <?php if($add_profile_prm){ ?>
   <div class="row">
      <div class="col-lg-12 mb-2 text-end">
         <button class="btn btn-primary addProfile" data-mid="<?php echo $workorder['id'] ?>"><i class="mdi mdi-plus-circle"></i> Add Profile</button>
      </div>
   </div>
   <?php } ?>


</div>