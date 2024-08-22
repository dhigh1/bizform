<?php
class Logout extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->admin->nocache();
	}
	
	function index(){

		$logData=array(
			'action'=>'logout',
        	'description'=>'logged out from the system',
        	'data_id'=>User::get_userId(),
        	'reference_id'=>User::get_userId(),
        	'reference_name'=>User::get_userName(),
        	'module'=>'session'
        );
        User::activity($logData);
		$this->session->sess_destroy();
		redirect(base_url().'login');
	}
}