<link href="<?php echo base_url(); ?>ui/assets/plugins/select2/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>ui/assets/plugins/select2/select2.min.js"></script>
<?php $i = 1; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <form id="myForm">
                <div class="row">
                    <input type="hidden" name="id" value="<?php if(isset($campaign_data['id']) && $campaign_data['id']!=''){echo $campaign_data['id'];}  ?>">
                    <div class="col-lg-4">
                        <div class="form-group my-2">
                            <label for="">Campaign Name**</label>
                            <input type="text" value="<?php if(isset($campaign_data['name']) && $campaign_data['name']!=''){echo $campaign_data['name'];}  ?>" name="name" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group my-2">
                            <label for="">Details**</label>
                            <input type="text" value="<?php if(isset($campaign_data['description']) && $campaign_data['description']!=''){echo $campaign_data['description'];}  ?>" name="details" id="" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group my-2">
                            <label for="">Date**</label>
                            <input type="datetime-local" value="<?php if(isset($campaign_data['campaign_date']) && $campaign_data['campaign_date']!=''){echo date($campaign_data['campaign_date']);}  ?>" name="date" id="" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Custom URL</label>
                            <input type="text" value="<?php if(isset($campaign_data['url']) && $campaign_data['url']!=''){echo $campaign_data['url'];}  ?>" name="url" id="" class="form-control" placeholder="example: general-campaign">
                            <p class="invalid_url"></p>
                        </div>
                    </div>
                </div>
                <div class="my-3 form-group d-flex justify-content-center align-items-center">
                    <input type="submit" value="Create" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    if ($("#myForm").length > 0) {
        save_data();
    }

    function save_data() {
        var formName = '#myForm';
        var ajax_type = 'button';
        var ajax_text = 'Processing...';
        var url = 'campaigns/edit_data';
        $(formName).validate({
            errorClass: 'error',
            validClass: 'valid',
            rules: {},
            messages: {},
            errorPlacement: function(error, element) {
                if (element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                ajax_request(formName, url, ajax_type, ajax_text, render_save_data);
            }
        });
    }

    function render_save_data(returnData) {
        if (returnData.status == "success" && returnData.url != '') {
            $(".bootbox.userModalView").find('.bootbox-close-button').trigger('click');
            show_toast('success', returnData.message);
            location.href = returnData.url;
        } else {
            failureResult('#myForm', returnData.message, false);
        }
    }
</script>