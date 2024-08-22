<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>campaigns">Campaign</a></li>
                    <li class="breadcrumb-item active">Campaign View</li>
                </ol>
            </div>
            <h4 class="page-title">Campaign</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <script type="text/javascript">
                    $(function () {
                        var header = $(".formBuilder-box");

                        $(window).scroll(function () {
                            var scroll = $(window).scrollTop();
                            if (scroll >= 380) {
                                header.addClass("scrolled");
                            } else {
                                header.removeClass("scrolled");
                            }
                        });
                    });
                </script>
                <h3 class="text-center text-danger" style="text-decoration: underline">
                    <?php echo $campaign['name'] ?>
                </h3>
                <h4 class="text-primary text-center" style="text-decoation: underline">URL: <a target="_blank"
                        href="<?php echo $url == '' ? '' : $url; ?>"><?php echo $url == '' ? '' : $url; ?></a></h4>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-success text-center">
                            QR CODE: <br> <img
                                src='https://chart.googleapis.com/chart?chs=140x140&cht=qr&chl=<?php echo $url ?>&choe=UTF-8'>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card widget-flat  bg-danger text-white">
                            <div class="card-body ">
                                <div class="float-end">
                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                </div>
                                <h1 class=" fw-normal mt-0" title="Number of Link Opened">
                                    Form <br> Views
                                </h1>
                                <h1 class="mt-2 mb-2">
                                    <?php echo $total_candidates; ?>
                                </h1>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="card widget-flat  bg-success text-white">
                            <div class="card-body ">
                                <div class="float-end">
                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                </div>
                                <h1 class=" fw-normal mt-0" title="Number of Link Submitted">
                                    Forms <br> Submissions
                                </h1>
                                <h1 class="mt-2 mb-2">
                                    <?php echo $total_completed_candidates; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($ids) && is_array($ids)) { ?>
                    <h4 class="text-primary" style="text-decoration: underline">Templates Used</h4>
                    <?php $i = 0; ?>
                    <div class="d-flex justify-content-start align-items-center mb-2">
                        <?php foreach ($ids as $id) {
                            $data = $this->curl->execute('formbuilder/' . $id['form_id'], 'GET');
                            if ($data['status'] == 'success' && !empty($data['data_list'])) {
                                $data_row = $data['data_list']; ?>
                                <spana class="badge bg-success mx-2 p-3" style="font-size: 15px">
                                    <?php echo $data_row['name'] ?>
                                </spana>
                                <?php $i++;
                            }
                        } ?>
                    </div>
                <?php } ?>

                <!-- <div class="row">
                    <div class="col-lg-4">
                        <div class="card widget-flat  bg-danger text-white">
                            <div class="card-body ">
                                <div class="float-end">
                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                </div>
                                <h5 class=" fw-normal mt-0" title="Number of Customers">
                                    Form Views
                                </h5>
                                <h3 class="mt-2 mb-2"><?php //echo $total_candidates; 
                                ?></h3>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="card widget-flat  bg-success text-white">
                            <div class="card-body ">
                                <div class="float-end">
                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                </div>
                                <h5 class=" fw-normal mt-0" title="Number of Customers">
                                    Forms Submissions
                                </h5>
                                <h3 class="mt-2 mb-2"><?php //echo $total_completed_candidates; 
                                ?></h3>
                            </div>
                        </div>
                    </div>
                </div> -->



                <div class="row">
                    <h4 class="text-primary" style="text-decoration: underline">Responses</h4>
                </div>

                <!-- pending_responses
completed_responses -->
                <div class="row">
                    <?php //if (isset($completed_responses) && !empty($completed_responses) && is_array($completed_responses)) { ?>
                    <div class="col-lg-12">
                        <p class="mb-1">Total <b>
                                <?php if (isset($completed_responses['pagination_data']['pagination_links'])) {
                                    echo $completed_responses['pagination_data']['total_rows'];
                                } ?>
                            </b> Responses found</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-box table-card">

                                    <h5 class="text-primary text-end badge bg-success" style="float: right; color: white !important;padding: 5px;" >Completed</h5>
                                    <table id="completed_tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <th>SL_No</th>
                                            <th>Candidate ID</th>
                                            <th>Campaign Name</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Last Updated At</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($completed_responses['data_list'])) {
                                                $i = 1;
                                                foreach ($completed_responses['data_list'] as $data_row) { ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data_row['candidate_id'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data_row['campaign_name'] ?>
                                                        </td>
                                                        <td>
                                                            <div class="<?php echo $data_row['status_color_name'] ?>"><?php echo $data_row['status_name'] ?></div>
                                                        </td>
                                                        <td>
                                                            <?php echo $data_row['created_at'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo !empty($data_row['updated_at'])?$data_row['updated_at']:'NA' ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?php echo base_url() ?>responses/view?id=<?php echo $data_row['candidate_id'] ?>">
                                                                <button class="btn"><i
                                                                        class="fa fa-eye text-success viewResponse"></i></button>
                                                            </a>
                                                            <button class="btn"><i class="fa fa-trash text-danger deleteResponse"
                                                                    data-id="<?php echo $data_row['candidate_id'] ?>" data-module="responses"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;
                                                } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-box table-card">

                                    <h5 class="text-primary text-end badge bg-primary" style="float: right; color: white !important;padding: 5px;" >Pending</h5>
                                    <table id="pending_tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <th>SL_No</th>
                                            <th>Candidate ID</th>
                                            <th>Campaign Name</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Last Updated At</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($pending_responses['data_list'])) {

                                                $i = 1;
                                                foreach ($pending_responses['data_list'] as $data_row) { ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $data_row['candidate_id'] ?></td>
                                                            <td><?php echo $data_row['campaign_name'] ?></td>
                                                            <td><div class="<?php echo $data_row['status_color_name'] ?>"><?php echo $data_row['status_name'] ?></div></td>
                                                            <td><?php echo $data_row['created_at'] ?></td>
                                                            <td>
                                                                <?php echo !empty($data_row['updated_at'])?$data_row['updated_at']:'NA' ?>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="<?php echo base_url() ?>responses/view?id=<?php echo $data_row['candidate_id'] ?>">
                                                                    <button class="btn"><i
                                                                            class="fa fa-eye text-success viewResponse"></i></button>
                                                                </a>
                                                                <button class="btn"><i data-module="responses"
                                                                        class="fa fa-trash text-danger deleteResponse"
                                                                        data-id="<?php echo $data_row['candidate_id'] ?>"></i></button>
                                                            </td>
                                                        </tr>
                                                <?php $i++; } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($cancelled_responses)) { ?>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-box table-card">
                                        <h5 class="text-primary text-end badge bg-danger" style="float: right; color: white !important;padding: 5px;">Cancelled</h5>
                                        <table id="cancelled_tbl" class="table table-bordered table-striped">
                                            <thead>
                                                <th>SL_No</th>
                                                <th>Candidate ID</th>
                                                <th>Campaign Name</th>
                                                <th>Status</th>
                                                <th>Created_at</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($cancelled_responses as $data_row) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data_row['candidate_id'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data_row['campaign_name'] ?>
                                                        </td>
                                                        <td>
                                                            <div class="<?php echo $data_row['status_color_name'] ?>"><?php echo $data_row['status_name'] ?></div>
                                                        </td>
                                                        <td>
                                                            <?php echo $data_row['created_at'] ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?php echo base_url() ?>responses/view?id=<?php echo $data_row['candidate_id'] ?>">
                                                                <button class="btn"><i
                                                                        class="fa fa-eye text-success viewResponse"></i></button>
                                                            </a>
                                                            <button class="btn"><i data-module="responses"
                                                                    class="fa fa-trash text-danger deleteResponse"
                                                                    data-id="<?php echo $data_row['candidate_id'] ?>"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div id="page_result" class="mt-0">
                        <?php if (isset($pagination_data['pagination_links'])) {
                            echo $pagination_data['pagination_links'];
                        } ?>
                    </div>
                </div>
            </div>
            <!-- end card-body-->
        </div>
        <!-- end card-->
    </div>
    <!-- end col -->
</div>

<script>
    $(document).ready(function () {
        let table = new DataTable('#pending_tbl');
        let table1 = new DataTable('#completed_tbl');
        let table2 = new DataTable('#cancelled_tbl');
    })

    $(".deleteResponse").on('click', function () {
        var id = $(this).attr('data-id');
        // const module_name = $(this).attr('data-module');
        // // delete_data($module_name, )
        // delete_data(module_name,'Customer','name','');
        swal({
            title: 'Are you sure ?',
            text: 'This is irreversible',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!"
        }).then(function (isConfirm) {
            if (isConfirm.value) {
                $.post(urljs + 'campaigns/delete_response', { id: id }, function (data) {
                    if (data.status == 'success') {
                        swal('success', data.message, '').then(() => location.reload());
                    } else {
                        swal('failure', data.message, '')
                    }
                }, 'json')
            }
        })

    })
</script>