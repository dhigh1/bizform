<form class="form" id="myForm" novalidate>
   <input type="hidden" name="modules_id" value="<?php echo $modules_id ?>">
   <div class="div_res"></div>
      <div class="row">
         <?php
            $parent=0; 
            $module_name=$module_data['name'];
            $parent_name='';
            if(isset($parent_data)){
               $parent=$parent_data['id'];
               $parent_name=' --> '.$parent_data['name'];
         ?>
         <?php } ?>
         
         <div class="col-lg-12">
            <div class="alert alert-info text-center">Adding a method under <b><?php echo $module_name.$parent_name ?></b></div>
         </div> 
         <input type="hidden" name="parent" value="<?php echo $parent ?>">
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Name* </label>
               <input type="text" class="form-control" name="name" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Interface URL* </label>
               <input type="text" class="form-control" name="ui_url" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> API URL* </label>
               <input type="text" class="form-control" name="api_url" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> API Method</label>
               <input type="text" class="form-control" name="api_method" />
            </div>
         </div>
      </div>
      <div class="form-group overflow-hidden">
         <div class="row ">
            <div class=" col-lg-12  d-flex justify-content-end mt-2">
               <button type="submit" class="btn btn-primary">
               <i class="ft-plus"></i> Submit
               </button>
            </div>
        
         </div>
      </div>
</form>