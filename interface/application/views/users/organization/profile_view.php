<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item">Organization</li>

                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
            <h4 class="page-title"> Organization </h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="font-13 text-uppercase">About Organization </h4>
                <form id="pictureForm">
                    <div class="div_res"></div>
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type='file' id="imageUpload" name="files[]" accept=".png,.jpg,.jpeg" />
                            <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview"
                                style="background-image: url('<?php print_image($apidata['data_list']['logo_name'], $apidata['data_list']['logo_path'], 'src'); ?>');">
                            </div>
                        </div>
                    </div>
                </form>

                <h4 class="mb-0 mt-2">
                    <?php echo ucfirst($apidata['data_list']['name']) ?>
                </h4>
                <p class="text-muted font-14">
                    <?php echo ucfirst($apidata['data_list']['tagline']) ?>
                </p>
                <div class="text-center mt-0">
                    <p class="text-muted mb-1 font-13"><span class="ms-2">
                            <?php echo ucfirst($apidata['data_list']['address']) ?>
                        </span></p>
                </div>

            </div> <!-- end card-body -->
        </div> <!-- end card -->

        <!-- Edit Favicon Begining -->
        <div class="card text-center">
            <div class="card-body">
                <h4 class="font-13 text-uppercase">Site Favicon </h4>
                <form id="faviconForm">
                    <div class="div_res"></div>
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type='file' id="faviconUpload" name="files[]" accept=".png,.jpg,.jpeg" />
                            <label for="faviconUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="faviconPreview" style="background-image: url('<?php print_image($apidata['data_list']['favicon_name'], $apidata['data_list']['favicon_path'], 'src'); ?>');">
                            </div>
                        </div>
                    </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
        <!-- Edit Favicon End -->
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <div class="profile-dtails">
                    <form id="customForm" novalidate="novalidate">
                        <div class="div_res"></div>
                        <input type="hidden" name="id" value="<?php echo ucfirst($apidata['data_list']['id']) ?>">
                        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building me-1"></i>
                            Organization Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Organization Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="<?php echo ucfirst($apidata['data_list']['name']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label"> Tagline </label>
                                    <input type="text" class="form-control" name="tagline"
                                        value="<?php echo ucfirst($apidata['data_list']['tagline']) ?>">
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="userbio" class="form-label">Registered Address</label>
                                    <textarea class="form-control" rows="4"
                                        name="address"><?php echo ucfirst($apidata['data_list']['address']) ?></textarea>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i>
                                Save</button>
                        </div>
                    </form>
                    <!-- <form id="smForm" novalidate="novalidate">
                        <div class="div_res"></div>
                        <input type="hidden" name="id" value="<?php //echo ucfirst($apidata['data_list']['id']) ?>">
                        <h5>Social Media Links</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Facebook</label>
                                    <input type="text" class="form-control jsonElements sm_links" data-type="facebook"
                                        name="facebook" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Twitter</label>
                                    <input type="text" class="form-control jsonElements sm_links" data-type="twitter"
                                        name="twitter" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">LinkedIn</label>
                                    <input type="text" class="form-control jsonElements sm_links" data-type="linkedin"
                                        name="linkedin" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Instagram</label>
                                    <input type="text" class="form-control jsonElements sm_links" data-type="instagram"
                                        name="instagram" value="">
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i>
                                Save</button>
                        </div>
                    </form> -->
                </div>
            </div>
        </div>
    </div>

</div>