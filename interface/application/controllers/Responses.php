<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Responses extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/responses/";
		$this->script_path = $this->view_path . "script/";
		$this->style_path = $this->view_path . "style/";
		$this->module_name = "responses";
		// $this->module_name="service_templates";
		$this->main_key = "name";
		$this->userId = User::get_userId();
	}

	public function index()
	{
		// User::check_permission($this->module_name);
		$data['title'] = "Responses";
		$data['filter_view'] =  $this->load->view($this->view_path . "filter_view", $data, true);
		$data['content_view'] =  $this->load->view($this->view_path . "main_view", $data, true);
		$data['script'] =  $this->load->view($this->script_path . "script", '', true);
		$data['style'] =  $this->load->view($this->style_path . "style", '', true);
		$this->template->user_template($data);
	}

	function view()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if (empty($id)) {
			redirect(base_url() . 'error404');
		}
		User::check_permission('responses/view');
		$data = array();
		$filterData['candidate_form_lists-candidate_id'] = $id;
		$data['campaign_data'] = array();
		$data['candidate_id'] = $id;
		$responses = $this->curl->execute("responses/responses", "GET", $filterData, 'filter');
		if ($responses['status'] == 'success' && !empty($responses['data_list'])) {
			$data['responses'] = $responses['data_list'];
			$campaign_id = $responses['data_list'][0]['campaign_id'];
			// Campaign Data
			$campaign_data = $this->curl->execute('campaigns/'.$campaign_id, 'GET');
			if(!empty($campaign_data['status']=='success') && !empty($campaign_data['data_list'])){
				$data['campaign_data'] = $campaign_data['data_list'];
			}
			// Campaign Data
			$filter_data['candidate_id'] = $id;
			$apidata = $this->curl->execute("responses/response_uploads", "GET", $filter_data, 'filter');
			$data['uploads_data'] = $apidata['data_list'];
			$data['title'] = "View | Responses";
			$data['content_view'] =  $this->load->view($this->view_path . "details_view", $data, true);
			$data['script'] =  $this->load->view($this->script_path . "details_view_script", '', true);
			$data['style'] =  $this->load->view($this->style_path . "details_view_style", '', true);
			$this->template->user_template($data);
		} else {
			redirect(base_url() . 'error404');
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
			$message = $apidata['message'];
			$status = $apidata['status'];
		}
		$value = array('status' => $status, 'message' => $message);
		echo json_encode($value);
		exit();
	}
}
