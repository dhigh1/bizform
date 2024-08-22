<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utils extends CI_Controller {

	function __construct(){
		parent::__construct();
		//User::check_session();
	}

	public function index()
	{
		redirect(base_url().'error404');
	}
	
    public function update_json_data() {
		$id=$this->input->post('id');
    	$data_type=$this->input->post('data_type');
    	$data_fields=$this->input->post('data_fields');
    	$module=$this->input->post('module');
    	$json_module=array('data_type'=>$data_type);
    	$json_value['data_value']=array();

    	foreach ($data_fields as $k => $v) {
			$json_value['data_value'][$v['name']]=$v['value'];
		}
		$json_array[]=array_unique(array_merge($json_module,$json_value),SORT_REGULAR);
		$data=array('data_fields'=>json_encode($json_array));

		$apidata=$this->curl->execute("$module/custom_fields/$id","PUT",$data);
		if($apidata['status']=='success'){
			$logData=array(
				'action'=>'update',
	        	'description'=>'updated the '.$data_type.' details',
	        	'data_id'=>$id,
	        	'module'=>$module
	        );
	        User::activity($logData);
		}
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status']);
    	echo json_encode($value);
    }

    function api_get_request(){
    	$apiUrl=$this->input->post('apiUrl');
    	$method=$this->input->post('method');
    	if(isset($_POST['data_fields']) && $_POST['data_fields']!=''){
    		$data_fields=$this->input->post('data_fields');	
    		$apidata=$this->curl->execute($apiUrl,$method,$data_fields);
    	}else{
    		$apidata=$this->curl->execute($apiUrl,$method);
    	}
    	$data_list='';
    	//print_r($data_fields);
    	if($apidata['data_list']!=''){
    		$data_list=$apidata['data_list'];
    	}
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$data_list);
    	echo json_encode($value);
    }

    function get_state_by_country(){
		$id=$this->input->post('id');
    	$apidata=$this->curl->execute("state","GET",array('country_id'=>$id));
    	$datas=[];
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row=>$state) {
				$datas[] = array(
					'id' => $state['id'],
					'name' => $state['name']
				);
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas);
    	echo json_encode($value);
    }


    function get_city_by_state(){
		$id=$this->input->post('id');
    	$apidata=$this->curl->execute("city","GET",array('state_id'=>$id));
    	$datas=[];
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row=>$state) {
				$datas[] = array(
					'id' => $state['id'],
					'name' => $state['name']
				);
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas);
    	echo json_encode($value);
    }


    function get_city_by_state_name(){
		$name=$this->input->post('id');
    	$apidata=$this->curl->execute("city/by_name","GET",array('name'=>$name));
    	$datas=[];
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row=>$state) {
				$datas[] = array(
					'id' => $state['id'],
					'name' => $state['name']
				);
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas);
    	echo json_encode($value);
    }    

    function get_depts_by_branch(){
    	$id=$this->input->post('id');
    	$apidata=$this->curl->execute("department","GET",array('branch_id'=>$id));
    	$datas=[];
    	$i=0;
    	$list_options='';
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row) {
				$datas[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'parent' => $row['parent'],
					'organization_branches_id' => $row['organization_branches_id'],
					'status' => $row['status'],
					'created_at' => $row['created_at'],
					'created_by' => $row['created_by'],
					'updated_at' => $row['updated_at'],
					'updated_by' => $row['updated_by'],
				);
				if(isset($row['_children']) && !empty($row['_children'])){
					$datas[$i]['_children']=$row['_children'];
				}
				$i++;
			}

			if(!empty($datas)){
				$data['datas']=$datas;
            	$list_options=$this->load->view('users/department/department_list_options',$data,true);
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas,'list_options'=>$list_options);
    	echo json_encode($value);
    }

    function get_roles_by_dept(){
    	$id=$this->input->post('id');
    	$apidata=$this->curl->execute("roles","GET",array('departments_id'=>$id));
    	$datas=[];
    	$i=0;
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row) {
				$datas[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'description' => $row['description'],
					'departments_id' => $row['departments_id'],
					'status' => $row['status'],
					'departments_name' => $row['departments_name'],
					'organization_branches_name' => $row['organization_branches_name'],
					'created_at' => $row['created_at'],
					'created_by' => $row['created_by'],
					'updated_at' => $row['updated_at'],
					'updated_by' => $row['updated_by'],
				);
				$i++;
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas);
    	echo json_encode($value);
    }

    function get_branches_by_customer(){
		$id=$this->input->post('id');
    	$apidata=$this->curl->execute("customer_branches","GET",array('customers_id'=>$id,'perpage'=>1000,'sortby'=>'customer_branches-name','orderby'=>'ASC'));
    	$datas=[];
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row=>$state) {
				$datas[] = array(
					'id' => $state['id'],
					'name' => $state['branch_code'].'-'.$state['name']
				);
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas);
    	echo json_encode($value);
    }

    function get_contact_persons_by_branch()
    {
    	$id=$this->input->post('id');
    	$apidata=$this->curl->execute("customer_branches_persons","GET",array('customer_branches_id'=>$id,'perpage'=>1000,'sortby'=>'customer_branches_persons-name','orderby'=>'ASC'));
    	$datas=[];
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row=>$state) {
				$datas[] = array(
					'id' => $state['id'],
					'name' => $state['name'],
					'email' => $state['email'],
					'phone' => $state['phone'],
					'designation' => $state['designation']
				);
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas);
    	echo json_encode($value);
    }

    function getFilterList(){
    	$filter_data=$this->input->post('filter_data');
    	$module=$this->input->post('module');
    	$page=$this->input->post('page');
    	$filterData[]=array();
    	if(!empty($page)){
    		$filterData['page']=$page;
    	}
    	$filterData['orderby']='DESC';
    	if(!empty($filter_data)){
	    	foreach ($filter_data as $k => $v) {
				if($v['type']=='sortby'){
					$filterData[$v['type']]=$module.'.'.$v['value'];
				}else{					
					$filterData[$v['type']]=$v['value'];
				}
			}
		}
		User::check_permission($module.'/getFilterList');
    	$apidata=$this->curl->execute($module,"GET",$filterData,'filter');
    	$data=array(
    		'message'=>$apidata['message'],
    		'status'=>$apidata['status'],
    		'data_list'=>$apidata['data_list'],
    	);
    	if(isset($apidata['pagination_data'])){
    		$data['pagination_data']=$apidata['pagination_data'];
    	}
    	$str =  $this->load->view("users/".$module."/tbl_view", $data, true);
    	$value=array('message'=>$str,'status'=>$apidata['status']);
    	echo json_encode($value);
    }

    function delete_data(){
    	$module=$this->input->post('module');
    	$id=$this->input->post('id');
    	$display_name=$this->input->post('display_name');
		User::check_permission($module.'/delete');
    	$data=array('users_id'=>User::get_userId());
    	$apidata=$this->curl->execute($module.'/'.$id,"DELETE",$data); 
    	$message=$apidata['message'];
    	if($apidata['status']=='success' && !empty($apidata['data_list'])){
    		//print_r($apidata['data_list']);
    		$message=ucwords($apidata['data_list'][$display_name])."-".$apidata['message'];
    		Activity::module_log($module.'_delete','user',$apidata['data_list']);
    	}
    	$value=array('message'=>$message,'status'=>$apidata['status']);
    	echo json_encode($value);
    }

    function export_data()  
    { 
    	$module=$this->input->post('module');
    	$id=$this->input->post('id');

    	//check user permissions
    	User::check_permission($module.'/export_data');

    	$apidata=$this->curl->execute($module.'/export',"GET");
    	$file_url='';
    	if($apidata['status']=='success' && !empty($apidata['data_list'])){
    		$file_url=$apidata['data_list']['url'];

    		$logData=array(
				'action'=>'export',
	        	'description'=>'exported as excel & downloaded all the datas',
	        	'data_id'=>0,
	        	'module'=>$module
	        );
	        User::activity($logData);
    	}
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'file_url'=>$file_url);
    	echo json_encode($value);
    }

    function get_service_executors(){
		$execution_type=$this->input->post('execution_type');
		$name_prefix='';
		if($execution_type=='54'){
			$apidata=$this->curl->execute('users',"GET",array('orderby'=>'ASC','sortby'=>'users.login_id'));
			$name_value='login_id';
			$name_prefix='User - ';
		}else if($execution_type=='55'){
			$apidata=$this->curl->execute('vendors',"GET",array('orderby'=>'ASC','sortby'=>'vendors.name'));
			$name_value='name';
			$name_prefix='Vendor - ';
		}else if($execution_type=='56' || $execution_type=='57'){
			$apidata=$this->curl->execute('external_apis',"GET",array('orderby'=>'ASC','sortby'=>'external_apis.name'));
			$name_value='name';
			$name_prefix='API - ';
		}
    	//print_r($apidata);
    	$datas=[];
    	if($apidata['status']=='success' && is_array($apidata['data_list'])){
    		foreach ($apidata['data_list'] as $row=>$row_data) {
				$datas[] = array(
					'id' => $row_data['id'],
					'name' => $name_prefix.$row_data[$name_value]
				);
			}
    	}
    	//print_r($datas);
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'data_list'=>$datas);
    	echo json_encode($value);
    }    



}