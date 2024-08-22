<form class="form" id="myForm" novalidate>
   <input type="hidden" name="id" value="<?php echo $data_list['id'] ?>">
   <div class="div_res"></div>
      <div class="row">

         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Customer Id* </label>
               <input type="text" class="form-control" name="customer_code"  value="<?php echo $data_list['customer_code'] ?>" required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Name* </label>
               <input type="text" class="form-control" name="name"  value="<?php echo $data_list['name'] ?>"
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Email* </label>
               <input type="email" class="form-control" name="email"  value="<?php echo $data_list['email'] ?>"
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Phone* </label>
               <input type="text" class="form-control" name="phone"  value="<?php echo $data_list['phone'] ?>"
                  required />
            </div>
         </div>
         <div class="col-lg-8">
            <div class=" mb-1">
               <label for="">  Registred Address* </label>
               <textarea class="form-control" name="address" rows="1" required><?php echo $data_list['address'] ?></textarea>
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Status* </label>
               <select class="form-select" name="status"required>
                  <option value="18">Active</option>
                  <option value="19">Suspend</option>
               </select>
            </div>
         </div>
      </div>
      <div class="form-group overflow-hidden">
         <div class="row ">
            <div class=" col-lg-12  d-flex justify-content-end  mt-2">
               <button type="submit" class="btn btn-primary">
               <i class="ft-plus"></i> Submit
               </button>
            </div>
        
         </div>
      </div>
   </div>
</form>

<script type="text/javascript">
   $('#dept_select').val('<?php echo $data_list['departments_id'] ?>');
   $('#branch_select').val('<?php echo $data_list['organization_branches_id'] ?>');
   $('#role_select').val('<?php echo $data_list['roles_id'] ?>');
   $('[name=class_level]').val('<?php echo $data_list['class_level'] ?>');
   $('[name=status]').val('<?php echo $data_list['status'] ?>');
</script>