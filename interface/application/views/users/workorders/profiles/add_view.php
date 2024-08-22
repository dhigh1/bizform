<form class="form" id="myForm" novalidate>
   <input type="hidden" name="workorders_id" value="<?php echo $workorders_id ?>">
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12 mb-1">
            <label>Customer Ref. Id*</label>
            <input type="text" name="ref_id" class="form-control" required>
         </div>  
         <div class="col-lg-12 mb-1">
            <label>Name*</label>
            <input type="text" name="name" class="form-control" required>
         </div>  
         <div class="col-lg-12 mb-1">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
         </div>  
         <div class="col-lg-12 mb-1">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
         </div>         
         <div class="col-lg-12 mb-1">
            <label>Comments </label>
            <textarea class="form-control" name="comments" rows="1"></textarea>
         </div>
         <div class=" col-lg-12  d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary"><i class="ft-plus"></i> Submit</button>
         </div>        
      </div>
</form>