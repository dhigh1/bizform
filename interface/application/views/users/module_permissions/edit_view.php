<form class="form" id="myForm" novalidate>
   <input type="hidden" name="id" value="<?php echo $data_list['id'] ?>">
   <input type="hidden" name="modules_id" value="<?php echo $modules_id ?>">
   <div class="div_res"></div>
      <div class="row">
         <?php
            $parent=0; 
            $module_name=$module_data['name'];
            if(isset($parent_data)){
         ?>
         <div class="col-lg-12">
            <div class="alert alert-info text-center">Adding a method under <b><?php echo $module_name.' --> '.$parent_data['name'] ?></b></div>
         </div>
         <?php } ?>
         <input type="hidden" name="parent" value="<?php echo $data_list['parent'] ?>">
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Name* </label>
               <input type="text" class="form-control" name="name" value="<?php echo $data_list['name'] ?>" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Interface URL* </label>
               <input type="text" class="form-control" name="ui_url" value="<?php echo $data_list['ui_url'] ?>" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> API URL*</label>
               <input type="text" class="form-control" name="api_url" value="<?php echo $data_list['api_url'] ?>" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> API Method</label>
               <input type="text" class="form-control" name="api_method" value="<?php echo $data_list['api_method'] ?>"/>
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Status* </label>
               <select class="form-select" name="status">
                  <option value="16">Active</option>
                  <option value="17">Inactive</option>
               </select>
            </div>
         </div>
         <script type="text/javascript">$('[name=status]').val('<?php echo $data_list['status'] ?>');</script>

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
   </div>
</form>