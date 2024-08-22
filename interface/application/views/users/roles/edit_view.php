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
         <div class="mt-1 mb-1">
            <label>Department *</label>
            <?php if (!empty($data_list['departments_id'])) { ?>
               <select class="form-select" name="departments_id" required>
                  <option value="<?php echo $data_list['departments_id'] ?>" selected><?php echo $data_list['departments_name'] ?></option>
               </select>
            <?php } else { ?>
               <select class="select2_dept" name="departments_id" id="dept_select" required>
                  <option></option>

               </select>
            <?php } ?>
            <!-- <select class="select2_dept" name="departments_id" id="dept_select" required>
                  <option></option>                 
               </select> -->
         </div>
      </div>
      <div class="col-lg-12">
         <div class="mt-1 mb-1">
            <label>Status *</label>
            <select class="form-select" name="status">
               <option value="5" <?php echo ($data_list['status'] == 5) ? 'selected' : '' ?>>Active</option>
               <option value="6" <?php echo ($data_list['status'] == 6) ? 'selected' : '' ?>>InActive</option>
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