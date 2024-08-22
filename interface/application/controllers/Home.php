<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
        if(User::is_logged()){
            redirect(base_url().'dashboard');
        }
        $this->load->library('../controllers/template');
        $this->view_path = "pages/";
        $this->script_path = $this->view_path."script/";
        $this->style_path = $this->view_path."style/";
	}

    function index(){
        $data['title']="Home";
        $data['content_view'] =  $this->load->view($this->view_path."home_view", $data, true);
        $this->template->default_template($data);

    }

}