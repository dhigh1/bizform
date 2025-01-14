<div class="navbar-custom">
   <ul class="list-unstyled topbar-menu float-end mb-0">
      <li class="dropdown notification-list d-lg-none">
         <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
            role="button" aria-haspopup="false" aria-expanded="false">
         <i class="dripicons-search noti-icon"></i>
         </a>
         <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
            <form class="p-3">
               <input type="text" class="form-control" placeholder="Search ..."
                  aria-label="Search" />
            </form>
         </div>
      </li>
      <li class="dropdown notification-list">
         <a class="nav-link dropdown-toggle arrow-none mt-3" data-bs-toggle="dropdown" href="#"
            role="button" aria-haspopup="false" aria-expanded="false">
         <i class="dripicons-bell noti-icon"></i>
         <span class="noti-icon-badge"></span>
         </a>
         <div class="
            dropdown-menu
            dropdown-menu-end
            dropdown-menu-animated
            dropdown-lg
            ">
            <!-- item-->
            <div class="dropdown-item noti-title">
               <h5 class="m-0">
                  <span class="float-end">
                  <a href="javascript: void(0);" class="text-dark">
                  <small>Clear All</small>
                  </a> </span>Notification
               </h5>
            </div>
            <div style="max-height: 230px" data-simplebar>
               <!-- item-->
               <a href="javascript:void(0);" class="dropdown-item notify-item">
                  <div class="notify-icon bg-primary">
                     <i class="mdi mdi-comment-account-outline"></i>
                  </div>
                  <p class="notify-details">
                     Caleb Flakelar commented on Admin
                     <small class="text-muted">1 min ago</small>
                  </p>
               </a>
               <!-- item-->
               <a href="javascript:void(0);" class="dropdown-item notify-item">
                  <div class="notify-icon bg-info">
                     <i class="mdi mdi-account-plus"></i>
                  </div>
                  <p class="notify-details">
                     New user registered.
                     <small class="text-muted">5 hours ago</small>
                  </p>
               </a>
               <!-- item-->
               <a href="javascript:void(0);" class="dropdown-item notify-item">
                  <div class="notify-icon bg-info">
                     <i class="mdi mdi-heart"></i>
                  </div>
                  <p class="notify-details">
                     DHI
                     <b>Admin</b>
                     <small class="text-muted">13 days ago</small>
                  </p>
               </a>
            </div>
            <!-- All-->
            <a href="javascript:void(0);" class="
               dropdown-item
               text-center text-primary
               notify-item notify-all
               ">
            View All
            </a>
         </div>
      </li>

      <li class="dropdown notification-list">
         <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
            href="#" role="button" aria-haspopup="false" aria-expanded="false">
         <span class="account-user-avatar">
         <img src="<?php echo base_url() ?>ui/assets/images/users/sart-favicon.png" alt="user-image"
            class="rounded-circle" />
         </span>
         <span>
         <span class="account-position">Welcome! </span>
         <span class="account-user-name">XYZ</span>
         </span>
         </a>
         <div class="
            dropdown-menu dropdown-menu-end dropdown-menu-animated
            topbar-dropdown-menu
            profile-dropdown
            ">
            <!-- item-->
            <div class="dropdown-header noti-title">
               <h6 class="text-overflow m-0">Welcome !</h6>
            </div>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
            <i class="mdi mdi-account-circle me-1"></i>
            <span>My Account</span>
            </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
            <i class="mdi mdi-account-edit me-1"></i>
            <span>Settings</span>
            </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
            <i class="mdi mdi-lifebuoy me-1"></i>
            <span>Support</span>
            </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
            <i class="mdi mdi-logout me-1"></i>
            <span>Logout</span>
            </a>
         </div>
      </li>
   </ul>
   <button class="button-menu-mobile open-left">
   <i class="mdi mdi-menu"></i>
   </button>
   <div class="app-search dropdown d-none d-lg-block">
      <form>
         <div class="input-group">
            <input type="text" class="form-control dropdown-toggle" placeholder="Search..."
               id="top-search" />
            <span class="mdi mdi-magnify search-icon"></span>
            <button class="input-group-text btn-primary" type="submit">
            Search
            </button>
         </div>
      </form>
   </div>
</div>