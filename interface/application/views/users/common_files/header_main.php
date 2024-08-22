<?php 
   $userdata=array(
      'login_id'=>'',
      'picture_name'=>'',
      'picture_path'=>'',
   );
   $uid=User::get_userId();
   if(!empty($uid)){
      $userdata=$this->curl->execute("users/$uid","GET");
      $userdata=$userdata['data_list'];
   }

   $notify_list=array();
   $notify_count=0;
   $notifydata=$this->curl->execute("notifications","GET",array('reference_type'=>User::get_ReferType(),'reference_id'=>User::get_userId(),'is_seen'=>1));

   if($notifydata['status']=='success'){
      $notify_list=$notifydata['data_list'];
      $notify_count=$notifydata['data_count'];    
   }
?>

<div class="navbar-custom">
   <ul class="list-unstyled topbar-menu float-end mb-0">
      <li class="dropdown notification-list">
         <a class="nav-link dropdown-toggle arrow-none mt-3" data-bs-toggle="dropdown" href="#"
            role="button" aria-haspopup="false" aria-expanded="false">
         <i class="dripicons-bell noti-icon"></i>
         <?php //if($notify_count>0){ ?>
         <span class="noti-icon-badge"><?php echo $notify_count ?></span>
         <?php //} ?>
         </a>
         <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
            <!-- item-->

            <?php if(!empty($notify_list)){ ?>
            <div class="dropdown-item noti-title">
               <h5 class="m-0">
                  <!-- <span class="float-end">
                  <a href="javascript: void(0);" class="text-dark"><small>Clear All</small></a>
                  </span> -->
                  Notifications
               </h5>
            </div>
            <div style="max-height: 230px" data-simplebar>

               <?php foreach($notify_list as $notification){ ?>
               <!-- item-->
               <a href="<?php if(!empty($notification['reference_url'])){ echo base_url().$notification['reference_url']; }else{ echo 'javascript:;'; } ?>" class="dropdown-item notify-item">
                  <div class="notify-icon bg-primary">
                     <i class="mdi mdi-dots-vertical"></i>
                  </div>
                  <p class="notify-details">
                     <?php echo $notification['title'].' - '.string_teaser($notification['description'],20) ?>
                     <small class="text-muted"><?php echo humanTiming(strtotime($notification['created_at'])); ?></small>
                  </p>
               </a>
               <?php } ?>
            </div>
            <!-- All-->
            <!-- <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">View All</a> -->
            <?php }else{ ?>
               <div class="dropdown-item noti-title">
                  <p class="mb-0">No new notifications...</p>
               </div>
            <?php } ?>
         </div>
      </li>

      <li class="dropdown notification-list user_pro_pic_head">
         <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
            href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <div class="user-avatar-preview"> 
             <div class="account_user_avatar" style="background-image: url('<?php print_image($userdata['picture_name'],$userdata['picture_path'],'src'); ?>'">
             </div>
            </div>
         <span>
         <span class="account-position">Welcome! </span>
         <span class="account-user-name"><?php echo ucwords($userdata['first_name']) ?></span>
         </span>
         </a>
         <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
            <!-- item-->
            <div class="dropdown-header noti-title">
               <h6 class="text-overflow m-0">Welcome !</h6>
            </div>
            <!-- item-->
            <a href="<?php echo base_url() ?>myprofile" class="dropdown-item notify-item">
            <i class="mdi mdi-account-circle me-1"></i>
            <span>My Profile</span>
            </a>
            <!-- item-->
            <a href="<?php echo base_url() ?>logout" class="dropdown-item notify-item">
            <i class="mdi mdi-logout me-1"></i>
            <span>Logout</span>
            </a>
         </div>
      </li>
   </ul>
   <button class="button-menu-mobile open-left">
   <i class="mdi mdi-menu"></i>
   </button>
</div>