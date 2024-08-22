<div class="authentication-bg">
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <!-- Logo -->
                    <div class="card-header pt-4 pb-4 text-center bg-dark">
                         <a href="<?php echo base_url() ?>">
                            <span><img src="<?php echo base_url() ?>ui/assets/images/logo.png" alt="" height=""></span>
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1 class="text-error">4<i class="mdi mdi-emoticon-sad"></i>4</h1>
                            <h4 class="text-uppercase text-danger mt-3">Page Not Found</h4>
                            <p class="text-muted mt-3">It's looking like you may have taken a wrong turn. Don't worry... it
                                happens to the best of us. Here's a
                                little tip that might help you get back on track.</p>
                            <?php 
                                $url=base_url();
                                if(User::is_logged()){
                                    $url=base_url()."dashboard";
                                }
                            ?>
                            <a class="btn btn-info mt-3" href="<?php echo $url ?>"><i class="mdi mdi-reply"></i> Return Home</a>
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