<script>
   get_form_categories_select2();
</script>

<form class="form" id="myForm" novalidate>
   <div class="div_res"></div> 
   <div class="row">
      <div class="col-12 mb-1">
         <label class="mb-0">
               Category<span class="text-danger">*</span>  &nbsp;&nbsp;&nbsp;
         </label>
         <select name="category_id" class="select2_form_categories" id="form_categories_select" required >
            <option></option>
            <?php

            if (is_array($categories)) {
               foreach ($categories as $category) {
                  echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
               }
            }
            ?>
         </select>
      </div>
      <div class="col-12 mb-1">
         <label class="mb-0">Form ID<span class="text-danger">*</span></label>
         <input type="text" name="form_code" class="form-control" value="" required>
      </div>
      <div class="col-12 mb-1">
         <label class="mb-0">Form name<span class="text-danger">*</span></label>
         <input type="text" name="name" class="form-control" value="" required>
      </div>
      <div class="col-12 mb-1">
         <label class="mb-0">Description</label>
         <textarea class="form-control" name="description" rows="1"></textarea>
      </div>
      <!-- <div class="col-12 mb-1 mt-1">
              <div class="form-check form-switch">
                  <input type="checkbox" class="form-check-input" id="copy_template" name="copy_template" value="yes">
                  <label class="form-check-label" for="copy_template">Copy fields from existing template</label>
              </div>
          </div> -->
   </div>
   <div class="form-group overflow-hidden">
      <div class="row ">
         <div class=" col-lg-12  d-flex align-items-center justify-content-end  mt-2">
            <a class="mx-2" href="<?php echo base_url() ?>form_categories"><i class="fa fa-plus text-danger"></i> Create New Category</a>
            <button type="submit" class="btn btn-primary"><i class="mdi mdi-check"></i> Submit</button>
         </div>
      </div>
   </div>
   </div>
</form>


<script>

</script>