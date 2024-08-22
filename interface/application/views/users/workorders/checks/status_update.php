<form class="form" id="myForm" novalidate>
   <div class="alert alert-info text-center p-1">You are adding <b><?php echo $data_row['services_name'] ?></b> to the profile <b><?php echo $data_row['workorders_profiles_name'] ?></b></div>
   <input type="hidden" name="id" value="<?php echo $data_row['id'] ?>">
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12 mb-1">
            <label>Put check to the flow</label>
            <select class="form-select" name="transition_id" required>
               <option value="">--select--</option>
            <?php 
               if(isset($transitions) && !empty($transitions)){
                  foreach($transitions as $row){
            ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
            <?php } } ?>
            </select>
         </div> 
         <div class="col-lg-12 mb-2">
            <label>Comments</label>
            <textarea class="form-control" name="comments" rows="1"></textarea>
         </div>
         <?php 
            if($data_row['services_execution_type']==55){
               $vendors=$this->curl->execute("vendors","GET",array('sortby'=>'vendors.name','orderby'=>'ASC'));
               if(!empty($vendors['data_list'])){
         ?>
         <div class="col-lg-6 mb-2">
            <label>Vendor to execute</label>
            <select class="form-select" name="executor_id" required>
               <option value="">--select--</option>
            <?php foreach($vendors['data_list'] as $vendor){ ?>
               <option value="<?php echo $vendor['id'] ?>" <?php if($data_row['services_executor_id']==$vendor['id']){ echo "selected";} ?>><?php echo $vendor['name'] ?></option>
            <?php } ?>
            </select>
         </div>
         <?php } } ?>
         
         <div class=" col-lg-12  d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary"><i class="ft-plus"></i> Submit</button>
         </div>        
      </div>
</form>