<?php 
   if($branch_data['status']=='success' && !empty($branch_data['data_list'])){ 
      $branchData=$branch_data['data_list'];
?>
<div class="row mb-2">
   <div class="col-sm-4">
      <a class="btn btn-danger mb-2 addData" data-mid="<?php echo $branchData['id']; ?>"><i
         class="mdi mdi-plus-circle me-1"></i> Add Department </a>
   </div>
</div>

<div class="row mb-2">
   <div class="col-sm-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
                 <div class="col-lg-6 mx-auto">
                     <div class="card border-light border text-center bg-default  text-dark">
                         <div class="card-body">
                           <h5 class="card-title"><u>Departments belongs to the Branch</u></h5>
                           <h5 class="card-title"><?php echo $branchData['name'] ?> </h5>
                             <p class="card-text"><?php echo $branchData['address'].', '.$branchData['city'].', '.$branchData['state'].', '.$branchData['country'].', '.$branchData['pincode'] ?></p>                 
                         </div> <!-- end card-body-->
                     </div> <!-- end card-->
                 </div> <!-- end col-->
             </div>

            <div class="row mb-2">
               <div class="col-sm-12">
                  <div class="departments-chart">
                     <div class="tree">
                     <?php
                        //print_r($depts_data);
                        if($depts_data['status']=='success' && !empty($depts_data['data_list']) && is_array($depts_data['data_list'])){ 
                           $depts_list=$depts_data['data_list']; 
                              echo make_ulli($depts_list,$branchData['id']); 
                     ?>
                     </div>
                  </div>
               <?php }else{ ?>
                        <div class="alert alert-info text-center">No departments found in this branch...</div>
               <?php } ?>
               </div>
            </div>

            <?php }else{ ?>
               <div class="alert alert-danger text-center">The branch you are looking for is not exists!</div>
            <?php } ?>
         </div>
      </div>
   </div>
</div>


<?php 


function make_ulli($array,$branch_id){
   if(!is_array($array)) return '';
   foreach ($array as $key => $item) {
      if($item['parent']==0){
         $ul_class = "";
      }else{
         $parent_exists=1;
         $ul_class = "childrens-list";
      }
   }
   $output = '<ul class="'.$ul_class.'">';
   foreach($array as $item){  
         if($item['parent']==0){
            $li_class='has-children';
         }else{
            $li_class='no-children';
         }
        $output .= '<li class="'.$li_class.'"><a><span>' . $item['name'].'</span>';
        $output .= '<span class="dept_action_box">
                        <span class="action-icon text-info editData" data-id="'.$item['id'].'" data-mid="'.$branch_id.'"> <i class="mdi mdi-square-edit-outline"></i></span>
                        <span class="action-icon text-primary addData" data-id="'.$item['id'].'" data-mid="'.$branch_id.'"> <i class="mdi mdi-plus"></i></span>
                        <span class="action-icon text-danger deleteData" data-id="'.$item['id'].'" data-mid="'.$branch_id.'"> <i class="mdi mdi-delete"></i></span>
                    </span>';
         $output .= '</a>';                    

        if(isset($item['_children']))
            $output .= make_ulli($item['_children'],$branch_id);

        $output .= '</li>';

   }
   $output .= '</ul>';
   return $output;
}
  
?>