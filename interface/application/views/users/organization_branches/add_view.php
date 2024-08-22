<form class="form" id="myForm" novalidate>
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-4  ">
            <div class=" mb-1">
               <label for=""> Name<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="name" 
                  id="" placeholder=" "
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Email <span class="text-danger">*</span></label>
               <input type="email" class="form-control" name="email"
                  placeholder=" " required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Phone <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="phone"
                  placeholder=" " required />
            </div>
         </div>

         <div class="col-lg-8 ">
            <div class=" mb-1">
               <label for="">Address <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="address"
                  placeholder="" required />
            </div>
         </div>

         <div class="col-lg-4 ">
            <div class=" mb-1">
               <label>Country <span class="text-danger">*</span></label>
               <select class="select2_country" name="countries_id" id="country_select">
                  <option></option>
                  <?php 
                     if(is_array($countries['data_list'])){
                        foreach($countries['data_list'] as $c=>$cc){
                           echo '<option value="'.$cc['id'].'">'.$cc['name'].'</option>';
                        }
                     } 
                  ?>
               </select>
            </div>
         </div>
         <div class="col-lg-4 ">
            <div class=" mb-1">
               <label>State <span class="text-danger">*</span></label>
               <select class="select2_state" name="states_id" id="state_select">
                  <option></option>
               </select>
            </div>
         </div>
         <div class="col-lg-4 ">
            <div class=" mb-1">
               <label>City <span class="text-danger">*</span></label>
               <select class="select2_city" name="cities_id" id="city_select">
                  <option></option>
               </select>
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Pincode <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="pincode"
                  placeholder=" " required />
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