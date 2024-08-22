<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/dashboard/";
		$this->script_path = $this->view_path . "script/";
		$this->style_path = $this->view_path . "style/";
	}

	public function index()
	{
		$data['title'] = "Dashboard";
		$uid = User::get_userId();
		$filterData['forms-created_by'] = $uid;
		$data['total_templates'] = '';
		$data['campaigns'] = '';
		$apidata = $this->curl->execute('formbuilder', 'GET', $filterData, 'filter');
		if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
			$total_templates = $apidata['pagination_data']['total_rows'];
			$data['total_templates'] = $total_templates;
		}
		$campaigns = $this->curl->execute('campaigns', 'GET', array('campaigns-created_by' => $uid), 'filter');
		if ($campaigns['status'] == 'success' && !empty($campaigns['data_list'])) {
			$total_campaigns = $campaigns['pagination_data']['total_rows'];
			$data['campaigns'] = $total_campaigns;
		}
		$responses = $this->curl->execute('responses', 'GET', array('perpage'=>1000));
		$pending = 0;
		$submitted = 0;
		if($responses['status']=='success' && !empty($responses['data_list'])){
			$total_responses = $responses['data_list'];
			foreach($total_responses as $response){
				if($response['status']==76){
					$submitted++;
				}else{
					$pending++;
				}
			}
		}
		$data['pending'] = $pending;
		$data['submitted'] = $submitted;
		$data['content_view'] =  $this->load->view($this->view_path . "dashboard_view", $data, true);
		$this->template->user_template($data);
	}
}
