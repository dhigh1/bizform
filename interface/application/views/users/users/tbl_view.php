<div class="table-responsive">
   <table class="table table-centered table-bordered table-striped dt-responsive nowrap w-100" id="organization_brnch_table">
      <thead>
         <tr>
            <th>S.No.</th>
            <th>Login Id</th>    
            <th>Name</th>
            <th>Branch</th>               
            <th>Department</th>
            <th>Role</th>      
            <th>Created</th>                 
            <th>Updated</th>
            <th>Status</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php 
            if(is_array($data_list) && !empty($data_list)){
               $i=$pagination_data['slno'];
               foreach($data_list as $datas){
                  if($datas['id']>1){
         ?>
            <tr>
               <td><?php echo $i ?></td>
               <td><?php echo $datas['login_id'] ?></td>
               <td><?php echo $datas['first_name'].' '.$datas['last_name'] ?></td>
               <td><?php echo $datas['organization_branches_name'] ?></td>
               <td><?php echo $datas['departments_name'] ?></td>
               <td><?php echo $datas['roles_name'] ?></td>
               <td>
                  <?php echo custom_date('d-M-Y h:i A',$datas['created_at']); ?>
                  <?php if(!empty($datas['created_username'])){echo '<br>By - '.ucwords($datas['created_username']);} ?>
               </td>
               <td>
                  <?php if(!empty($datas['updated_at'])){echo custom_date('d-M-Y h:i A',$datas['updated_at']);}else{ echo '---';} ?>
                  <?php if(!empty($datas['updated_username'])){echo '<br>By - '.ucwords($datas['updated_username']);} ?>
               </td>
               <td><?php echo '<span class="'.$datas['status_color_name'].'">'.$datas['status_name'].'</span>' ?></td>
               <td class="table-action">
                  <a href="javascript:;" class="action-icon text-primary editData" data-id="<?php echo $datas['id'] ?>"> <i class="mdi mdi-pencil"></i></a>
                  <a href="javascript:;" class="action-icon text-danger deleteData" data-id="<?php echo $datas['id'] ?>"> <i class="mdi mdi-delete"></i></a>
               </td>
            </tr>
         <?php $i++;} } }else{ ?>
            <tr>
               <td colspan="8" class="text-center">No records found...</td>
            </tr>
         <?php } ?>
      </tbody>
   </table>
</div>
<div id="page_result">
   <?php if(isset($pagination_data['pagination_links'])){ echo $pagination_data['pagination_links'];} ?>
</div>