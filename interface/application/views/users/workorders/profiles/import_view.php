<form class="" id="importForm">
	<input type="hidden" name="workorders_id" value="<?php echo $workorders_id ?>">
	<input type="hidden" name="module" value="workorder_profiles">
	<div class="div_res"></div>

	<div class="row">
		<div class="col-lg-6 col-12">
			<div class="row">
				<div class="col-12">
			  	<label>Select the check you wanted to execute</label>
			  	<select class="select2_check" name="services_id" id="check_select" required>
		      	<option></option>
		      	<?php 
		           if(is_array($services)){
		              foreach($services as $service){
		                 echo '<option value="'.$service['services_id'].'">'.$service['services_name'].'</option>';
		              }
		           } 
		        ?>
		     	</select>
		     	<div class="columnPreview"><span class="text-info small">Select check to download the excel template.</span></div>
			  </div>
			  <div class="col-lg-12 mb-0 mt-2">
		        <label>Put check to</label>
		        <select class="form-select" name="status" required>
		        <?php  
		           if(!empty($workflow)){
		               foreach($workflow as $flow_row){
		                  if($flow_row['id']<=4){
		        ?>
		           <option value="<?php echo $flow_row['id'] ?>"><?php echo $flow_row['name'] ?></option>
		        <?php } } } ?>
		        </select>
		     </div>
			</div>
		</div>
		<div class="col-lg-6 col-12">
			<div class="row">
				<div class="col-12 mt-1">
			  		<label>Upload Excel File</label>
		        <div class="fallback">
		            <input name="files[]" type="file" class="dropify" data-max-file-size="10M" accept=".xlsx,.xls" />
		        </div>
			      <!-- <a href="javascript:;" onclick="download_import_sample(this);" class="sample_import_file" data-type="<?php echo $module ?>"><i class="fa fa-download"></i> Download sample data</a> -->
			  </div>
			  <div class="col-lg-12 pt-3">
					<div class="text-center">
						<button type="submit" class="btn btn-primary w-100">Import Now</button>
					</div>
				</div>
			</div>
		</div>		
	</div>
</form>
<div class="row">	  
    <div class="col-lg-12">
      <div class="excel_progress"></div>   
    </div>
</div>
