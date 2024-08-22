<div class="row">
    <div class="col-12">
        <div class="alert alert-info text-center custom-alert-content">Permissions for the role <b><?php echo $role['name'] ?></b> of <b><?php echo $role['departments_name'] ?></b> department in <b><?php echo $role['organization_branches_name'] ?></b> branch.</div>
    </div>
</div>

<form id="permissionForm" class="permissions-form">
   <input type="hidden" name="roles_id" value="<?php echo $role['id'] ?>">
   <div class="row">
      <?php 
         $permissions_arr[]='';
         foreach($permissions as $outer_key => $array)
         { 
             $permissions_arr[] = $array['module_permissions_id']; 
         }
         if(!empty($modules) && is_array($modules)){
            foreach($modules as $module){
      ?>
      <div class="col-lg-4 mb-3">                                         
         <div class="card mb-md-0 mb-3 user_permi_box ">
            <div class="card-body p-0">
               <div class="head_panel d-flex justify-content-between">
                  <h5 class="card-title mb-0"> <?php echo $module['name'] ?> </h5>
                  <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-down"></i></a>
               </div>      
               <div class="content_panel p-2 active">
                  <div class="row">
                  <?php 
                     $count=0;
                     if(!empty($submodules) && is_array($submodules)){
                        foreach ($submodules as $t) {
                           if($t['modules_id']==$module['id']){
                              $count++;
                           }
                        }
                        if($count>0){
                           printPermissionTree($permissions_arr,$submodules,$module['id']);
                        }else{
                           echo '<div class="col-12" class="text-center"><p class="mb-0 small">No permissions found</p></div>';
                        }
                     }
                  ?>
                  </div>
               </div>
            </div>
         </div> <!-- end card-->
      </div>
      <?php } }else{ ?>
      <div class="col-lg-12">
         <div class="alert alert-danger">No modules found!</div>
      </div>
      <?php } ?>
   </div>
   <hr>
   <div class="col-lg-12 text-center ">
      <button type="submit" class="btn btn-primary">Submit</button>
   </div>
</form>

<?php 
   

   function printPermissionTree($permissions_arr,$tree,$modules_id,$r = 0, $p = null) {
      foreach ($tree as $i => $t) {
         if($t['modules_id']==$modules_id){
            if(in_array($t['id'],$permissions_arr)){
               $checked='checked';
            }else{
               $checked='';
            }
            // if($t['parent'] == 0 && empty($t['api_method'])){
            if($t['parent'] == 0){
               echo '<div class="col-lg-12 col-12">';
            }else{
               echo '<div class="col-lg-4 col-12">';
            }
            echo '<div class="form-check mb-1">';
            echo '<input type="checkbox" class="form-check-input" name="module_permissions_id[]" value="'.$t['id'].'" '.$checked.'>';
            echo '<label class="form-check-label">'.$t['name'].'</label>';
            echo '</div></div>';
            if ($t['parent'] == $p) {
               $r = 0;
            }
            //print_r($t);
            if (isset($t['_children'])) {           
               printPermissionTree($permissions_arr,$t['_children'],$modules_id, $r+1, $t['parent']);
            }
         }
      }
      //return $output;
   }
?>