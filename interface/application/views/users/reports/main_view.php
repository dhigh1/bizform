<!-- start page title -->
<div class="row my-2">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>reports">Home</a></li>

                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </div>
            <h4 class="page-title"> Reports</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="container">
    <!-- <form id="form_report" role="form"> -->
    <div class="container card px-3 py-1">
        <div class="row my-1">
            <div class="form-group col-lg-4 col-12">
                <select class="form-control refine_filter" data-type="datetype" id="datetype" required>
                    <option value="" selected>--select datetype--</option>
                    <option data-type="datetype" value="created_at">Created Date</option>
                    <option data-type="datetype" value="allocated_at">Allocated Date</option>
                    <option data-type="datetype" value="status_in-progress-execute">Executed Date</option>
                </select>
            </div>
            <div class="form-group col-lg-8 col-12">
                <div class="report-daterange">
                    <input class="form-control input-limit-datepicker refine_filter" placeholder="Select date range" data-type="daterange" type="text" name="daterange" id="daterange" value="" required>
                </div>
            </div>
        </div>

        <div class="row my-1">
            <div class="col-6 my-1">
                <label >Customer *</label>
                <select class="select2_customer refine_filter" data-type="customer_select" id="customer_select">
                    <option data-type="customer_select"></option>
                    <?php
                    if (is_array($company_list['data_list'])) {
                        foreach ($company_list['data_list'] as $company) {
                            if (isset($customers_id)) {
                                if ($customers_id == $company['id']) {
                                    echo '<option data-type="customer_select" value="' . $company['id'] . '" selected>' . $company['customer_code'] . '-' . $company['name'] . '</option>';
                                } else {
                                    echo '<option data-type="customer_select" value="' . $company['id'] . '">' . $company['customer_code'] . '-' . $company['name'] . '</option>';
                                }
                            } else {
                                echo '<option data-type="customer_select" value="' . $company['id'] . '">' . $company['customer_code'] . '-' . $company['name'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-6 my-1">
                <label>Branch*</label>
                <select class="select2_cbranch refine_filter" data-type="cbranch_select" id="cbranch_select">
                    <option data-type="cbranch_select"></option>
                    <?php
                    if (isset($branch_list)) {
                        if (is_array($branch_list['data_list'])) {
                            foreach ($branch_list['data_list'] as $branch) {
                                if (isset($branches_id)) {
                                    if ($branches_id == $branch['id']) {
                                        echo '<option data-type="cbranch_select" value="' . $branch['id'] . '" selected>' . $branch['branch_code'] . '-' . $branch['name'] . '</option>';
                                    } else {
                                        echo '<option data-type="cbranch_select" value="' . $branch['id'] . '">' . $branch['branch_code'] . '-' . $branch['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option data-type="cbranch_select" value="' . $branch['id'] . '">' . $branch['branch_code'] . '-' . $branch['name'] . '</option>';
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-6 my-1">
                <label>Contact Person*</label>
                <select class="select2_cbranch_person refine_filter" data-type="cbranch_person_select" id="cbranch_person_select" >
                    <option data-type="cbranch_person_select"></option>
                    <?php
                    if (isset($branch_list)) {
                        if (is_array($branch_list['data_list'])) {
                            foreach ($branch_list['data_list'] as $branch) {
                                if (isset($branches_id)) {
                                    if ($branches_id == $branch['id']) {
                                        echo '<option data-type="cbranch_person_select" value="' . $branch['id'] . '" selected>' . $branch['branch_code'] . '-' . $branch['name'] . '</option>';
                                    } else {
                                        echo '<option data-type="cbranch_person_select" value="' . $branch['id'] . '">' . $branch['branch_code'] . '-' . $branch['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option data-type="cbranch_person_select" value="' . $branch['id'] . '">' . $branch['branch_code'] . '-' . $branch['name'] . '</option>';
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-6 my-1">
                <label>Service*</label>
                <select id="workorder_profiles_checks-services_id" data-type="workorder_profiles_checks-services_id" class="select2_services refine_filter">
                    <option></option>
                    <?php
                    if (isset($services)) {
                        if (is_array($services['data_list'])) {
                            foreach ($services['data_list'] as $service) {
                                if (isset($services_id)) {
                                    if ($services_id == $service['id']) {
                                        echo '<option data-type="workorder_profiles_checks-services_id" value="' . $service['id'] . '" selected>' . $service['name'] . '</option>';
                                    } else {
                                        echo '<option data-type="workorder_profiles_checks-services_id" value="' . $service['id'] . '">' . $service['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option data-type="workorder_profiles_checks-services_id" value="' . $service['id'] . '">' . $service['name'] . '</option>';
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-6 form-group my-1">
                <label>Workorder</label>
                <select id="workorder_profiles_checks-workorders_id" data-type="workorder_profiles_checks-workorders_id" class="select2_workorders refine_filter">
                    <option></option>
                    <?php
                    if (isset($workorders)) {
                        if (is_array($workorders['data_list'])) {
                            foreach ($workorders['data_list'] as $workorder) {
                                if (isset($workorders_id)) {
                                    if ($workordres_id == $workorder['id']) {
                                        echo '<option data-type="workorder_profiles_checks-workorders_id" value="' . $workorder['id'] . '" selected>' . $workorder['code'] . '</option>';
                                    } else {
                                        echo '<option data-type="workorder_profiles_checks-workorders_id" value="' . $workorder['id'] . '">' . $workorder['code'] . '</option>';
                                    }
                                } else {
                                    echo '<option data-type="workorder_profiles_checks-workorders_id" value="' . $workorder['id'] . '">' . $workorder['code'] . '</option>';
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group col-lg-6 col-12">
                <label>Status</label>
                <select id="workorder_profiles_checks-status" class="select2_status refine_filter" data-type="workorder_profiles_checks-status">
                    <option></option>
                    <?php
                    if (isset($workflow)) {
                        if (is_array($workflow['data_list'])) {
                            foreach ($workflow['data_list'] as $workflow_item) {
                                if (isset($workflow_id)) {
                                    if ($workflow_id == $workflow_item['id']) {
                                        echo '<option data-type="workorder_profiles_checks-status" value="' . $workflow_item['id'] . '" selected>' . $workflow_item['name'] . '</option>';
                                    } else {
                                        echo '<option data-type="workorder_profiles_checks-status" value="' . $workflow_item['id'] . '">' . $workflow_item['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option data-type="workorder_profiles_checks-status" value="' . $workflow_item['id'] . '">' . $workflow_item['name'] . '</option>';
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- // $data['daterange'] = $filterData['daterange'];
        // $data['datetype'] = $filterData['datetype'];
        // $data['customers-id'] = $filterData['customer_id'];
        // $data['customer_branches-id'] = $filterData['customer_branches_id'];
        // $data['workorders-customer_branches_persons_id'] = $filterData['customer_branches_persons_id'];
        // $data['workorder_profiles_checks-services_id'] = $filterData['service_id'];
        // $data['workorder_profiles_checks-workorders_id'] = $filterData['workorder_id'];
        // $data['workorder_profiles_checks-status'] = $filterData['status_id'];
        // $data['page'] = $filterData['page']; -->
        <div class="text-end my-2">
            <button class="btn btn-danger btn-report" type="submit">Generate Report</button>
        </div>
    </div>
    <!-- </form> -->

    <div class="row" id="Tbl"></div>

</div>