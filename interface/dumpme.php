<!-- get/set permission like other menus -->
<?php if (get_permission_menu('customers', $per_data) || get_permission_menu('customer_branches', $per_data) || get_permission_menu('customer_branches_person', $per_data)) { ?>

    <li class="side-nav-title side-nav-item">Customer Management</li>

    <?php if (get_permission_menu('customers', $per_data)) { ?>
        <li class="side-nav-item">
            <a href="<?php echo base_url() ?>customers" class="side-nav-link">
                <i class="uil-suitcase-alt"></i> <span> Customers </span>
            </a>
        </li>
    <?php } ?>


    <?php if (get_permission_menu('customer_branches', $per_data)) { ?>
        <li class="side-nav-item">
            <a href="<?php echo base_url() ?>customer-branches" class="side-nav-link">
                <i class="uil-sitemap"></i> <span> Branches </span>
            </a>
        </li>
    <?php } ?>

    <?php if (get_permission_menu('customer_branches_persons', $per_data)) { ?>
        <li class="side-nav-item">
            <a href="<?php echo base_url() ?>customer-branches-persons" class="side-nav-link">
                <i class="uil-chat-bubble-user"></i> <span> Contact Persons </span>
            </a>
        </li>
    <?php } ?>
<?php } ?>

























<?php
if (!empty($ids) && is_array($ids)) { ?>
    <div class="row my-3">
        <h4 class="text-danger text-center">Selected Templates</h4>
        <?php $i = 0; ?>
        <?php foreach ($ids as $id) {
            $data = $this->curl->execute('formbuilder/' . $id['form_id'], 'GET');
            if ($data['status'] == 'success' && !empty($data['data_list'])) {
                $data_row = $data['data_list'];
        ?>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <span class="mt-0 mb-0 font-14"><b>Sl.No. <?php //echo $i 
                                                                                ?></b></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mt-0 mb-0 font-14">
                                        <i class="mdi mdi-home"></i>
                                        <?php echo $data_row['name'] ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="w-100 text-muted font-12">
                                            <i class="mdi mdi-timer-sand"></i>
                                            <?php //echo '<span class="' . $data_row['status_color_name'] . '">' . $data_row['status_name'] . '</span>' 
                                            ?>
                                        </span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="w-100 text-muted font-12">

                                            <span class=" text-muted font-12"><b>Description</b>:
                                                <?php echo '<span class="">' . $data_row['description'] . '</span>' ?>
                                            </span>
                                    </p>
                                    <p class="time mb-0 ">
                                        <span class=" text-muted font-12"><b>Created</b>:
                                            <?php echo custom_date('d-M-Y h:i:s A', $data_row['created_at']); ?>
                                            <?php if (!empty($data_row['created_username'])) {
                                                echo "| " . ucwords($data_row['created_username']);
                                            } ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="data-card-actions mt-1">
                                        <button class="btn btn-sm btn-outline-primary btn-url-load rounded-pill mb-0" onclick="window.location.href='<?php echo base_url() . "formbuilder/inputs?id=" . $data_row['id'] . "&manage=html" ?>'">View</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill mb-0 removeTemplate" data-id="<?php echo $data_row['id'] ?>" data-cid="<?php echo $campaign['id'] ?>">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php $i++;
            }
        } ?>
    </div>
<?php } ?>