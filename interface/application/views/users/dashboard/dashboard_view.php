<style>
		.card-box.logbox .timeline {
    position: relative;
    padding: 0;
    list-style: none;
    padding-left: 10px;
    margin-bottom: 0px;
}
.card-box.logbox .timeline .timeline-item {
    position: relative;
    padding: 5px 5px 5px 23px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}
.card-box.logbox .timeline .timeline-item{
  margin-bottom: 0px;
}
.card-box.logbox .timeline .timeline-item .timeline-point {
    height: 14px;
    width: 14px;
    background-color: #18c5a9;
    border: 4px solid #fff;
    -webkit-border-radius: 100%;
    border-radius: 100%;
    position: absolute;
    left: -1px;
    top: 50%;
    margin-top: -6px;
}
.card-box.logbox .timeline .timeline-item span{
  font-size: 12px;
}
.card-box.logbox .timeline:before {
    position: absolute;
    display: block;
    content: '';
    width: 1px;
    height: 100%;
    top: 0;
    bottom: 0;
    left: 5px;
    background-color: #ebedf2;
}
.card-box.logbox .timeline-item small.nowrap{
    min-width: 80px;
    text-align: right;
    padding-right: 10px;
}
</style>

<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box">
         <div class="page-title-right">
         </div>
         <h4 class="page-title">Dashboard</h4>
      </div>
   </div>
</div>
<!-- end page title -->
<div class="row">
   <div class="col-xl-12 col-lg-12">
      <div class="row">
         <div class="col-lg-3">
            <a href="<?php echo base_url() . 'formbuilder' ?>">
               <div class="card widget-flat  bg-primary text-white">
                  <div class="card-body">
                     <div class="float-end">
                        <i class="mdi mdi-account-multiple widget-icon"></i>
                     </div>
                     <h4 class=" fw-normal mt-0">
                        Total <br> Forms
                        </41>
                        <h4 class="mt-2 mb-2">
                           <?php echo $total_templates ?>
                        </h4>
                  </div>
                  <!-- end card-body-->
               </div>
            </a>
            <!-- end card-->
         </div>
         <!-- end col-->
         <div class="col-lg-3">
            <a href="<?php echo base_url() . 'campaigns' ?>">
               <div class="card widget-flat  bg-danger text-white">
                  <div class="card-body ">
                     <div class="float-end">
                        <i class="mdi mdi-account-multiple widget-icon"></i>
                     </div>
                     <h4 class=" fw-normal mt-0">
                        Total <br> Campaigns
                     </h4>
                     <h4 class="mt-2 mb-2">
                        <?php echo $campaigns ?>
                     </h4>
                  </div>
                  <!-- end card-body-->
               </div>
            </a>
            <!-- end card-->
         </div>

         <!-- end col-->
         <div class="col-lg-3">
            <a href="<?php echo base_url() . 'responses#bizform_candidates-status=76' ?>">

               <div class="card widget-flat  bg-success text-white">
                  <div class="card-body ">
                     <div class="float-end">
                        <i class="mdi mdi-account-multiple widget-icon"></i>
                     </div>
                     <h4 class=" fw-normal mt-0">
                        Total <br> Submitted Responses
                     </h4>
                     <h4 class="mt-2 mb-2">
                        <?php echo $submitted ?>
                     </h4>
                  </div>
                  <!-- end card-body-->
               </div>
            </a>
            <!-- end card-->
         </div>


         <!-- end col-->
         <div class="col-lg-3">
            <a href="<?php echo base_url() . 'responses#bizform_candidates-status=75' ?>">
               <div class="card widget-flat  bg-success text-white">
                  <div class="card-body ">
                     <div class="float-end">
                        <i class="mdi mdi-account-multiple widget-icon"></i>
                     </div>
                     <h4 class=" fw-normal mt-0">
                        Total <br> Pending Responses
                     </h4>
                     <h4 class="mt-2 mb-2">
                        <?php echo $pending ?>
                     </h4>
                  </div>
                  <!-- end card-body-->
               </div>
            </a>
            <!-- end card-->
         </div>


      </div>

   </div>
   <!-- end row -->
</div>
<!-- end col -->
<div class="col-sm-12 col-12 stats-box">
		<div class="card-box mycardbox logbox">
			<!-- <div class="card-head">
				<h4 class="header-title m-t-0">Verifications Log</h4>
			</div> -->
			<p class="text-muted font-13 card-caption">Today's activity log</p>
			<div class="card-body">
				<div class="inbox-widget nicescroll" style="overflow: auto; outline: none; height: 300px;" tabindex="5000">
					<ul class="timeline scroller" >
						<?php
						$daterange = cur_datetime();
						$fromTime = substr($daterange, 0, 10);
						$toTime = substr($daterange, 0, 10);
						$fromTime = $fromTime != "" ? custom_date("Y-m-d", $fromTime) : "";
						$toTime = $toTime != "" ? custom_date("Y-m-d", $toTime) : "";
						$daterange = $fromTime . ' - '.$toTime;
						// $activityApi = $this->curl->execute("verifications_status", "GET", array('date_range' => $daterange, 'perpage'=>1000));
                  $activityApi = $this->curl->execute("activity_log/daily_activity", "GET", array('date_range' => $daterange, 'perpage' => 1000));
						if ($activityApi['status'] == "success" && !empty($activityApi['data_list'])) {
							foreach ($activityApi['data_list'] as $verify_row) { ?>
                        <li class="timeline-item">
                              <span class="timeline-point bg-primary"></span>
                              <span><?php echo $verify_row['reference_name']. ' - ' ?>
                              <?php echo $verify_row['description'] ?></span>
                              <small class="float-right text-muted ml-2 nowrap"><?php echo humanTiming($verify_row['created_at']).' '; ?> <span data-toggle="tooltip" class="data-tooltip" data-placement="left" title="<?php echo  custom_date("d-M-Y h:i:s A",$verify_row['created_at']); ?>"><i class="fa fa-info-circle"></i></span> </small>
                        </li>
							<?php } } else { ?>
							<div class="alert alert-info">No recent logs...</div>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<!-- end col -->
</div>