<form class="form" id="myForm" novalidate>
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Login Id<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="login_id" 
                  id="" placeholder=" "
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> First Name<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="first_name" 
                  id="" placeholder=" "
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Last Name<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="last_name" 
                  id="" placeholder=" "
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Email</label>
               <input type="email" class="form-control" name="email" 
                  id="" placeholder=" "
                   />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Mobile<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="mobile" 
                  id="" placeholder=" "
                  required />
            </div>
         </div>
         <!-- <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Date of Birth<span class="text-danger">*</span> </label>
               <input type="date" class="form-control" name="dob" 
                  id="" placeholder=" "
                  required />
            </div>
         </div>
         <div class="col-lg-6">
            <div class=" mb-1">
               <label for="">  Address for Communication <span class="text-danger">*</span> </label>
               <textarea class="form-control" name="temp_address" rows="2" required></textarea>
            </div>
         </div>
         <div class="col-lg-6">
            <div class=" mb-1">
               <label for="">  Permanent Address <span class="text-danger">*</span> </label>
               <textarea class="form-control" name="perma_address" rows="2" required></textarea>
            </div>
         </div> -->
         <div class="col-lg-4">
            <div class=" mb-1">
               <label>Works in the branch <span class="text-danger">*</span></label>
               <select class="select2_branch" name="branch_id" id="branch_select" required>
                  <option></option>
                  <?php 
                     if(is_array($branch_data['data_list'])){
                        foreach($branch_data['data_list'] as $branch){
                           echo '<option value="'.$branch['id'].'">'.$branch['name'].'</option>';
                        }
                     } 
                  ?>
               </select>
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label>Works in the department <span class="text-danger">*</span></label>
               <select class="select2_dept" name="departments_id" id="dept_select" required>
                  <option></option>                 
               </select>
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label>Works as (Role) <span class="text-danger">*</span></label>
               <select class="select2_role" name="roles_id" id="role_select" required>
                  <option></option>
               </select>
            </div>
         </div>
         <!-- <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> User Class Level<span class="text-danger">*</span> </label>
               <select class="form-select" name="class_level" required>
                  <option value="">--select--</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
               </select>
            </div>
         </div> -->
         <!-- <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Extension Number<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="ext_number" 
                  id="" placeholder=" "
                  required />
            </div>
         </div> -->
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for="">Set Password<span class="text-danger">*</span></label>
               <div class="input-group input-group-merge">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
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
         <?php } ?>
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