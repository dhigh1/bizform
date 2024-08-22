<style>
    .fields {
        margin-top: 2px;
        background-color: #727cf524;
        color: #727cf5;
        border-radius: 5px;
        border: 1px solid #eee !important;
        padding: 5px 15px;
        margin-right: 10px;
        border: 1px solid #727cf5 !important;
    }

    .ui-sortable::-webkit-scrollbar-thumb {
        border-radius: 0;
        border: 0;
        background-color: #727cf5;
    }

    .ui-sortable::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 15px;
        height: 2px;
        background-color: #727cf530;
    }

    .ui-sortable {
        display: flex;
        flex-wrap: nowrap;
        overflow: auto;
        white-space: nowrap;
        padding: 10px 0px;
    }

    .fields.ui-sortable-handle {
        width: 100%;
        margin-bottom: 10px;
    }

    #box.ui-sortable {
        display: block !important;
        overflow: hidden;
    }

    #box {
        list-style: none;
        min-height: 200px;
        border: 1px dashed #6a6969;
        border-radius: 5px;
        padding: 10px;
    }

    h4 {
        font-weight: 400;
        margin: 0px;
        margin-top: 10px;
    }
</style>


<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <small class="alert-success"><b>Note:</b> Select Template & Sort to create campaign</small>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">
            <div id="box"></div>
            <div class="row my-2">
                <div class="col text-center">
                    <button class="btn btn-success save" data-id="<?php echo $campaign_data['data_list']['id'] ?>">Save</button>
                    <button class="btn btn-danger cancel">Cancel</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3 " id="lists">
            <?php foreach ($forms as $clist) { ?>
                <div class="fields" id="<?php echo $clist['id'] ?>" style="cursor: pointer;">
                    <?php echo $clist['name'] ?>
                </div>
            <?php } ?>
        </div>
    </div> 
</div>

<script>
    $(document).ready(function() {
        $(".fields").on('click', function() {
            $(this).clone().appendTo("#box").addClass('child_field').append("<i class='fa fa-times'></i>")
            $("#box .child_field").on('click', function() {
                $(this).remove();
            }) 
        })
        $("#box .fields").append('HELLO').addClass('child_fields');

        $("#box").sortable({
            connectWith: "#lists"
        });
        var arr = [];
        $(".save").on('click', function() {
            var camp_id = $(this).attr('data-id');
            console.log(camp_id)
            var ids = $("#box > div").map(function() {
                arr.push(this.id);
            })
            $.ajax({
                url: '<?php echo base_url() ?>campaigns/save_campaign_templates',
                data: {
                    ids: arr,
                    campaign_id: camp_id
                },
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.status == 'success') {
                        location.href = res.url;
                    } else {
                        swal('fail', res.message, '');
                    }
                }
            }, 'json')

        })
    })
</script>