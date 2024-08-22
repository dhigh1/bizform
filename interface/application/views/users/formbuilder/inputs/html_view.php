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
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>formbuilder">Forms</a></li>
                    <li class="breadcrumb-item">Edit Form</li>
                </ol>
            </div>
            <h4 class="page-title">Edit Data Fields</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="alert alert-success text-center">Manage input data fields of a template <b><?php echo $data_list['name'] ?></b></div>
    </div>
    <div class="col-12 d-flex justify-content-end mb-2">
        <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='<?php echo base_url() . 'formbuilder/preview?id=' . $data_list['id'] . "&type=inputs" ?>'"><i class="mdi mdi-eye"></i> Preview</button>
    </div>
</div>
<style type="text/css">
    .template-fied-fields {
        margin-bottom: 10px;
    }

    .template-fied-fields .form-group {
        padding: 6px;
        clear: both;
        margin-right: 0px;
        margin-bottom: 10px;
        background-color: #f2f2f2;
        border: solid 1px #dcdcdc;
        border-radius: 5px;
    }

    .template-fied-fields .form-group label {
        margin-bottom: 0px;
    }
</style>

<div class="row">
    <div class="col-12 header">

    </div>
</div>
<div class="row">
    <div class="col-12">
        <h5>Custom Fields</h5>
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
