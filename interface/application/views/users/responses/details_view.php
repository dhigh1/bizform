<style>
    .table>:not(caption)>*>* {
        padding: 5px !important;
    }    
    .fancybox__content{
        height: 100% !important ;
        padding: 0px !important;
    }
    .fancybox-iframe {
        height: 500px;
    }

</style>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Responses</li>
                </ol>
            </div>
            <h4 class="page-title"> Responses Details</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<?php if(!empty($campaign_data)){ ?>
<div class="row">
    <h5 class="text-primary">URI - <a href="<?php echo base_url().'forms?campaign='.$campaign_data['url'].'&response='.$candidate_id ?>" target="_blank"><?php echo base_url().'forms?campaign='.$campaign_data['url'].'&response='.$candidate_id ?></a></h5>
</div>
<?php } ?>
<div class="row card p-2">
    <?php foreach ($responses as $response) { ?>
        <?php if($response['status']==76){ ?>
        <div class="row">
            <div class="col">
                <h4><?php echo $response['form_name']; $response['status']==1 ? print_r('<span class=" mx-2 badge bg-success"> Completed</span>') : '' ?> </h4>
                <table class="table table-bordered">
                    <thead>
                        <th>Label</th>
                        <th>Value</th>
                    </thead>
                    <tbody>
                        <?php $responses = json_decode($response['output_json'], true);
                        foreach ($responses as $response) { ?>
                            <tr>
                                <td><?php echo $response['label'] ?></td>
                                <td>
                                    <?php
                                    if($response['type']!='file'){
                                        $val = !empty($response['userData'][0]) ? $response['userData'][0] : '';
                                        echo $val;
                                    }else{ ?>
                                    <?php 
                                        foreach($uploads_data as $upload){ 
                                        if($upload['input_name']==$response['name']){ ?>
                                        <a href="<?php echo base_url().$upload['file_path'].$upload['file_name'] ?>" data-fancybox="preview">
                                            <i class="fa fa-eye text-primary"></i> View
                                        </a>
                    <!-- <a class="btn btn-success btn-sm mr-2" href='<?php //echo base_url() . $data_row['report_url'] ?>' data-fancybox="report">Report <i class="fa fa-eye"></i></a> -->

                                    <?php } } ?>
                                    <?php } ?>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    <?php }else{ ?>
        <div class="my-2"><?php echo $response['form_name'] ?> <span class="badge bg-danger">Pending</span></div>
    <?php } } ?>
</div>

<script>
    $(document).ready(function(){
        Fancybox.bind("[data-fancybox]", {
        // Your custom options
        });
    })
</script>