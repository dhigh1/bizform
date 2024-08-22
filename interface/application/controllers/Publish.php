<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Publish extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/publish/";
		$this->script_path = $this->view_path . "script/";
		$this->style_path = $this->view_path . "style/";		
		$this->module_name = "publish";
		// $this->module_name="service_templates";
		$this->main_key = "name";
		$this->userId = User::get_userId();
	}

	public function index()
	{
		User::check_permission($this->module_name);
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if (empty($id)) {
			redirect(base_url() . 'error404');
		}
		$data = array();
		$data['title'] = "Campaign";
		$campaign_details = $this->curl->execute('campaign/'.$id, 'GET'); 
		if($campaign_details['status']=='success' && !empty($campaign_details['data_list'])){
			$data['filter_view'] =  $this->load->view($this->view_path . "filter_view", $data, true);
			$data['content_view'] =  $this->load->view($this->view_path . "main_view", $data, true);
			$data['script'] =  $this->load->view($this->script_path . "script", '', true);
			$data['style'] =  $this->load->view($this->style_path . "style", '', true);
			$this->template->user_template($data);
		}else{
			redirect(base_url().'error404');
		}
	}

	function get_datas()
	{
		$filter_data = $this->input->post('filter_data');
		$page = $this->input->post('page');
		$filterData[] = array();
		if (!empty($page)) {
			$filterData['page'] = $page;
		}
		$filterData['orderby'] = 'DESC';
		if (!empty($filter_data)) {
			foreach ($filter_data as $k => $v) {
				if ($v['type'] == 'sortby') {
					$filterData[$v['type']] = $this->db_table . '.' . $v['value'];
				} else {
					$filterData[$v['type']] = $v['value'];
				}
			}
		}
		$filterData['workorder_profiles_checks-execution_type'] = 55;
		$filterData['workorder_profiles_checks-executor_id'] = $this->userId;
		$apidata = $this->curl->execute($this->db_module, "GET", $filterData, 'filter');
		$data = array(
			'message' => $apidata['message'],
			'status' => $apidata['status'],
			'data_list' => $apidata['data_list'],
			'count' => $apidata['data_count']
		);
		$i = 0;
		if (isset($apidata['pagination_data'])) {
			$data['pagination_data'] = $apidata['pagination_data'];
		}
		$str =  $this->load->view($this->view_path . "tbl_view", $data, true);
		$value = array('message' => $str, 'status' => $apidata['status']);
		echo json_encode($value);
	}

	public function add()
	{
		$str =  $this->load->view($this->view_path . "add_view", '', true);
		$value = array('message' => $str, 'status' => 'success');
		echo json_encode($value);
	}

	public function save_data()
	{
		$data = $this->input->post();
		$data['created_by'] = $this->userId;
		$status = 'fail';
		$message = '';
		if (!empty($data)) {
			$apidata = $this->curl->execute('formbuilder', 'POST', $data);
			$status = $apidata['status'];
			$message = $apidata['message'];
		}
		$value = array('status' => $status, 'message' => $message);
		echo json_encode($value);
		exit();
	}

	function view()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		// print_r($id);
		// exit();
		if (empty($id)) {
			redirect(base_url() . 'error404');
		}
		// User::check_permission($this->module_name . '/view');
		$data = array();
		$workorder = $this->curl->execute("formbuilder/$id", "GET");
		if ($workorder['status'] == 'success' && !empty($workorder['data_list'])) {
			$data['workorder'] = $workorder['data_list'];
			// $services = $this->curl->execute("services/by_workorder/" . $id, "GET");
			// $data['services'] = $services['data_list'];
			$data['title'] = "View | " . $this->module_name;
			$data['content_view'] =  $this->load->view($this->view_path . "workorder_view", $data, true);
			$data['script'] =  $this->load->view($this->script_path . "profile_checks_script", '', true);
			$data['style'] =  $this->load->view($this->style_path . "profile_checks_style", '', true);
			$this->template->user_template($data);
		} else {
			redirect(base_url() . 'error404');
		}
	}

	public function inputs()
    {
    	User::check_permission($this->view_path.'/inputs');
    	$data=array();
    	$id=(isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : redirect(base_url().'error404');
    	$manage=(isset($_GET['manage']) && !empty($_GET['manage'])) ? $_GET['manage'] : redirect(base_url().'error404');
    	$apidata=$this->curl->execute('formbuilder'."/".$id,"GET");
    	if($apidata['status']=='success' && !empty($apidata['data_list'])){
    		$data['title']="Manage ".ucwords($manage)."| Templates";
    		$data['data_list']=$apidata['data_list'];
    		$script_data['data_list']=$apidata['data_list'];
	       	$data['content_view'] =  $this->load->view($this->view_path."inputs/".$manage."_view", $data, true);
		    $data['script'] =  $this->load->view($this->script_path."inputs/".$manage."_script",$script_data , true);
	       	$this->template->user_template($data);
    	}else{
    		redirect(base_url().'error404');
    	}
    }

    public function outputs()
    {
    	User::check_permission('formbuilder'.'/outputs');
    	$data=array();
    	$id=(isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : redirect(base_url().'error404');
    	$manage=(isset($_GET['manage']) && !empty($_GET['manage'])) ? $_GET['manage'] : redirect(base_url().'error404');
    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
    	if($apidata['status']=='success' && !empty($apidata['data_list'])){
    		$data['title']="Manage ".ucwords($manage)."| Service Templates";
    		$data['data_list']=$apidata['data_list'];
    		$script_data['data_list']=$apidata['data_list'];
	       	$data['content_view'] =  $this->load->view($this->view_path."outputs/".$manage."_view", $data, true);
		    $data['script'] =  $this->load->view($this->script_path."outputs/".$manage."_script",$script_data , true);
	       	$this->template->user_template($data);
    	}else{
    		//print_r($apidata);
    		redirect(base_url().'error404');
    	}
    }

    function save_contents()
    {
    	$status='fail';
    	$message="Something went wrong, try after sometime!";
    	$id=$this->input->post('id');
    	$manage=$this->input->post('manage');
    	$json_data=$this->input->post('json_data');
    	if(!empty($id) && !empty($manage) && !empty($json_data)){
    		$data['updated_by']=$this->userId;
    		$data[$manage.'_json']=$json_data;
			$apidata=$this->curl->execute('formbuilder'."/contents/".$id,"PUT",$data);
			$status=$apidata['status'];
			if($apidata['status']=='success'){
	    		$message=ucwords($apidata['data_list'][$this->main_key])."-".ucwords($manage)." fields has been updated";
	    		$logData=array(
					'action'=>'update',
		        	'description'=>'updated the '.$manage.' contents of a service template '.$apidata['data_list']['form_code'].', '.$apidata['data_list']['name'],
		        	'data_id'=>$apidata['data_list']['id'],
		        	'reference_id'=>User::get_userId(),
		        	'reference_name'=>User::get_userName(),
		        	'module'=>$this->module_name
		        );
		        User::activity($logData);
	    	}else{	    		
	    		$message=$apidata['message'];
	    	}
    	}else{
    		$message="Form data not found, please refresh page & try again";
    	}    	

    	$value=array('message'=>$message,'status'=>$status);
    	echo json_encode($value);
    }

	public function preview()
    {
    	User::check_permission($this->module_name.'/preview');
    	$data=array();
    	$id=(isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : redirect(base_url().'error404');
    	$type=(isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : redirect(base_url().'error404');
    	$apidata=$this->curl->execute('formbuilder'."/".$id,"GET");
    	if($apidata['status']=='success' && !empty($apidata['data_list'])){
    		$data['title']="Preview | Service Templates";
    		$data['data_list']=$apidata['data_list'];
    		$script_data['data_list']=$apidata['data_list'];
	       	$data['content_view'] =  $this->load->view($this->view_path.$type."/preview", $data, true);
		    $data['script'] =  $this->load->view($this->script_path.$type."/preview_script",$script_data , true);
		    $data['style'] =  $this->load->view($this->style_path."preview_style",'' , true);
	       	$this->template->user_template($data);
    	}else{
    		redirect(base_url().'error404');
    	}
    }
}
