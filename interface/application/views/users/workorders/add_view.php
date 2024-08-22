<form class="form" id="myForm" novalidate>
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12">
            <div class=" mb-1">
               <label>Customer *</label>
               <select class="select2_customer" name="customers_id" id="customer_select" required>
                  <option></option>
                  <?php 
                     if(is_array($company_list['data_list'])){
                        foreach($company_list['data_list'] as $company){
                           if(isset($customers_id)){
                              if($customers_id==$company['id']){
                              echo '<option value="'.$company['id'].'" selected>'.$company['customer_code'].'-'.$company['name'].'</option>';
                              }else{
                                 echo '<option value="'.$company['id'].'">'.$company['customer_code'].'-'.$company['name'].'</option>';
                              }
                           }else{
                              echo '<option value="'.$company['id'].'">'.$company['customer_code'].'-'.$company['name'].'</option>';
                           }
                        }
                     } 
                  ?>
               </select>
            </div> 
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label>Branch*</label>
               <select class="select2_cbranch" name="customer_branches_id" id="cbranch_select" required>
                  <option></option>
                  <?php 
                     if(isset($branch_list)){
                        if(is_array($branch_list['data_list'])){
                           foreach($branch_list['data_list'] as $branch){
                              if(isset($branches_id)){
                                 if($branches_id==$branch['id']){
                                 echo '<option value="'.$branch['id'].'" selected>'.$branch['branch_code'].'-'.$branch['name'].'</option>';
                                 }else{
                                    echo '<option value="'.$branch['id'].'">'.$branch['branch_code'].'-'.$branch['name'].'</option>';
                                 }
                              }else{
                                 echo '<option value="'.$branch['id'].'">'.$branch['branch_code'].'-'.$branch['name'].'</option>';
                              }
                           }
                        }
                     }
                  ?>
               </select>
            </div>
         </div>

         <div class="col-lg-12">
            <div class=" mb-1">
               <label>Contact Person*</label>
               <select class="select2_cbranch_person" name="customer_branches_persons_id" id="cbranch_person_select" required>
                  <option></option>
                  <?php 
                     if(isset($branch_list)){
                        if(is_array($branch_list['data_list'])){
                           foreach($branch_list['data_list'] as $branch){
                              if(isset($branches_id)){
                                 if($branches_id==$branch['id']){
                                 echo '<option value="'.$branch['id'].'" selected>'.$branch['branch_code'].'-'.$branch['name'].'</option>';
                                 }else{
                                    echo '<option value="'.$branch['id'].'">'.$branch['branch_code'].'-'.$branch['name'].'</option>';
                                 }
                              }else{
                                 echo '<option value="'.$branch['id'].'">'.$branch['branch_code'].'-'.$branch['name'].'</option>';
                              }
                           }
                        }
                     }
                  ?>
               </select>
            </div>
         </div>
         
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for="">  Comments </label>
               <textarea class="form-control" name="comments" rows="1"></textarea>
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