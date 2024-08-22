<?php 
    $org_data=array('name'=>'','logo_name'=>'','logo_path'=>'');
    $apidata=$this->curl->execute("organization/1","GET");
    if($apidata['status']=='success' && !empty($apidata['data_list'])){
        $org_data=$apidata['data_list'];
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="DHI CRM">

  <title><?php if(isset($title)){echo $title;}else{ echo "CRM";} ?></title>
  <?php echo $common_css; ?>
  <?php echo $style; ?>
  <style type="text/css">
    .footer {
        left: 0;
        border: none;
    }
    .input-group label.error{
        position: absolute;
        bottom: -24px;
    }
  </style>
</head>

    <body class="loading authentication-bg" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header pt-2 pb-2 text-center bg-light">
                                <a href="<?php echo base_url() ?>">
                                    <span class="logo-sm"><?php print_image($org_data['logo_name'],$org_data['logo_path']); ?></span>
                                </a>
                            </div>                            

                            <div class="card-body p-3">                                
                                <div class="text-center m-auto">
                                    <h4 class="text-dark-50 mt-0 mb-0 text-center pb-0 fw-bold"><?php if(isset($title)){echo $title;}else{ echo "CRM";} ?></h4>
                                    <p class="text-muted mb-3">Enter your credentials to access your account.</p>
                                </div>
                                <form id="loginForm">
                                    <div class="div_res"></div>
                                    <div class="mb-2">
                                        <label for="emailaddress" class="form-label"><?php if(isset($login_var)){echo $login_var;}else{ echo "Login ID";} ?></label>
                                        <input class="form-control" type="text" id="uid" name="uid" placeholder="Enter your <?php if(isset($login_var)){echo strtolower($login_var);}else{ echo "Login ID";} ?>" value="<?php if(isset($_COOKIE['user_remember_me'])) echo $this->input->cookie('user_remember_me',TRUE);  ?>">
                                    </div>

                                    <div class="mb-2">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" name="pwd" class="form-control" placeholder="Enter your password"  value="<?php if(isset($_COOKIE['user_password'])) echo $_COOKIE['user_password']; ?>">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                        <!-- <a href="javascript:;" class="text-muted float-end" id="forgotPwdBtn"><small>Forgot your password?</small></a> -->
                                    </div>

                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-signin" name="remember"   <?php if(isset($_COOKIE['user_remember_me'])) { echo 'checked="checked"'; } else { echo ''; } ?>>
                                            <label class="form-check-label" for="checkbox-signin">Stay signed in</label>
                                        </div>
                                    </div>

                                    <div class="mb-0 text-center">
                                        <button class="btn btn-primary" type="submit"> Log In </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

    <?php echo $footer ?>
    <?php echo $common_js; ?>
    <?php echo $script; ?>
        
    </body>
</html>
