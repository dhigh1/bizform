
<script type="text/javascript">
    $(function() {
    var header = $(".formBuilder-box");
  
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
        if (scroll >= 380) {
            header.addClass("scrolled");
        } else {
            header.removeClass("scrolled");
        }
    });
  
});
</script>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>services">Services</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>service-templates">Templates</a></li>
                    <li class="breadcrumb-item">Inputs</li>
                    <li class="breadcrumb-item active">File Uploads</li>
                </ol>
            </div>
            <h4 class="page-title"> Manage Input File Uploads</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
   <div class="col-12">
    <div class="alert alert-success text-center">Manage file uploads of a template <b><?php echo $data_list['name'] ?></b>, customer <b><?php echo $data_list['customers_name'] ?></b> for the check <b><?php echo $data_list['services_name'] ?></b></div>
   </div>
   <div class="col-12 d-flex justify-content-end  mb-2">
    <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='<?php echo base_url().'service-templates/preview?id='.$data_list['id']."&type=inputs" ?>'"><i class="mdi mdi-eye"></i> Preview</button>
    <button type="button" class="btn btn-success btn-sm ml-2" onclick="window.location.href='<?php echo base_url()."service-templates/inputs?id=".$data_list['id']."&manage=html" ?>'"><i class="mdi mdi-code-tags"></i> Manage Fields</button>
   </div>
</div>

<div class="row">
   <div class="col-12">
        <div class="formBuilder-box">
            <form id="myForm">
                <input type="hidden" name="id" value="<?php echo $data_list['id'] ?>">  
                <div class="form-group">
                    <textarea name="formBuilder" id="formBuilder"></textarea>
                </div>
                <div class="formBuilder-actions mt-2 mb-2 text-center">
                    <button type="button" class="btn btn-danger" id="getClear"><i class="fa fa-times"></i> Clear All</button>
                    <button type="submit" class="btn btn-primary " id="getSubmit"><i class="fa fa-check"></i> Save Form</button>
                </div>
            </form>
        </div>
   </div>
</div>