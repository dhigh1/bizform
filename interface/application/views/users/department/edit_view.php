<form class="form" id="myForm" novalidate>
   <input type="hidden" name="id" value="<?php echo $data_list['id'] ?>">
   <input type="hidden" name="branch" value="<?php echo $branch_id ?>">
   <input type="hidden" name="parent" value="<?php echo $data_list['parent'] ?>">
   <div class="div_res"></div>
   <div class="row">
      <?php if(!empty($data_list['parent_name']) && $data_list['parent']>0){ ?>
      <div class="col-lg-12">
         <div class=" mb-1">
            <label for=""> Parent Department*</label>
            <input type="text" class="form-control" name="" value="<?php echo $data_list['parent_name'] ?>" disabled />
         </div>
      </div>
      <?php } ?>
      <div class="col-lg-12">
         <div class=" mb-1">
            <label for=""> Department Name *</label>
            <input type="text" class="form-control" name="name" value="<?php echo $data_list['name'] ?>" required />
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