<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>organization-branches">Organization Branches</a></li>

                    <li class="breadcrumb-item active">Departments</li>
                </ol>
            </div>
            <h4 class="page-title">Departments</h4>
        </div>
    </div>
</div>
<!-- end page title -->


<div class="row">
   <div class="col-12">
         <div id="DeptChart"><?php echo $deptTbl ?></div>
   </div>
   <!-- end col -->
</div>
<!-- end row -->