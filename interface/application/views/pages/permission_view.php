<?php 
    $org_data=array('name'=>'','logo_name'=>'','logo_path'=>'');
    $apidata=$this->curl->execute("organization/1","GET");
    if($apidata['status']=='success' && !empty($apidata['data_list'])){
        $org_data=$apidata['data_list'];
    }
?>

<div class="authentication-bg">
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <!-- Logo -->
                    <div class="card-header p-2 text-center bg-dark">
                         <a href="<?php echo base_url() ?>">
                            <div class="logo-sm">
                                <?php print_image($org_data['logo_name'],$org_data['logo_path']); ?>
                            </div>
                        </a>
                    </div>

                    <div class="card-body p-4 pt-2">
                        <div class="text-center">
                            <h1 class="text-error mt-0">4<i class="mdi mdi-close-circle-outline"></i>3</h1>
                            <h4 class="text-uppercase text-danger mt-3">Access denied!</h4>
                            <p class="text-muted mt-2">You do not have enough permissions to access this resource. Please contact administrator for access permissions.</p>
                            <?php 
                                $url=base_url();
                                if(User::is_logged()){
                                    $url=base_url()."dashboard";
                                }
                            ?>
                            <a class="btn btn-info mt-1" href="javascript:history.go(-1)"><i class="mdi mdi-reply"></i> Go Back</a>
                        </div>
                    </div> <!-- end card-body-->
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
</div>