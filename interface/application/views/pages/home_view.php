<?php 
    $org_data=array('name'=>'','logo_name'=>'','logo_path'=>'');
    $apidata=$this->curl->execute("organization/1","GET");
    if($apidata['status']=='success' && !empty($apidata['data_list'])){
        $org_data=$apidata['data_list'];
    }
?>

<div class="mt-3 mb-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">

                <div class="text-center main-home-page">
                    
                    <div class="logo-sm">
                        <?php print_image($org_data['logo_name'],$org_data['logo_path']); ?>
                    </div>
                    <div class="mt-2"></div>                    
                    <img src="<?php echo base_url() ?>ui/assets/images/maintenance.svg" height="140" alt="File not found Image">
                    <h3 class="mt-2">Welcome to <?php echo $org_data['name']; ?></h3>
                    <p class="text-muted">Please choose the portal.</p>

                    <div class="row mt-1">
                        <div class="col-md-4">
                            <div class="text-center mt-3 ps-1 pe-1">
                                <i class="mdi mdi-account-multiple bg-primary maintenance-icon text-white mb-2"></i>
                                <h5 class="text-uppercase">Employee?</h5>
                                <p class="text-muted">Use system services as employee/admin</p>
                                <a href="<?php echo base_url() ?>login"><i class="mdi mdi-account-arrow-right"></i> Let me in </a>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-md-4">
                            <div class="text-center mt-3 ps-1 pe-1">
                                <i class="mdi mdi-briefcase-variant bg-primary maintenance-icon text-white mb-2"></i>
                                <h5 class="text-uppercase">Customer?</h5>
                                <p class="text-muted">Customer area</p>
                                <a href="<?php echo base_url() ?>customer/login"><i class="mdi mdi-account-arrow-right"></i> Let me in </a>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-md-4">
                            <div class="text-center mt-3 ps-1 pe-1">
                                <i class="mdi mdi-home-account bg-primary maintenance-icon text-white mb-2"></i>
                                <h5 class="text-uppercase">Vendor?</h5>
                                <p class="text-muted">Vendor services</p>
                                <a href="<?php echo base_url() ?>vendor/login"><i class="mdi mdi-account-arrow-right"></i> Let me in </a>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->
                </div> <!-- end /.text-center-->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>