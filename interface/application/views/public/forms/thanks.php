<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="alert alert-success text-center">Thank You. The Form is submitted successfully.</h2>
        </div>
    </div>
    <?php if(!empty($campaign_data)){ ?>
    <div class="row">
        <h3 class="text-primary text-center" style="text-decoration: underline">Your Data</h3>
        <?php 
        
        $filterData['candidate_form_lists-candidate_id'] = $candidate_id;
        $responses = $this->curl->execute("responses/responses", "GET", $filterData, 'filter'); 
        if($responses['status']=='success' && !empty($responses['data_list'])){    
            $apidata = $this->curl->execute("responses/response_uploads", "GET", array('candidate_id'=>$candidate_id), 'filter');
            $uploads_data = $apidata['data_list'];
            if(count($responses['data_list'])>1){ ?>
                <?php foreach($responses['data_list'] as $response){ ?>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="2"> <h3 class="text-center text-primary"><?php echo $response['form_name']; ?></h3> </td>
                                </tr>
                                <?php foreach(json_decode($response['output_json'], TRUE) as $form_json){ ?>
                                <tr>
                                    <td><?php echo $form_json['label'] ?></td>
                                    <td>
                                        <?php
                                            if($form_json['type']!='file'){
                                                echo !empty($form_json['userData'][0]) ? $form_json['userData'][0] : '';
                                            }else{ 
                                                foreach($uploads_data as $upload){ 
                                                if($upload['input_name']==$form_json['name']){ ?>
                                                <a href="<?php echo base_url().$upload['file_path'].$upload['file_name'] ?>" data-fancybox="preview">
                                                    <i class="fa fa-eye text-primar"></i> View
                                                </a>
                                            <?php } } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                <?php }else{ ?>              
                    <?php $response = $responses['data_list'][0]; ?>
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td colspan="2"> <h3 class="text-center text-primary"><?php echo $response['form_name']; ?></h3> </td>
                                    </tr>
                                    <?php foreach(json_decode($response['output_json'], TRUE) as $form_json){ ?>
                                    <tr>
                                        <td><?php echo $form_json['label'] ?></td>
                                        <td>
                                            <?php
                                                if($form_json['type']!='file'){
                                                    echo !empty($form_json['userData'][0]) ? $form_json['userData'][0] : '';
                                                }else{ 
                                                    foreach($uploads_data as $upload){ 
                                                        // print_r($upload);
                                                        // echo "<hr>";
                                                    if($upload['input_name']==$form_json['name']){ ?>
                                                    <a href="<?php echo base_url().$upload['file_path'].$upload['file_name'] ?>" data-fancybox="preview">
                                                        <!-- <img src="<?php //echo base_url().$upload['file_path'].$upload['file_name'] ?>" width="100" /> -->
                                                        <i class="fa fa-eye text-primar"></i> View
                                                    </a>
                                                <?php } } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
               <?php } ?>
        <?php } ?>
    </div>
    <?php } ?>
</div>


<script>
    $(document).ready(function(){
        Fancybox.bind("[data-fancybox]", {
        // Your custom options
        });
    })
</script>