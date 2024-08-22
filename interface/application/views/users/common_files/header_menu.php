<div class="leftside-menu">
  <!-- LOGO -->
  <?php
  $logo_name = '';
  $logo_path = '';
  if (isset($org_data)) {
    $logo_name = $org_data['logo_name'];
    $logo_path = $org_data['logo_path'];
  }
  ?>
  <a href="<?php echo base_url() ?>" class="logo text-center logo-light">
    <span class="logo-lg">
      <?php print_image($logo_name, $logo_path); ?>
    </span>
    <span class="logo-sm">
      <?php print_image($logo_name, $logo_path); ?>
    </span>
  </a>

  <?php
  $get_permission = $this->curl->execute("module_permissions/user_permissions/" . User::get_userRole(), "GET");
  $per_data = array();
  if ($get_permission['status'] == 'success' && !empty($get_permission['data_list'])) {
    $permissions = $get_permission['data_list'];
    foreach ($permissions as $gp) {
      if ($gp['parent'] == 0 && empty($gp['api_method'])) {
        $per_data[] = $gp['ui_url'];
      }
    }
  }


  function get_permission_menu($module_name, $per_data)
  {
    $is_user_admin = User::is_admin();
    if ($is_user_admin == 1) {
      return true;
    } else {
      if (in_array($module_name, $per_data)) {
        return true;
      } else {
        return false;
      }
    }
  }
  ?>

  <div class="h-100" id="leftside-menu-container" data-simplebar>
    <ul class="side-nav" id="left_menu">
      <li class="side-nav-title side-nav-item">Navigation</li>
      <li class="side-nav-item">
        <a href="<?php echo base_url() ?>dashboard" class="side-nav-link">
          <i class="uil-home-alt"></i> <span> Dashboard </span>
        </a>
      </li>

      <li class="side-nav-title side-nav-item">Form Management</li>
      <li class="side-nav-item">
        <a href="<?php echo base_url() ?>formbuilder" class="side-nav-link">
        <i class="fa fa-address-card"></i><span>Forms</span>
        </a>
      </li>
      <li class="side-nav-title side-nav-item">Campaigns Management</li>
      <li class="side-nav-item">
        <a href="<?php echo base_url() ?>campaigns" class="side-nav-link">
        <i class="fa fa-briefcase"></i><span>My Forms</span>
        </a>
      </li> 
      <li class="side-nav-title side-nav-item">Response Management</li>
      <li class="side-nav-item">
        <a href="<?php echo base_url() ?>responses" class="side-nav-link">
        <i class="fa fa-print"></i><span>Responses</span>
        </a>
      </li>



      <?php if (get_permission_menu('modules', $per_data) || get_permission_menu('module_permissions', $per_data) || get_permission_menu('roles', $per_data) || get_permission_menu('users', $per_data) || get_permission_menu('form_categories', $per_data)) { ?>
        <li class="side-nav-title side-nav-item">User Management</li>

        <?php if (get_permission_menu('modules', $per_data) || get_permission_menu('module_permissions', $per_data)) { ?>
          <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#modules" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
              <i class="uil-server"></i> <span> Modules </span>
            </a>
            <div class="collapse" id="modules">
              <ul class="side-nav-second-level">
                <?php if (get_permission_menu('modules', $per_data)) { ?>
                  <li><a href="<?php echo base_url() ?>modules"> All Modules</a></li>
                <?php } ?>

                <?php if (get_permission_menu('module_permissions', $per_data)) { ?>
                  <li><a href="<?php echo base_url() ?>module-permissions"> Module Permissions</a></li>
                <?php } ?>
              </ul>
            </div>
          </li>
        <?php } ?>

        <?php if (get_permission_menu('roles', $per_data)) { ?>
          <li class="side-nav-item">
            <a href="<?php echo base_url() ?>roles" class="side-nav-link">
              <i class="uil-user-plus"></i> <span> Roles </span>
            </a>
          </li>
        <?php } ?>

        <?php if (get_permission_menu('users', $per_data)) { ?>
          <li class="side-nav-item">
            <a href="<?php echo base_url() ?>users" class="side-nav-link">
              <i class="uil-users-alt"></i> <span> Users </span>
            </a>
          </li>
        <?php } ?>

        <?php if(get_permission_menu('form_categories', $per_data)){ ?>
          <li class="side-nav-item">
          <a href="<?php echo base_url() ?>form_categories" class="side-nav-link">
          <i class="fa fa-bars"></i><span>Form Categories</span>
          </a>
        </li>
        <?php } ?>

      <?php } ?>



      <?php if (get_permission_menu('organization', $per_data) || in_array('organization_branches', $per_data) || in_array('plans', $per_data) || get_permission_menu('checklists', $per_data) || in_array('activity_log', $per_data)) { ?>
        <li class="side-nav-title side-nav-item">Organization</li>

        <?php if (get_permission_menu('organization', $per_data)) { ?>
          <li class="side-nav-item">
            <a href="<?php echo base_url() ?>organization" class="side-nav-link">
              <i class="uil-edit"></i> <span> Profile </span>
            </a>
          </li>
        <?php } ?>

        <?php if (get_permission_menu('organization_branches', $per_data)) { ?>
          <li class="side-nav-item">
            <a href="<?php echo base_url() ?>organization-branches" class="side-nav-link">
              <i class="uil-building"></i> <span> Branches </span>
            </a>
          </li>
        <?php } ?>

        <?php if (get_permission_menu('activity_log', $per_data)) { ?>
          <li class="side-nav-item">
            <a href="<?php echo base_url() ?>activity-log" class="side-nav-link">
              <i class="uil-clock"></i> <span> Activity Log </span>
            </a>
          </li>
        <?php } ?>
      <?php } ?>


      <?php //if (get_permission_menu('myprofile', $per_data) || get_permission_menu('myprofile/change_password', $per_data)) { ?>
        <li class="side-nav-title side-nav-item">Settings</li>
        <li class="side-nav-item">
          <a data-bs-toggle="collapse" href="#myprofile" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
            <i class="uil-user-circle"></i> <span> My Profile </span>
          </a>
          <div class="collapse" id="myprofile">
            <ul class="side-nav-second-level">
              <?php //if (get_permission_menu('myprofile', $per_data)) { ?>
                <li><a href="<?php echo base_url() ?>myprofile"> Profile Settings</a></li>
              <?php //} ?>
              <?php if (get_permission_menu('myprofile', $per_data)) { ?>
                <li><a href="<?php echo base_url() ?>myprofile/change-password"> Change Password </a></li>
              <?php } ?>
            </ul>
          </div>
        </li>
      <?php //} ?>
    </ul>

    <div class="clearfix"></div>
  </div>
</div>