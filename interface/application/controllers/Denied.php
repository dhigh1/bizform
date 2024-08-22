<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Denied extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("common_model","",true);
	}

	function index(){
		$data=array();
        $data = $this->admin->common_files();
        $data['title']="Access Denied";
		$this->load->view("access_denied_view",$data);
	}
}
