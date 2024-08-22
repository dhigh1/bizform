<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item">My Profile</li>

                    <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </div>
            <h4 class="page-title"> Change Password</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">

    <div class="col-xl-8 col-lg-7 mx-auto">
        <div class="card" >
            <div class="card-body"> 
                <div class="profile-dtails" >
                    <form id="myForm" novalidate="novalidate">
                        <div class="div_res"></div>
                        <div class="row">
                             <div class="col-lg-12">
                                <div class="mb-3 password-input-block">
                                    <label for="password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 password-input-block">
                                    <label for="password" class="form-label">New Password  <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="new_password" class="form-control">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 password-input-block">
                                    <label for="password" class="form-label">Confirm New Password  <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="confirm_password" class="form-control">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
    

                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- end settings content-->
            </div> 
        </div>
    </div>

</div>