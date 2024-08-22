<?php
class Report_generate_model extends CI_Model
{
	 function __construct() {
        // Set table name 
        $this->table= 'workorder_profiles_checks';
        $this->workorders_table= 'workorders'; 
        $this->workorder_profiles_table= 'workorder_profiles'; 
        $this->customers_table= 'customers'; 
        $this->customer_branches_table= 'customer_branches';  
        $this->plans_table= 'plans'; 
		
        $this->reports_table= 'workorder_profiles_checks_reports';  
		
        $this->services_table= 'services'; 
		$this->users_table = 'users';
		$this->lookups_table = 'lookups';
		
		$this->workflow_table= 'workflow'; 
		$this->log_table="workorders_log";
		
        $this->model_name='workorder_profiles_checks_model';  
    } 
	
	function generate_check_report($check_id,$data){
		
		$report_data=array();
		$return_data=array('status'=>'fail','message'=>'Unable to get the report.');
		
		$check_data = $this->Mydb->get_single_result($check_id,$this->table,$this->model_name);
		if(empty($check_data['details'])){
			$value=array('status'=>'fail','message'=>'Unable to find the check data');
			return $value;
		}
		$check_data=$check_data['details'];
		if(empty($data['input_json'])){
			$value=array('status'=>'fail','message'=>'Input data is not found');
			return $value;
		}
		if(empty($data['output_json'])){
			$value=array('status'=>'fail','message'=>'Output result data is not found, please confirm that check has been executed.');
			return $value;
		}		
		
		//prepare customer data
		$customer_data=array();
		$candidate_fields=array('customers_name','customer_branches_name');
		foreach($check_data as $candidate_key=>$candidate_value){
			if(in_array($candidate_key,$candidate_fields)){
				$candidate_key=str_replace('customers_','',$candidate_key);
				$candidate_key=str_replace('customer_branches_','branch_',$candidate_key);
				$customer_data[$candidate_key]=$candidate_value;
			}
		}
		$report_data+=array('customer_data'=>$customer_data);
		
		//prepare candidate data
		$candidate_data=array();
		$candidate_fields=array('workorders_profiles_ref_id','workorders_profiles_code','workorders_profiles_name','workorders_profiles_phone','workorders_profiles_email');
		foreach($check_data as $candidate_key=>$candidate_value){
			if(in_array($candidate_key,$candidate_fields)){
				$candidate_key=str_replace('workorders_profiles_','',$candidate_key);
				$candidate_data[$candidate_key]=$candidate_value;
			}
		}
		$report_data+=array('candidate_data'=>$candidate_data);
		
		$check_array=array();
		
		//prepare input data
		$input_data=array();
		$input_json=json_decode($data['input_json'],true);
		foreach ($input_json as $input_row){
			if(!empty($input_row['shareToReport']) && strtolower($input_row['shareToReport'])=='yes' && !empty($input_row['name'])){
			  $input_data[$input_row['name']]=implode($input_row['userData']); 
			}
		}
		$input_data['check_created_time']=$check_data['created_at'];
		$check_array+=array('input'=>$input_data);
		
		//prepare output data
		$output_data=array();
		$output_json=json_decode($data['output_json'],true);
		
		if($data['execution_type']==55){ //check if execution type is vendor (for looping as name & value)
			foreach ($output_json as $output_row){
				if(!empty($output_row['name']) && !empty($output_row['userData'])){
				  $output_data[$output_row['name']]=implode($output_row['userData']); 
				}
			}
		}if($data['execution_type']==56){ //check if execution type is api call (for looping as key & value)
			$output_data=array_flatten($output_json);			
		}
		$output_data['report_generated_time']=cur_date_time();
		
		$check_array+=array('output'=>$output_data);
		$output_name=underscore_slug($data['services_code'].'-data');
		$report_data+=array($output_name=>$check_array);		
		
		$save_path='uploads/';
		$save_path.=create_slug($check_data['workorder_code']).'/';
		$save_path.=create_slug($check_data['workorders_profiles_code']).'/';
		$save_path.=create_slug($check_data['check_code']).'/';
		
		// call function to create check log				
		$logData=array(
			'workorders_id'=>$check_data['workorders_id'],
			'workorder_profiles_id'=>$check_data['workorder_profiles_id'],
			'workorder_profiles_checks_id'=>$check_id
		);
		if(!empty($check_data['updated_by'])){
			$logData['created_by']=$check_data['updated_by'];
		}else{
			$logData['created_by']=$check_data['created_by'];
		}
		
		$customer_report_ids=$this->db->get_where('customers',['id'=>$check_data['customers_id']])->row_array();
		
		$docx_report_api=$pdf_report_api='';
		
		if(!empty($customer_report_ids['docx_report_id'])){
			$docx_report_api=$this->db->get_where('report_apis',['report_type'=>'docx'])->row_array();
		}
		if(!empty($customer_report_ids['pdf_report_id'])){
			$pdf_report_api=$this->db->get_where('report_apis',['report_type'=>'pdf'])->row_array();
		}
		
				
		//generate image report 
		$image_api=$this->db->get_where('report_apis',['report_type'=>'image'])->row_array();
		//$image_api='';
		if(!empty($image_api)){
			$get_service=$this->db->get_where('services',['id'=>$check_data['services_id']])->row_array();
			if(!empty($get_service) && !empty($get_service['report_template_id'])){
				
				$send_data=array('template'=>array('shortid'=>$get_service['report_template_id']));
				$send_data+=array('data'=>$report_data);
			
				$image_result=$this->curl->apicall($image_api['api_url'],$image_api['api_method'],$image_api['api_auth'],$send_data);
				$image_result=$image_result['result'];
				//print_r($image_result);exit();
				
				if(!empty($image_result) && $image_result['status']==200 && !empty($image_result['report_url'])){
					$file_name=create_slug($check_data['check_code']).'.png';				
					$upload_res=upload_report_file($image_result['report_url'],$save_path,$file_name,'url');
					if($upload_res['status']=='success'){
						$image_report_status='success';
						$save_report_data=array(
							'workorder_profiles_checks_id'=>$check_id,
							'workorder_profiles_id'=>$check_data['workorder_profiles_id'],
							'workorders_id'=>$check_data['workorders_id'],
							'userId'=>$logData['created_by'],
							'report_type'=>'image',
							'report_url'=>$upload_res['file_url']
						);
						$this->save_check_report($save_report_data);
						
						$logData['description']='Generated the image report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].'). Stored the report in the respective folder.';
					}else{					
						$logData['description']='Unable to generate the image report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].').Reason - Failed to download the report from report api.';
					}				
				}else{
					$logData['description']='Unable to generate the image report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].').Reason - report api returned failure status';
				}
				$this->save_check_log($logData);
			}
		}
		
		
		//generate docx report		
		
		if(!empty($docx_report_api)){
			//get report id tagged to the customer 
			
			
			if(empty($customer_report_ids['docx_report_id'])){
				$return_data=array('status'=>'fail','message'=>'Report id is not found for the customer '.$customer_report_ids['name']);
				return $return_data;
			}		
			$send_data=array('template'=>array('shortid'=>$customer_report_ids['docx_report_id']));
			$send_data+=array('data'=>$report_data);
			
			//call external api to get the docx report prepared
			$api_result=$this->curl->apicall($docx_report_api['api_url'],$docx_report_api['api_method'],$docx_report_api['api_auth'],$send_data);
			$report_result=$api_result['result'];
			
			if(!empty($report_result) && $report_result['status']==200 && !empty($report_result['report_url'])){
				
				$file_name=create_slug($check_data['check_code']).'.docx';
				
				$download_res=upload_report_file($report_result['report_url'],$save_path,$file_name,'url');				
					
				if($download_res['status']=='success'){
					//$up_data['report_url'] = $download_res['file_url'];
					$up_data['status']=8;
					$up_data['updated_at'] = cur_date_time();
					$this->Mydb->update_table_data($this->table,array('id'=>$check_id),$up_data);
					
					// call function to create date log	
					$date_data=array(
						'id'=>$check_id,
						'date_type'=>'check_report_generated_at',
						'date_value'=>$up_data['updated_at'],
						'userId'=>$logData['created_by']
					);
					
					//save report data
					$save_report_data=array(
						'workorder_profiles_checks_id'=>$check_id,
						'workorder_profiles_id'=>$check_data['workorder_profiles_id'],
						'workorders_id'=>$check_data['workorders_id'],
						'userId'=>$logData['created_by'],
						'report_type'=>'docx',
						'report_url'=>$download_res['file_url']
					);
					$this->save_check_report($save_report_data);					
					
					$this->save_date_log($date_data);

					$logData['description']='Generated the docx report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].'). Stored the report in the respective folder & updated the status.';
					
					$return_data=array('status'=>'success','message'=>'Report generated successfully.');
				}else{					
					$logData['description']='Unable to generate the docx report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].').Reason - Failed to download the report from report api.';
					
					$return_data=array('status'=>'fail','message'=>'Unable to download the docx report from report api.');
				}				
			}else{
				$logData['description']='Unable to generate the docx report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].').Reason - report api returned failure status';
				
				$return_data=array('status'=>'fail','message'=>'Unable to generate the report, report api returned failure status.');
			}
			$this->save_check_log($logData);
		}
		
		
		//generate pdf report
		
		if(!empty($pdf_report_api) && $check_data['services_code']=='crc'){
			//get report id tagged to the customer 
			
			
			if(empty($customer_report_ids['pdf_report_id'])){
				$return_data=array('status'=>'fail','message'=>'Report id is not found for the customer '.$customer_report_ids['name']);
				return $return_data;
			}		
			$send_data=array('template'=>array('shortid'=>$customer_report_ids['pdf_report_id']));
			$send_data+=array('data'=>$report_data);
			
			//call external api to get the docx report prepared
			$api_result=$this->curl->apicall($pdf_report_api['api_url'],$pdf_report_api['api_method'],$pdf_report_api['api_auth'],$send_data);
			$report_result=$api_result['result'];
			
			if(!empty($report_result) && $report_result['status']==200 && !empty($report_result['report_url'])){
				
				$file_name=create_slug($check_data['check_code']).'.pdf';
				
				$download_res=upload_report_file($report_result['report_url'],$save_path,$file_name,'url');				
					
				if($download_res['status']=='success'){
					//$up_data['report_url'] = $download_res['file_url'];
					$up_data['status']=8;
					$up_data['updated_at'] = cur_date_time();
					$this->Mydb->update_table_data($this->table,array('id'=>$check_id),$up_data);
					
					// call function to create date log	
					$date_data=array(
						'id'=>$check_id,
						'date_type'=>'check_report_generated_at',
						'date_value'=>$up_data['updated_at'],
						'userId'=>$logData['created_by']
					);
					
					//save report data
					$save_report_data=array(
						'workorder_profiles_checks_id'=>$check_id,
						'workorder_profiles_id'=>$check_data['workorder_profiles_id'],
						'workorders_id'=>$check_data['workorders_id'],
						'userId'=>$logData['created_by'],
						'report_type'=>'pdf',
						'report_url'=>$download_res['file_url']
					);
					$this->save_check_report($save_report_data);					
					
					$this->save_date_log($date_data);

					$logData['description']='Generated the pdf report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].'). Stored the report in the respective folder & updated the status.';
					
					$return_data=array('status'=>'success','message'=>'Report generated successfully.');
				}else{					
					$logData['description']='Unable to generate the pdf report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].').Reason - Failed to download the report from report api.';
					
					$return_data=array('status'=>'fail','message'=>'Unable to download the pdf report from report api.');
				}				
			}else{
				$logData['description']='Unable to generate the pdf report for - '.$check_data['services_name'].' ('.$check_data['code'].') from the profile '.$check_data['workorders_profiles_name'].' ('.$check_data['workorders_profiles_code'].').Reason - report api returned failure status';
				
				$return_data=array('status'=>'fail','message'=>'Unable to generate the report, report api returned failure status.');
			}
			$this->save_check_log($logData);
		}
		
		//$return_data=array('status'=>'success','data'=>$report_data);
		return $return_data;
	}
	
	function save_check_report($data){
		$where=array(
			'workorder_profiles_checks_id'=>$data['workorder_profiles_checks_id'],
			'workorder_profiles_id'=>$data['workorder_profiles_id'],
			'workorders_id'=>$data['workorders_id'],
			'report_type'=>$data['report_type']
		);
		$get_data=$this->db->get_where('workorder_profiles_checks_reports',$where)->row_array();
		if(!empty($get_data)){
			$data['updated_at']=cur_date_time();
			$data['updated_by']=$data['userId'];
			unset($data['userId']);
			$this->Mydb->update_table_data('workorder_profiles_checks_reports',array('id'=>$get_data['id']),$data);
		}else{
			$data['created_at']=cur_date_time();
			$data['created_by']=$data['userId'];	
			unset($data['userId']);			
			$this->Mydb->insert_table_data('workorder_profiles_checks_reports',$data);
		}
	}	
	
	function save_check_log($data){
		$data['created_at']=cur_date_time();
		$data['ip_address']=getRealIpAddr();
		$this->Mydb->insert_table_data('workorders_log',$data);
	}	
	
	function save_date_log($data){
		$date_data=array(
			'data_id'=>$data['id'],
			'data_table'=>$this->table,
			'date_type'=>$data['date_type'],
			'date_value'=>$data['date_value']
		);
		$userId=0;
		if(isset($data['userId'])){
			$userId=$data['userId'];
		}
		$where=array(
			'data_id'=>$data['id'],
			'data_table'=>$this->table,
			'date_type'=>$data['date_type']
		);
		$get_data=$this->db->get_where('datetime_data',$where)->row_array();
		if(!empty($get_data)){
			$date_data['updated_at']=cur_date_time();
			$date_data['updated_by']=$userId;
			$this->Mydb->update_table_data('datetime_data',array('id'=>$get_data['id']),$date_data);
		}else{
			$date_data['created_at']=cur_date_time();
			$date_data['created_by']=$userId;			
			$this->Mydb->insert_table_data('datetime_data',$date_data);
		}
		
	}	
}