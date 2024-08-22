<form class="form" id="myForm" novalidate>
   <input type="hidden" name="workorders_id" value="<?php echo $data_row['workorders_id'] ?>">
   <input type="hidden" name="id" value="<?php echo $data_row['id'] ?>">
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12 mb-1">
            <label>Customer Ref. Id*</label>
            <input type="text" name="ref_id" class="form-control" value="<?php echo $data_row['ref_id'] ?>" required>
         </div>  
         <div class="col-lg-12 mb-1">
            <label>Name*</label>
            <input type="text" name="name" class="form-control" value="<?php echo $data_row['name'] ?>" required>
         </div>  
         <div class="col-lg-12 mb-1">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $data_row['email'] ?>">
         </div>  
         <div class="col-lg-12 mb-1">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo $data_row['phone'] ?>">
         </div>         
         <div class="col-lg-12 mb-1">
            <label>Comments </label>
            <textarea class="form-control" name="comments" rows="1"><?php echo $data_row['comments'] ?></textarea>
         </div>
         <div class=" col-lg-12  d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary"><i class="ft-plus"></i> Submit</button>
         </div>        
      </div>
</form>