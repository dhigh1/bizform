<style>
    .table>:not(caption)>*>* {
        padding: 5px !important;
    }
</style>
</style>
<?php
$view_prm = User::check_permission('workorders/view', 'check');
$delete_prm = User::check_permission('workorders/delete_data', 'check');
$activity_prm = User::check_permission('workorders/get_workorder_activity', 'check');
?>

<div class="row">
    <?php if (isset($data_list) && !empty($data_list) && is_array($data_list)) { ?>
        <div class="col-lg-12">
            <p class="mb-1">Total <b><?php if (isset($pagination_data['pagination_links'])) {
                                            echo $pagination_data['total_rows'];
                                        } ?></b> Responses found</p>
        </div>
        <div class="row">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>SL_No</th>
                    <th>Candidate ID</th>
                    <th>Campaign Name</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    // $i = $pagination_data['slno'];
                    $i = 1;
                    // print_R($data_list); echo "<hr>";
                    foreach ($data_list as $data_row) { ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $data_row['candidate_id'] ?></td>
                            <td><?php echo $data_row['campaign_name'] ?></td>
                            <td>
                                <div class="<?php echo $data_row['status_color_name'] ?>"><?php echo $data_row['status_name'] ?></div>
                            </td>
                            <td><?php echo $data_row['created_at'] ?></td>
                            <td><?php echo $data_row['updated_at'] ?></td>
                            <td>
                                <a href="responses/view?id=<?php echo $data_row['candidate_id'] ?>">
                                    <button class="btn"><i class="fa fa-eye text-success viewResponse"></i></button>
                                </a>
                                <?php if(User::check_permission('responses/delete', 'check')){ ?>
                                <button class="btn deleteResponse" data-id="<?php echo $data_row['candidate_id'] ?>"><i class="fa fa-trash text-danger"></i></button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
        <div id="page_result">
   <?php if(isset($pagination_data['pagination_links'])){ echo $pagination_data['pagination_links'];} ?>
</div>
    <?php } ?>
</div>

<script>
    $(".deleteResponse").on('click', function() {
        console.log("clicked")
        var id = $(this).attr('data-id');
        swal({
            title: 'Are you sure ?',
            text: 'This is irreversible',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!"
        }).then(function(isConfirm) {
            if (isConfirm.value) {
                $.post('responses/delete_response', {
                    id: id
                }, function(data) {
                    if (data.status == 'success') {
                        swal('success', data.message, '').then(()=>getdatas());
                    } else {
                        swal('failure', data.message, '')
                    }
                }, 'json')
            }
        })

    })
</script>