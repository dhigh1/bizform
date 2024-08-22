<form class="form" id="myForm" novalidate>
   <input type="hidden" name="branch" value="<?php echo $branch_id ?>">
   <div class="div_res"></div>
   <div class="row">
      <?php 
      $parent=0;
      if(isset($data_list) && !empty($data_list)){ 
         $parent=$data_list['id'];
      ?>
      <div class="col-lg-12">
         <div class=" mb-1">
            <label for=""> Parent Department*</label>
            <input type="text" class="form-control" name="" value="<?php echo $data_list['name'] ?>" disabled />
         </div>
      </div>
      <?php } ?>
      <input type="hidden" name="parent" value="<?php echo $parent ?>">
      <div class="col-lg-12">
         <div class=" mb-1">
            <label for=""> Department Name *</label>
            <input type="name" class="form-control" name="name"
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
</form>