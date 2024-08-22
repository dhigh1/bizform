<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Campaigns extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/campaigns/";
		$this->script_path = $this->view_path . "script/";
		$this->style_path = $this->view_path . "style/";
		$this->module_name = "campaigns";
		// $this->module_name="service_templates";
		$this->main_key = "name";
		$this->userId = User::get_userId();
	}
	public function index(){
		// User::check_permission($this->module_name);
		$data['title'] = "Form Builder";
		$data['forms'] = $this->curl->execute('formbuilder', 'GET');
		$data['filter_view'] = $this->load->view($this->view_path . "filter_view", $data, true);
		$data['content_view'] = $this->load->view($this->view_path . "main_view", $data, true);
		$data['script'] = $this->load->view($this->script_path . "script", '', true);
		$data['style'] = $this->load->view($this->style_path . "style", '', true);
		$this->template->user_template($data);
	}
	
	public function view()
	{
		$id = $this->input->get('id');
		if (empty($id)) {
			redirect(base_url() . 'error404');
		}
		User::check_permission($this->module_name . '/view');
		$data = array();
		$data['url'] = '';
		$total_opened_candidates = 0;
		$total_completed_links = 0;
		$total_pending_links = 0;
	
		$get_analytics = $this->curl->execute("bizform_candidates/analytics/" . $id, "GET");
	
		if ($get_analytics['status'] == 'success' && !empty($get_analytics['data_list'])) {
			$total_opened_candidates = $get_analytics['data_list']['total_opened_links'];
			$total_completed_links = $get_analytics['data_list']['total_completed_links'];
			$total_pending_links = $get_analytics['data_list']['total_pending_links'];
		}
	
		$campaigns = $this->curl->execute("campaigns/" . $id, "GET");
	
		if ($campaigns['status'] == 'success' && !empty($campaigns['data_list'])) {
			$campaign = $campaigns['data_list'];
			$apidata = $this->curl->execute('campaigns/campaign_list/' . $id, 'GET', 'filter');
			$data['ids'] = !empty($apidata['status']) && !empty($apidata['data_list']) ? $apidata['data_list'] : '';
			$data['url'] = base_url() . 'forms?campaign=' . $campaign['url'];
			$data['campaign'] = $campaign;
	
			$filter['bizform_candidates-campaign_id'] = $id;
			$data['responses'] = '';
			$data['pending_responses'] = array();
			$pending_responses = $this->curl->execute('responses', 'GET', array('bizform_candidates-campaign_id' => $id, 'bizform_candidates-status' => 75, 'perpage'=>10000), 'filter');
	
			if ($pending_responses['status'] == 'success' && !empty($pending_responses['data_list'])) {
				$data['pending_responses'] = $pending_responses;
			}
	
			$data['cancelled_responses'] = array();
			$cancelled_responses = $this->curl->execute('responses', 'GET', array('bizform_candidates-campaign_id' => $id, 'bizform_candidates-status' => 82, 'perpage'=>10000));
	
			if ($cancelled_responses['status'] == 'success' && !empty($cancelled_responses['data_list'])) {
				$data['cancelled_responses'] = $cancelled_responses['data_list'];
			}
	
			$completed_responses = $this->curl->execute('responses', 'GET', array('bizform_candidates-campaign_id' => $id, 'bizform_candidates-status' => 76, 'perpage'=>10000), 'filter');
	
			if ($completed_responses['status'] == 'success' && !empty($completed_responses['data_list'])) {
				$data['completed_responses'] = $completed_responses;
			}
	
			$data['total_candidates'] = $total_opened_candidates;
			$data['total_completed_candidates'] = $total_completed_links;
			$data['total_pending_candidates'] = $total_pending_links;
			$data['title'] = "Template Preview | " . $this->module_name;
			$data['content_view'] = $this->load->view($this->view_path . "detail_view", $data, true);
			$data['script'] = $this->load->view($this->script_path . "campaign_detail/script", '', true);
			$data['style'] = $this->load->view($this->style_path . "style", '', true);
			$this->template->user_template($data);
		} else {
			redirect(base_url() . 'error404');
		}
	}
	

	public function add()
	{
		User::check_permission($this->module_name.'/add');
		$data = array();
		// $forms = $this->db->
		$forms = $this->curl->execute("formbuilder", "GET", array('perpage'=>1000, 'forms-status'=>77));
		if($forms['status']=='success' && !empty($forms['data_list'])){
			$data['forms'] = $forms['data_list'];
			$str =  $this->load->view($this->view_path . "add_view", $data, true);
			$value = array('message' => $str, 'status' => 'success');
		}else{
			$value = array('status'=>'fail', 'message'=>'No Forms Found to add the campaign. Please add the forms first');
		}
		echo json_encode($value);
		return;
	}
	
	public function edit()
	{
		$input = $this->input->post();
		$id = $input['id'];
		$data = array();
		$data['campaign_data'] = '';
		$data['id'] = $id;
		$apidata = $this->curl->execute('campaigns/' . $id, 'GET');
		if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
			$data['campaign_data'] = $apidata['data_list'];
			$forms = $this->curl->execute("formbuilder", "GET", array('perpage'=>1000));
			if($forms['status']!='success'){
				echo json_encode(array('message'=>'Something Went Wrong, No Forms Found', 'status'=>'fail'));
				return;
			}
			$data['forms'] = $forms['data_list'];
			$selected_form_list = $this->curl->execute('campaigns/campaign_list/'.$input['id'], 'GET');
			if($selected_form_list['status']=='success' && !empty($selected_form_list['data_list'])){
				$data['selected_forms'] = $selected_form_list['data_list'];
			}
		}
		$str =  $this->load->view($this->view_path . "edit_view", $data, true);
		$value = array('message' => $str, 'status' => 'success');
		echo json_encode($value);
	}

	public function getSelectedForm(){
		$id = $this->input->post('id');
		$selected_forms = $this->curl->execute('campaigns/campaign_list/'.$id, 'GET');
		if($selected_forms['status']=='success' && !empty($selected_forms['data_list'])){
			$forms = $this->curl->execute('formbuilder', 'GET', array('perpage'=>1000));
			if($forms['status']=='success' && !empty($forms['data_list'])){
				echo json_encode(array('status'=>'success', 'message'=>'Data Fetched Successfully', 'data'=>array('selected_forms'=>$selected_forms['data_list'], 'forms'=>$forms['data_list'])));
				return;
			}else{
				echo json_encode(array('status'=>'fail', 'message'=>'Forms could not be found'));
				return;
			}
		}else{
			echo json_encode(array('status'=>'fail', 'message'=>'No Data Found'));
			return;
		}
	}
	
	public function delete_response()
	{
		$id = $this->input->post('id');

		$message = '';
		$status = 'fail';
		$value = array();
		if (empty($id)) {
			$value['message'] = 'Undefined Response Row';
		} else {
			$apidata = $this->curl->execute('responses/' . $id, 'DELETE');
			// print_r($apidata);exit();
			$message = $apidata['message'];
			$status = $apidata['status'];
			Activity::module_log('responses_delete','user',$apidata['data_list']);
		}
		$value = array('status' => $status, 'message' => $message);
		echo json_encode($value);
		exit();
	}

	public function save_data()
	{
		$data = $this->input->post();
		$campaign_id = $this->input->post('campaign_id');
		if(!empty($campaign_id)){
			unset($data['campaign_id']);
		}
		$message = 'Something went wrong';
		$url = '';
		$status = 'fail';
		$forms = !empty($data['forms'])?$data['forms']:'';
		if(empty($forms)){
			echo json_encode(array('status'=>'fail', 'message'=>'Please Select Forms to Create'));
			return;
		}
		if(!empty($campaign_id)){
			$data['updated_by'] = $this->userId;
			$apidata = $this->curl->execute('campaigns/'.$campaign_id, 'PUT', $data);
			if ($apidata['status'] == 'success') {
				Activity::module_log($this->module_name.'_update','user',$apidata['data_list']);
				$status = 'success';
				$message = $apidata['message'];
			}else{
				$message = $apidata['message'];
			}
		}else{
			if (!empty($data['url'])) {
				$data['url'] = create_slug($data['url']);
			} else {
				$data['url'] = create_slug($data['name']);
			} 
			$filterData['url'] = $data['url'];
			$check_url = $this->curl->execute('campaigns', 'GET', $filterData, 'filter');
			if ($check_url['status'] == 'success' && !empty($check_url['data_list'])) {
				$message = 'Campaign URL is not valid, Please enter another URL';
			} else {
				$data['created_by'] = $this->userId;
				$apidata = $this->curl->execute('campaigns', 'POST', $data);
				if ($apidata['status'] == 'success') {
					$status = 'success';
					$message = $apidata['message'];
					Activity::module_log($this->module_name.'_create','user',$apidata['data_list']);
					$url = base_url() . 'campaigns/view/?id=' . $apidata['data_list']['id'];
				}else{
					$message = $apidata['message'];
				}
			}
		}
		$value = array('status' => $status, 'url' => $url, 'message' => $message);
		echo json_encode($value);
		return;


	}

	public function edit_data()
	{
		$message = 'Something went wrong';
		$url = '';
		$status = 'fail';
		$data = $this->input->post();
		$data['updated_by'] = $this->userId;
		$id = $data['id'];
		if (!empty($data['url'])) {
			$data['url'] = create_slug($data['url']);
		} else {
			$data['url'] = create_slug($data['name']);
		}
		$filterData['campaigns-url'] = $data['url'];
		$check_url = $this->curl->execute('campaigns', 'GET', $filterData, 'filter');
		if ($check_url['status'] == 'success' && !empty($check_url['data_list'])) {
			if ($id == $check_url['data_list'][0]['id']) {
				$update = $this->curl->execute('campaigns/' . $id, 'PUT', $data);
				if ($update['status'] == 'success') {
					$value = array('status' => 'success', 'message' => $update['message'], 'url' => $update['data_list'][0]['url']);

				} else {
					$value = array('status' => 'fail', 'message' => $update['message'], 'url' => '');
				}
			} else {
				$value = array('status' => 'fail', 'message' => 'Invalid URL, Try another URL', 'url' => '');
			}
		} else {
			$value = array('status' => 'fail', 'message' => $check_url['message'], 'url' => '');
		}
		echo json_encode($value);
		exit();
	}

	public function set_templates()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if (empty($id)) {
			redirect(base_url() . 'error404');
		}
		$data = array();
		$data['url'] = '';
		$campaign_data = $this->curl->execute("campaigns/".$id, "GET");
		$forms = $this->curl->execute("formbuilder", "GET", array('perpage'=>1000));
		if ($forms['status'] == 'success' && !empty($forms['data_list'])) {
			$forms = $forms['data_list'];
			$data['forms'] = $forms;
			$data['campaign_data'] = $campaign_data;
			$data['title'] = "Template Preview | " . $this->module_name;
			$data['content_view'] =  $this->load->view($this->view_path . "select_templates", $data, true);
			$this->template->user_template($data);
		} else {
			redirect(base_url() . 'error404');
		}
	}

	public function get_set_templates(){
		$forms = $this->curl->execute("formbuilder", "GET", array('perpage'=>1000));
		$status = 'fail';
		$forms = array();
		$message = 'Something went wrong, please try again';
		if ($forms['status'] == 'success' && !empty($forms['data_list'])) {
			$status = 'success';
			$message = 'Data Fetched Successfully';
			$forms = $forms['data_list'];
		}
		echo json_encode(array('status'=>$status, 'message'=>$message, 'data'=>$forms));
		return;
	}

	public function save_campaign_templates()
	{
		$message = '';
		$status = 'fail';
		$url = '';
		$data = array();
		$data['campaign_id'] = $this->input->post('campaign_id');
		$data['ids'] = json_encode($this->input->post('ids'));
		$data['created_by'] = $this->userId;
		$data['created_at'] = cur_datetime();
		$data['status'] = 1;
		$apidata = $this->curl->execute('campaigns/multi_forms', 'POST', $data);
		if ($apidata['status'] == 'success') {
			$message = $apidata['message'];
			$status = $apidata['status'];
			$url = base_url() . 'campaigns/view?id=' . $data['campaign_id'];
		} else {
			$message = $apidata['message'];
		}
		$value = array('status' => $status, 'message' => $message, 'url' => $url);
		echo json_encode($value);
	}
}
