<form class="form" id="myForm" novalidate>
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Name* </label>
               <input type="text" class="form-control" name="name" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label>Organization Branch *</label>
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
         <div class="col-lg-12">
            <div class="mt-1 mb-1">
               <label>Department *</label>
               <select class="select2_dept" name="departments_id" id="dept_select" required>
                  <option></option>                 
               </select>
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mt-1">
               <span class="small text-danger">*Be cautious while selecting organization branch and department, you cannot change after creation!</span>
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