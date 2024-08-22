<form class="form" id="myForm" novalidate>
   <input type="hidden" name="id" value="<?php echo $data_list['id'] ?>">
   <div class="div_res"></div>
      <div class="row">

         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Login Id<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="login_id"  value="<?php echo $data_list['login_id'] ?>" required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> First Name<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="first_name"  value="<?php echo $data_list['first_name'] ?>"
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Last Name<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="last_name"  value="<?php echo $data_list['last_name'] ?>"
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Email</label>
               <input type="email" class="form-control" name="email"  value="<?php echo $data_list['email'] ?>"
                   />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Mobile<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="mobile"  value="<?php echo $data_list['mobile'] ?>"
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for="">New Password</label>
               <div class="input-group input-group-merge">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
            </div>
         </div>
         <?php if(User::is_admin()){ ?>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Super Admin </label>
               <select class="form-select" name="is_sadmin">
                  <option value="0" selected>No</option>
                  <option value="1">Yes</option>
               </select>
            </div>
         </div>
         <script type="text/javascript">
            $('[name=is_sadmin]').val('<?php echo $data_list['is_sadmin'] ?>');
         </script>
         <?php } ?>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Status<span class="text-danger">*</span> </label>
               <select class="form-select" name="status"required>
                  <option value="7" <?php echo ($data_list['status']==7)?'selected':'' ?>>Active</option>
                  <option value="8" <?php echo ($data_list['status']==8)?'selected':'' ?>>Suspend</option>
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