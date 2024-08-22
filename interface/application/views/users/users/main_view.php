<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>

                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
            <h4 class="page-title"> Users</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <div class="row mb-2">
               <div class="col-sm-10 col-12">
                  <button class="btn btn-danger mb-2 addData"><i class="mdi mdi-plus-circle me-1"></i> Add User </button>
                  <!-- <button class="btn btn-light mb-2 ml-2 importData"><i class="mdi mdi-cloud-download me-1"></i> Import </button>
                  <button class="btn btn-light mb-2 ml-2 exportData"><i class="mdi mdi-cloud-upload me-1"></i> Export </button> -->
               </div>
               <div class="col-sm-2 col-12">
                  <div class="text-sm-end d-flex justify-content-end">
                     <div class="dropdown fliter_btn ">
                        <a type="button" class="btn btn-info" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                        <i class="uil-filter"></i>
                        </a>
                        <div class="dropdown-menu filter-drop-menu">
                           <div class="filter_properties">
                              <?php echo $filter_view ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col-->
            </div>
            <div id="Tbl"></div>
         </div>
         <!-- end card-body-->
      </div>
      <!-- end card-->
   </div>
   <!-- end col -->
</div>
<!-- end row -->