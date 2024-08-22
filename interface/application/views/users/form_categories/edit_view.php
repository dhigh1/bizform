<form class="form" id="myForm" novalidate>
   <input type="hidden" name="id" value="">
   <div class="div_res"></div>
      <div class="row">
      <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Name<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="name" required />
            </div>
         </div>
         <div class="col-lg-12">
            <div class=" mb-1">
               <label for=""> Code<span class="text-danger">*</span> </label>
               <input type="text" class="form-control" name="code" 
                  id="" placeholder=" "
                  required />
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


<script type="text/javascript">
var data = $.parseJSON('<?php echo json_encode($data_list) ?>');
$.each(data, function(k, v) {
   if(v!=''){
       $("[name='" + k + "']").val(v);
   }
});
</script>