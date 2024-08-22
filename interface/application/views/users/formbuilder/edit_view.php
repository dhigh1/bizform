<script>
  get_form_categories_select2();
</script>

<form class="form" id="myForm" novalidate>
   <div class="div_res"></div>
   <div class="row"> 
      <div class="col-12 mb-1">
         <label class="mb-0">Category<span class="text-danger">*</span></label>
         <select name="category_id" class="select2_form_categories" id="form_categories_select">
            <option></option>
            <?php 
               if(is_array($categories)){
                  foreach($categories as $category){
                     if($form['category_id']==$category['id']){
                        echo '<option selected value="' . $category['id'] . '">' . $category['name'] . '</option>';
                     }else{
                        echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                     }
                  }
               }
            ?>
         </select>
      </div>
      <div class="col-12 mb-1">
         <label class="mb-0">Form ID<span class="text-danger">*</span></label>
         <input type="text" name="form_code" class="form-control" value="<?php !empty($form['form_code']) ? print_r($form['form_code']) : '' ?>">
      </div>
      <div class="col-12 mb-1">
         <label class="mb-0">Form name<span class="text-danger">*</span></label>
         <input type="text" name="name" class="form-control" value="<?php !empty($form['form_code']) ? print_r($form['name']) : '' ?>">
      </div>
      <div class="col-12 mb-1">
         <label class="mb-0">Description</label>
         <textarea class="form-control" name="description" rows="1" value=""><?php echo !empty($form['description']) ? $form['description'] : '' ?></textarea>
      </div>
      <div class="col-12 mb-1">
         <label class="mb-0">Status</label>
         <select class="form-select" name="status" >
            <option value="77" <?php echo ($form['status']==77)?'selected':'' ?>>Active</option>
            <option value="78" <?php echo ($form['status']==78)?'selected':'' ?>>Disabled</option>
         </select>
      </div>
      
   </div>
   <input type="hidden" name="id" value="<?php echo $form['id'] ?>">
   <div class="form-group overflow-hidden">
      <div class="row ">
         <div class=" col-lg-12  d-flex justify-content-end  mt-2">
            <button type="submit" class="btn btn-primary"><i class="mdi mdi-check"></i> Submit</button>
         </div>
      </div>
   </div>
   </div>
</form>


<script>

</script>