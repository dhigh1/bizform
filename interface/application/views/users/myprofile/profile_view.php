<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item">My Profile</li>

                    <li class="breadcrumb-item active">Profile Settings</li>
                </ol>
            </div>
            <h4 class="page-title"> Profile Settings </h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="mb-3 text-uppercase bg-light p-2">Profile Picture</h5>
                <form id="pictureForm">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type='file' id="imageUpload" name="files[]" accept=".png,.jpg,.jpeg" />
                            <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview"
                                style="background-image: url('<?php print_image($data_list['picture_name'], $data_list['picture_path'], 'src'); ?>');">
                            </div>
                        </div>
                    </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3 text-uppercase bg-light p-2">Profile Details</h5>
                <div class="profile-dtails">
                    <form id="profileForm" novalidate="novalidate">
                        <div class="div_res"></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class=" mb-1">
                                    <label for=""> Login Id* </label>
                                    <input type="text" class="form-control" name="login_id"
                                        value="<?php echo $data_list['login_id'] ?>" disabled required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-1">
                                    <label for=""> First Name* </label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="<?php echo $data_list['first_name'] ?>" required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-1">
                                    <label for=""> Last Name* </label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="<?php echo $data_list['last_name'] ?>" required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-1">
                                    <label for=""> Email* </label>
                                    <input type="email" class="form-control" name="email"
                                        value="<?php echo $data_list['email'] ?>" required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=" mb-1">
                                    <label for=""> Mobile* </label>
                                    <input type="text" class="form-control" name="mobile"
                                        value="<?php echo $data_list['mobile'] ?>" required />
                                </div>
                            </div>
                        </div> <!-- end row -->


                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i>
                                Save</button>
                        </div>
                    </form>
                </div>
                <!-- end settings content-->
            </div>
        </div>
    </div>

</div>
