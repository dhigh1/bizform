<div class="row my-2">
    <?php if (!empty($data_list)) { ?>
        <p class="mb-1">Total <b>
                <?php if (!empty($pagination_data['pagination_links'])) {
                    echo $pagination_data['total_rows'];
                }
                 ?>
            </b> checks found</p>
    <?php } ?>
    <div class="table-responseive">
        <?php if (!empty($data_list)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl.No.</th>
                        <th>Check ID</th>
                        <th>Vendor Check ID</th>
                        <th>Profile Name</th>
                        <th>Check Type</th>
                        <th>Customer</th>
                        <th>Customer Branch</th>
                        <th>Contact Person</th>
                        <th>Created At</th>
                        <th>Allocated At</th>
                        <th>Executed At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // print_r($check_data);
                    if (isset($data_list) && !empty($data_list) && is_array($data_list)) { ?>
                        <?php
                        $i = $pagination_data['slno'];
                        foreach ($data_list as $data_row) {
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $data_row['code'] ?></td>
                                <td><?php echo $data_row['vendor_check_id'] ?></td>
                                <td><?php echo $data_row['workorders_profiles_name'] ?></td>
                                <td><?php echo $data_row['services_name'];  ?></td>
                                <td><?php echo $data_row['customers_name'];  ?></td>
                                <td><?php echo $data_row['customer_branches_name'];  ?></td>
                                <td><?php echo $data_row['contact_person_name'];  ?></td>
                                <td>
                                    <?php if($data_row['date_type']=='created_at'){echo custom_date('d-M-Y h:i:s A', $data_row['date_value']);}else{echo "-";} ?>
                                </td>
                                <td>
                                <?php if($data_row['date_type']=='allocated_at'){echo custom_date('d-M-Y h:i:s A', $data_row['date_value']);}else{echo "-";} ?>
                                </td>
                                <td>
                                <?php if($data_row['date_type']=='status_in-progress-execute'){echo custom_date('d-M-Y h:i:s A', $data_row['date_value']);}else{echo "-";} ?>
                                </td>
                                <td>
                                    <?php echo '<span class="' . $data_row['status_color_name'] . '">' . $data_row['status_name'] . '</span>' ?>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-danger text-center">No records found</div>
        <?php } ?>
    </div>


    <div id="page_result" class="table-pagination-holder">
        <?php
        if (!empty($pagination_data['pagination_links'])) {
            echo $pagination_data['pagination_links'];
        }
        ?>
    </div>

    <div class="text-end">
        <button class="btn btn-danger report_download"><i class="fa fa-download"></i> Download Report</button>
    </div>

</div>

<script>

</script>