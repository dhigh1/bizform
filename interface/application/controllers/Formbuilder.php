<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Formbuilder extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/formbuilder/";
		$this->script_path = $this->view_path . "script/";
		$this->style_path = $this->view_path . "style/";
		$this->module_name = "formbuilder";
		$this->main_key = "name";
		$this->userId = User::get_userId();
	}

	public function index()
	{
		// User::check_permission($this->module_name);
		$data['title'] = "Form Builder";
		$data['userId'] = $this->userId;
		$data['filter_view'] =  $this->load->view($this->view_path . "filter_view", $data, true);
		$data['content_view'] =  $this->load->view($this->view_path . "main_view", $data, true);
		$data['script'] =  $this->load->view($this->script_path . "script", '', true);
		$data['style'] =  $this->load->view($this->style_path . "style", '', true);
		$this->template->user_template($data);
	}

	public function add()
	{
		User::check_permission('formbuilder/add');
		$data = array();
		$categories = $this->curl->execute('form_categories', 'GET', array('perpage'=>1000));
		if($categories['status']=='success' && !empty($categories['data_list'])){
			$data['categories'] = $categories['data_list'];
		}
		$str =  $this->load->view($this->view_path . "add_view", $data, true);
		$value = array('message' => $str, 'status' => 'success');
		echo json_encode($value);
	}

	public function edit()
	{
		User::check_permission('formbuilder/edit');
		$id = $this->input->post('id');
		$data = array();
		$data['categories']= '';
		$data['form'] = '';
		$categories = $this->curl->execute('form_categories', 'GET');
		if($categories['status']=='success' && !empty($categories['data_list'])){
			$data['categories'] = $categories['data_list'];
		}
		$apidata = $this->curl->execute('formbuilder/' . $id, 'GET');
		if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
			$data['form'] = $apidata['data_list'];
		}
		$str =  $this->load->view($this->view_path . "edit_view", $data, true);
		$value = array('message' => $str, 'status' => 'success');
		echo json_encode($value);
	}
	
	public function save_data()
	{
		$id = $this->input->post('id');
		$status = 'fail';
		$saveType = 'add';
		$url = '';
		$message = '';
		$data = $this->input->post();
		if (!empty($id)) {
			$saveType = 'edit'; 
			$data['updated_by'] = $this->userId;
			$apidata = $this->curl->execute('formbuilder/'.$id, 'PUT', $data);
			$activity_name=$this->module_name.'_update';
			// Activity::module_log($activity_name,'user',$apidata['data_list']);
		}else{
			$data['created_by'] = $this->userId;
			$data['created_at'] = cur_datetime();
			$apidata = $this->curl->execute('formbuilder', 'POST', $data);
			$activity_name=$this->module_name.'_create';
		}
		
		if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
			if(empty($id)){
				$id = $apidata['data_list']['id'];
			}
			$url = base_url() . 'formbuilder/inputs?id=' . $id . '&manage=html';
			Activity::module_log($activity_name,'user',$apidata['data_list']);
		}
		$status = $apidata['status'];
		$message = $apidata['message'];
		$value = array('status' => $status, 'message' => $message, 'url' => $url, 'saveType'=>$saveType);
		echo json_encode($value);
		exit();
	}


	public function inputs()
	{
		User::check_permission('formbuilder/inputs');
		$data = array();
		$id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : redirect(base_url() . 'error404');
		$manage = (isset($_GET['manage']) && !empty($_GET['manage'])) ? $_GET['manage'] : redirect(base_url() . 'error404');
		$apidata = $this->curl->execute($this->module_name . "/" . $id, "GET");
		if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
			$data['title'] = "Manage " . ucwords($manage) . "| Templates";
			$data['data_list'] = $apidata['data_list'];
			$script_data['data_list'] = $apidata['data_list'];
			$data['content_view'] =  $this->load->view($this->view_path . "inputs/" . $manage . "_view", $data, true);
			$data['script'] =  $this->load->view($this->script_path . "inputs/" . $manage . "_script", $script_data, true);
			$this->template->user_template($data);
		} else {
			redirect(base_url() . 'error404');
		}
	}


	function save_contents()
	{
		$status = 'fail';
		$message = "Something went wrong, try after sometime!";
		$id = $this->input->post('id');
		$manage = $this->input->post('manage');
		$json_data = $this->input->post('json_data');
		$new_data = json_decode($json_data);
		if (!empty($id) && !empty($manage) && !empty($json_data)) {
			$data['updated_by'] = $this->userId;
			$data[$manage . '_json'] = $json_data;
			$apidata = $this->curl->execute($this->module_name . "/contents/" . $id, "PUT", $data);
			$status = $apidata['status'];
			if ($apidata['status'] == 'success') {
				$message = ucwords($apidata['data_list'][$this->main_key]) . "-" . ucwords($manage) . " fields has been updated";
				$logData = array(
					'action' => 'update',
					'description' => 'updated the ' . $manage . ' contents of a service template ' . $apidata['data_list']['form_code'] . ', ' . $apidata['data_list']['name'],
					'data_id' => $apidata['data_list']['id'],
					'reference_id' => User::get_userId(),
					'reference_name' => User::get_userName(),
					'module' => $this->module_name
				);
				User::activity($logData);
			} else {
				$message = $apidata['message'];
			}
		} else {
			$message = "Form data not found, please refresh page & try again";
		}

		$value = array('message' => $message, 'status' => $status);

		echo json_encode($value);
	}

	public function render_template()
	{
		User::check_permission($this->module_name . '/preview');
		$data = array();
		$id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : redirect(base_url() . 'error404');
		$filterData['campaigns_list-campaign_id'] = $id;
		$apidata = $this->curl->execute("campaigns_detail/" . $id, "GET", $filterData, 'filter');
		if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
			$data['title'] = "Preview | Service Templates";
			$data['data_list'] = $apidata['data_list'];
			$script_data['data_list'] = $apidata['data_list'];
			$data['content_view'] =  $this->load->view($this->view_path . "/preview", $data, true);
			$data['script'] =  $this->load->view($this->script_path . "/preview_script", $script_data, true);
			$data['style'] =  $this->load->view($this->style_path . "preview_style", '', true);
			$this->template->user_template($data);
		} else {
			redirect(base_url() . 'error404');
		}
	}

	public function preview()
	{
		User::check_permission($this->module_name . '/preview');
		$data = array();
		$id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : redirect(base_url() . 'error404');
		$type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : redirect(base_url() . 'error404');
		$apidata = $this->curl->execute($this->module_name . "/" . $id, "GET");
		if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
			$data['title'] = "Preview | Service Templates";
			$data['data_list'] = $apidata['data_list'];
			$script_data['data_list'] = $apidata['data_list'];
			$data['content_view'] =  $this->load->view($this->view_path . $type . "/preview", $data, true);
			$data['script'] =  $this->load->view($this->script_path . $type . "/preview_script", $script_data, true);
			// print_r($this->script_path.$type."/preview_script");
			// exit();
			$data['style'] =  $this->load->view($this->style_path . "preview_style", '', true);
			$this->template->user_template($data);
		} else {
			redirect(base_url() . 'error404');
		}
	}
}
