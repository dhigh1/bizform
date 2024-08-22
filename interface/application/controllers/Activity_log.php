<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/activity_log/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="activity_log";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
	
    public function index(){
    	User::check_permission($this->module_name);
		$data['title']="Activity Log";
       	$data['filter_view'] =  $this->load->view($this->view_path."filter_view", $data, true);
       	$data['content_view'] =  $this->load->view($this->view_path."main_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
       	$this->template->user_template($data);
    }

}