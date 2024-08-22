<form class="form" id="myForm" novalidate>
   <div class="alert alert-info text-center p-1">You are adding <b><?php echo $data_row['services_name'] ?></b> to the profile <b><?php echo $data_row['workorders_profiles_name'] ?></b></div>
   <input type="hidden" name="id" value="<?php echo $data_row['id'] ?>">
   <input type="hidden" name="workorders_id" value="<?php echo $data_row['workorders_id'] ?>">
   <input type="hidden" name="workorder_profiles_id" value="<?php echo $data_row['workorder_profiles_id'] ?>">
   <input type="hidden" name="services_id" value="<?php echo $data_row['services_id'] ?>">
   <div class="div_res"></div>
      <div class="row">
         <div class="col-lg-12 mb-1">
            <?php echo $html_data ?>
         </div> 
         <div class="col-lg-12 mb-2">
            <label>Comments</label>
            <textarea class="form-control" name="comments" rows="1"><?php echo $data_row['comments'] ?></textarea>
         </div>
         <div class=" col-lg-12  d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary"><i class="ft-plus"></i> Submit</button>
         </div>        
      </div>
</form>
