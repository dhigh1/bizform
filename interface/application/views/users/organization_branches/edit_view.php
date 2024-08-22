<form class="form" id="myForm" novalidate>
   <div class="div_res"></div>
   <input type="hidden" name="id" value="<?php echo $data_list['id'] ?>">
      <div class="row">
         <div class="col-lg-4  ">
            <div class=" mb-1">
               <label for=""> Name<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="name" 
                  id="" placeholder=" " value="<?php echo $data_list['name'] ?>" 
                  required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Email <span class="text-danger">*</span></label>
               <input type="email" class="form-control" name="email" value="<?php echo $data_list['email'] ?>"
                  placeholder=" " required />
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Phone <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="phone" value="<?php echo $data_list['phone'] ?>"
                  placeholder=" " required />
            </div>
         </div>

         <div class="col-lg-8 ">
            <div class=" mb-1">
               <label for="">Address <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="address"
                  id="" value="<?php echo $data_list['address'] ?>" 
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
                           if($data_list['countries_id']==$cc['id']){
                              echo '<option value="'.$cc['id'].'" selected>'.$cc['name'].'</option>';
                           }else{
                              echo '<option value="'.$cc['id'].'">'.$cc['name'].'</option>';
                           }
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
                  <?php 
                  if(isset($states) && !empty($data_list['countries_id'])){
                        if(is_array($states['data_list'])){
                        foreach($states['data_list'] as $s=>$ss){
                           if($data_list['states_id']==$ss['id']){
                              echo '<option value="'.$ss['id'].'" selected>'.$ss['name'].'</option>';
                           }else{
                              echo '<option value="'.$ss['id'].'">'.$ss['name'].'</option>';
                           }
                        }
                     } 
                  } 
                  ?>
               </select>
            </div>
         </div>
         <div class="col-lg-4 ">
            <div class=" mb-1">
               <label>City <span class="text-danger">*</span></label>
               <select class="select2_city" name="cities_id" id="city_select">
                  <option></option>
                  <?php 
                  if(isset($cities) && !empty($data_list['states_id'])){
                        if(is_array($cities['data_list'])){
                        foreach($cities['data_list'] as $ct=>$ctt){
                           if($data_list['cities_id']==$ctt['id']){
                              echo '<option value="'.$ctt['id'].'" selected>'.$ctt['name'].'</option>';
                           }else{
                              echo '<option value="'.$ctt['id'].'">'.$ctt['name'].'</option>';
                           }
                        }
                     } 
                  } 
                  ?>
               </select>
            </div>
         </div>
         <div class="col-lg-4">
            <div class=" mb-1">
               <label for=""> Pincode <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="pincode" value="<?php echo $data_list['pincode'] ?>"
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