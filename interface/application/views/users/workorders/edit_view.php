<?php 
   $start_exist=$end_exist=0;
   if(!empty($workflows)){ 
      foreach($workflows as $work_list){
         if($work_list['orders']==0){
            $start_exist=1;
            break;
         }
      }

      foreach($workflows as $work_list){
         if($work_list['orders']==100){
            $end_exist=1;
            break;
         }
      }
   }
?>


<form id="myForm" novalidate="">
   <div class="div_res"></div>
   <input type="hidden" name="id">
      <div class="row">
         <div class="col-lg-6">
            <div class="mb-1">
               <label>State Name* </label>
               <input type="text" class="form-control" name="name" required>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="mb-1">
               <label>State Parent* </label>
               <select class="form-select" name="orders" required="">
                  <option value="">--select--</option>
                   <?php if($start_exist==0){ ?>
                  <option value="0">-Initial State-</option>
                  <?php } ?>
                  <?php if($end_exist==0){ ?>
                  <option value="100">-End State-</option>
                  <?php } ?>
                  <?php 
                  if(!empty($workflows)){ 
                     foreach($workflows as $workflow){
                  ?>
                  <option value="<?php echo $workflow['id'] ?>"><?php echo $workflow['name'] ?></option>
                  <?php } } ?>
               </select>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="mb-1">
               <label>Class* </label>
               <input type="text" class="form-control" name="class_name" required>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="mb-1">
               <label>Checklist* </label>
               <select class="form-select" name="checklists_id" required="">
                  <option value="">--select--</option>
                  <?php 
                  if(!empty($checklists)){ 
                     foreach($checklists as $checklist){
                  ?>
                  <option value="<?php echo $checklist['id'] ?>"><?php echo $checklist['check_type_name'].' - '.$checklist['name'] ?></option>
                  <?php } } ?>
               </select>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="mb-1">
               <label>Description</label>
               <textarea class="form-control" name="description" rows="2"></textarea>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="mb-1">
               <label>Transitions </label>
               <input type="text" name="transitions" id="transitions" class="select2_transition" value="">
            </div>
         </div>
      </div>
      <div class="form-group overflow-hidden">
         <div class="row">
            <div class="col-lg-12  d-flex justify-content-end mt-2">
               <button type="submit" class="btn btn-primary"><i class="mdi mdi-check"></i> Submit</button>
            </div>
         </div>
      </div>
   </div>
</form>

<?php 
   if(!empty($workflows)){
      foreach($workflows as $workflow){
         if($data_list['workflow_code']!=$workflow['workflow_code']){
            $data[]=$workflow['workflow_code'];
         }
      } 
   } 
   $data =array_unique($data);
   $tags = "'" . implode ( "', '", $data ) . "'";
?>

<script type="text/javascript">
var data = $.parseJSON('<?php echo json_encode($data_list) ?>');
$.each(data, function(k, v) {
   if(v!=''){
      $("[name='" + k + "']").val(v);
   }
});

$(".select2_transition").select2({
   tags:[<?php echo $tags ?>],
   createSearchChoice: function(params) {
      return undefined;
   }
});
</script>