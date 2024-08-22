<form class="form" id="myForm" novalidate>
   <input type="hidden" name="id" value="<?php echo $data_list['id'] ?>">
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Name* </label>
               <input type="text" class="form-control" name="name" value="<?php echo $data_list['name'] ?>" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Table Name* </label>
               <input type="text" class="form-control" name="table_name" value="<?php echo $data_list['table_name'] ?>" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Status* </label>
               <select class="form-select" name="status">
                  <option value="14" <?php echo ($data_list['status']==14)?'selected':'' ?>>Active</option>
                  <option value="15" <?php echo ($data_list['status']==15)?'selected':'' ?>>Inactive</option>
               </select>
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
   </div>
</form>