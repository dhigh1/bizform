<form class="" id="importForm">
	<input type="hidden" name="module" value="<?php echo $module ?>">
	<div class="div_res"></div>
	<div class="row">
		<div class="col-12">
	  		<label>Upload Excel File</label>
	        <div class="fallback">
	            <input name="files[]" type="file" class="dropify" data-max-file-size="10M" accept=".xlsx,.xls" />
	        </div>
	        <a href="javascript:;" onclick="download_import_sample(this);" class="sample_import_file" data-type="<?php echo $module ?>"><i class="fa fa-download"></i> Download sample data</a>
	  	</div>
		<div class="col-12 mt-1">
	        <div class="form-check form-switch">
	            <input type="checkbox" class="form-check-input" id="customSwitch1" name="overwrite" value="yes">
	            <label class="form-check-label" for="customSwitch1">Overwrite if exists</label>
	        </div>
	    </div>
		<div class="col-lg-12 pt-3">
			<div class="text-center">
				<button type="submit" class="btn btn-primary w-100">Import Now</button>
			</div>
		</div>
	</div>
</form>
<div class="row">	  
    <div class="col-lg-12">
      <div class="excel_progress"></div>   
    </div>
</div>
