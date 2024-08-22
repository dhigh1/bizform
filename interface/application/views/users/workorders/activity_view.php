<div class="alert alert-info text-center p-1">
<?php if(!empty($workorder)){echo 'Showing the activity of workorder - '.$workorder['code']; } ?>
</div>

<?php if(isset($logs) && !empty($logs)){ ?>
<div data-simplebar style="max-height: 500px;">
<div class="timeline-alt pb-0 pt-0">

    <?php 
          foreach($logs as $log_row){
    ?>
    <!-- end timeline item -->
    <div class="timeline-item">
        <i class="mdi mdi-check-underline bg-info-lighten text-info timeline-icon"></i>
        <div class="timeline-item-info">
            <small><?php echo $log_row['description'] ?></small>
            <p class="mb-0 pb-2">
                <small class="text-muted"><?php echo ucwords($log_row['created_username']).' | '.humanTiming($log_row['created_at']).' | '.custom_date('d-M-Y h:i:s A',$log_row['created_at']); ?></small>
            </p>
        </div>
    </div>
    <?php } ?>
    <!-- end timeline item -->
</div>
</div> <!-- end slimscroll -->
<?php }else{ echo $logs['message']; } ?>