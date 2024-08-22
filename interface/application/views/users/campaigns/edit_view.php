<style>
    .fields {
        margin-top: 2px;
        background-color: #727cf524;
        color: #727cf5;
        border-radius: 5px;
        /* border: 1px solid #eee !important; */
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

    .order {
        width: 400px;
    }
</style>


<link href="<?php echo base_url(); ?>ui/assets/plugins/select2/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>ui/assets/plugins/select2/select2.min.js"></script>
<?php $i = 1; ?>
<div class="container">
    <form id="myForm">
        <div class="div_res"></div>
        <input type="hidden" name="forms" required>
        <input type="hidden" name="campaign_id" value="<?php echo $id ?>">
        <div class="row">
            <div class="col">
                <!-- begining form here -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group my-2">
                            <label for="">Campaign Name <span class="text-danger">*</span></label>
                            <input type="text" value="<?php if (isset($campaign_data['name']) && $campaign_data['name'] != '') {
                                echo $campaign_data['name'];
                            } ?>" name="name" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group my-2">
                            <label for="">Description</label>
                            <input type="text" value="<?php if (isset($campaign_data['description']) && $campaign_data['description'] != '') {
                                echo $campaign_data['description'];
                            } ?>" name="details" id="" class="form-control">
                        </div>
                    </div>
                    <!-- <div class="col-lg-4">
                        <div class="form-group my-2">
                            <label for="">Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" value="<?php //if (isset($campaign_data['campaign_date']) && $campaign_data['campaign_date'] != '') {
                                //echo date($campaign_data['campaign_date']);
                            //} ?>" name="date" id="" class="form-control" required>
                        </div>
                    </div> -->
                    <div class="col-lg-4">
                        <div class="form-group my-2">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="status" id="" class="form-select">
                                <option value="79" <?php echo ($campaign_data['status']==79)?'selected':'' ?>>Active</option>
                                <option value="80" <?php echo ($campaign_data['status']==80)?'selected':'' ?>>Hold</option>
                                <option value="81" <?php echo ($campaign_data['status']==81)?'selected':'' ?>>Stop</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <small class="alert-success"><b>Note:</b> Select Template & Sort to create campaign</small>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9">
                <input type="hidden" name="">
                <div id="box"></div>
                <!-- <div class="row my-2">
                    <div class="col text-center">
                        <button class="btn btn-success save"
                            data-id="<?php //echo $campaign_data['data_list']['id'] ?>">Save</button>
                        <button class="btn btn-danger cancel">Cancel</button>
                    </div>
                </div> -->
            </div> 
            <div class="col-sm-3 " id="lists" style="max-height: 200px; overflow-y: scroll;" >
                <?php foreach ($forms as $clist) { ?>
                    <div class="fields" id="<?php echo $clist['id'] ?>" style="cursor: pointer;">
                        <?php echo $clist['name'] ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="my-3 form-group d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>


</div>

<script>
    // use strict;
    $(document).ready(function () {
        let arr = [];
        (() => {
            $.post('campaigns/getSelectedForm', { id: '<?php echo $id ?>' }, (response) => {
                arr = [];
                if (response.status == 'success' && response.data) {
                    //Get All of the forms
                    const allForms = response.data.forms;
                    //Get Selected forms
                    const selectedForms = response.data.selected_forms;
                    let elements = [];
                    for (selectedForm of selectedForms) {
                        let data = allForms.find(element => element.id === selectedForm.form_id);
                        //Appending elements
                        const elem = `<div class="fields child_field order" id="${selectedForm.form_id}" style="cursor: pointer; width: 500px; display: flex; justify-content: space-between;">
                                ${data.name}
                                <div style="display: 'flex'; justify-content: 'space-between'">
                                <a class="btn btn-sm btn-danger remove">
                                    <i class="fa fa-times mx-2"></i>
                                </a>
                                <span class="badge bg-primary step px-2"></span>
                                </div>
                            </div>`;
                        arr.push('hello');
                        elements.push(elem);
                        //end appending elements
                    }
                    // console.log(elements);
                    $("#box").html(elements);
                    changeElements();
                    sortElements();
                    removeElements();
            updateStepNumbers();

                } else {
                    console.log('no data found');
                }
            }, 'json')
        })();

        const changeElements = () => {
            arr = [];
            const ids = $("#box > div").map(function () {
                arr.push(this.id);
            })
            if(arr.length>0){
                const jsonStr = JSON.stringify(arr);
                $("input[name='forms']").val(jsonStr);
            }else{
                $("input[name='forms']").val('');
            }
        }


        $(".fields").on('click', function () { 
            $(this).clone().css({ width: '500px', display: 'flex', justifyContent: 'space-between' }).appendTo("#box").addClass('child_field order').append(`<div style="display: 'flex'; justify-content: 'space-between'"><a class='btn btn-sm btn-danger remove'><i class='fa fa-times mx-2'></i></a><span class="badge bg-primary step px-2"></span></div>`)
            changeElements();
            sortElements();
            removeElements();
            updateStepNumbers();
        })

        const removeElements = () => {
            $(".remove").on('click', function () {
                arr = []
                $(this).parent().parent().remove();
                changeElements();
                updateStepNumbers();
            })
        }

        const sortElements = () => {
            $("#box").sortable({
                connectWith: '#lists',
                update: function (event, ui) {
                    changeElements();
                    updateStepNumbers();
                }
            });
        }

        const updateStepNumbers = () => {
            $(".step").each(function(index) {
                var stepNumber = index + 1;
                $(this).text(`Step - ${stepNumber}`);
            });
        }
    })
</script>