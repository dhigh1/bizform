<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Workorders</a></li>
                    <li class="breadcrumb-item active">All List</li>
                </ol>
            </div>
            <h4 class="page-title">All Work Orders</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<?php $add_prm=User::check_permission('workorders/add','check'); ?>
<div class="row">
   <div class="col-12">
      <div class="">
         <div class="">
            <div class="row mb-0">
               <div class="col-sm-10">
                  <?php if($add_prm){ ?>
                  <button class="btn btn-danger mb-2 addData"><i class="mdi mdi-plus-circle me-1"></i> Create Order </button>
                  <?php } ?>
               </div>
               
               <div class="col-sm-2">
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
            <div id="Tbl" class="work-order-table"></div>
         </div>
         <!-- end card-body-->
      </div>
      <!-- end card-->
   </div>
   <!-- end col -->
</div>
<!-- end row -->