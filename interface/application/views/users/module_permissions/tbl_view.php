<div class="mb-3">
<div class="row">
<?php 
   $modules=$this->curl->execute("modules","GET",array('perpage'=>100,'sortby'=>'modules-name','orderby'=>'ASC'));
   $modules=$modules['data_list'];
   if(!empty($modules) && is_array($modules)){
      foreach($modules as $module){
?>

<div class="col-lg-12 mb-3">                                         
   <div class="card mb-md-0 mb-3 user_permi_box ">
      <div class="card-body p-0">
         <div class="head_panel d-flex justify-content-between">
            <h5 class="card-title mb-0"> <?php echo $module['name'] ?> </h5>
            <a class="btn_colaps" role="button"><i class="mdi mdi-chevron-down"></i></a>
         </div>      
         <div class="content_panel p-2 active">
              <div class="table-responsive">
               <table class="table table-bordered mb-0">
                  <thead>
                     <th>Name</th>
                     <th>UI URL</th>
                     <th>API URL</th>
                     <th>API Method</th>
                     <th>Created</th>
                     <th>Updated</th>
                     <th>Status</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                  <?php 
                  $count=0;
                  if(!empty($data_list) && is_array($data_list)){
                     foreach ($data_list as $t) {
                        if($t['modules_id']==$module['id']){
                           $count++;
                        }
                     }
                     if($count>0){
                        printPermissionTree($data_list,$module['id']);
                     }else{
                        echo '<tr class="text-center"><td colspan="7">No permissions found</td></tr>';
                     }
                     //print_r($data_list);
                  }
                  ?>

                  </tbody>
               </table>
              </div>
               <div class="text-end">
                 <a class="btn btn-danger mt-2 addData table-btn-sm" data-mid="<?php echo $module['id'] ?>"><i class="mdi mdi-plus-circle me-1"></i> Add New </a>
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
</div>

<?php 
   function printPermissionTree($tree,$modules_id,$r = 0, $p = null) {
      foreach ($tree as $i => $t) {
         if($t['modules_id']==$modules_id){
             $dash = ($t['parent'] == 0) ? '' : str_repeat('-', $r) .'';
             echo "<tr>";
             echo "<td>".$dash.' '.$t['name']."</td>";
             echo "<td>".$t['ui_url']."</td>";
             echo "<td>".$t['api_url']."</td>";
             echo "<td>".$t['api_method']."</td>";
             echo "<td>";
             echo custom_date('d-M-Y h:i:s A',$t['created_at']);
            if(!empty($t['created_username'])){echo '<br>By - '.ucwords($t['created_username']);}
            echo "</td>";
            echo "<td>";
            if(!empty($t['updated_at'])){echo custom_date('d-M-Y h:i A',$t['updated_at']);}else{ echo '---';}
            if(!empty($t['updated_username'])){echo '<br>By - '.ucwords($t['updated_username']);}
            echo "</td>";
            echo "<td><span class='".$t['status_color_name']."'>".$t['status_name']."</span></td>";
            echo '<td class="table-action">
                  <a href="javascript:;" class="action-icon text-info addData" data-mid="'.$t['modules_id'].'" data-id="'.$t['id'].'"> <i class="mdi mdi-plus-circle"></i></a>
                  <a href="javascript:;" class="action-icon text-primary editData" data-mid="'.$t['modules_id'].'" data-id="'.$t['id'].'"> <i class="mdi mdi-pencil"></i></a>
                  <a href="javascript:;" class="action-icon text-danger deleteData" data-mid="'.$t['modules_id'].'" data-id="'.$t['id'].'"> <i class="mdi mdi-delete"></i></a>
               </td>';
             echo "</tr>";
             if ($t['parent'] == $p) {
                 $r = 0;
             }
            if (isset($t['_children'])) {           
              printPermissionTree($t['_children'],$modules_id, $r+1, $t['parent']);
            }
         }
      }
   }
?>