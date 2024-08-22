<form class="form" id="myForm" enctype="multipart/form-data" novalidate>
   <div class="alert alert-info text-center p-1">You are adding <b><?php echo $template['services_name'] ?></b> to the profile <b><?php echo $profile['name'] ?></b></div>
   <input type="hidden" name="workorders_id" value="<?php echo $profile['workorders_id'] ?>">
   <input type="hidden" name="workorder_profiles_id" value="<?php echo $profile['id'] ?>">
   <input type="hidden" name="services_id" value="<?php echo $template['services_id'] ?>">
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12 mb-0">
            <?php echo $html_data ?> 
         </div>  
         <div class="col-lg-12 mb-2">
            <label>Comments</label>
            <textarea class="form-control" name="comments" rows="1"></textarea>
         </div>
         <div class="col-lg-6 mb-2">
            <label>Put check to</label>
            <select class="form-select" name="status" required>
            <?php  
               if(!empty($workflow)){
                     foreach($workflow as $flow_row){
                        if($flow_row['id']<=4){
            ?>
               <option value="<?php echo $flow_row['id'] ?>"><?php echo $flow_row['name'] ?></option>
            <?php } } } ?>
            </select>
         </div>

         <?php 
         // print_r($template);
         // exit();
            if($template['services_execution_type']==55){
               $vendors=$this->curl->execute("vendors","GET",array('sortby'=>'vendors.name','orderby'=>'ASC'));
               if(!empty($vendors['data_list'])){
         ?>
         <div class="col-lg-6 mb-2">
            <label>Vendor to execute</label>
            <select class="form-select" name="executor_id" required>
               <option value="">--select--</option>
            <?php foreach($vendors['data_list'] as $vendor){ ?>
               <option value="<?php echo $vendor['id'] ?>" <?php if($template['services_executor_id']==$vendor['id']){ echo "selected";} ?>><?php echo $vendor['name'] ?></option>
            <?php } ?>
            </select>
         </div>
         <?php } } ?>
         <div class=" col-lg-12  d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary"><i class="ft-plus"></i> Submit</button>
         </div>        
      </div>
</form>