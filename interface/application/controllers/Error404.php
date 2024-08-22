<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class error404 extends CI_Controller {

	function __construct(){
		parent::__construct();
        User::check_session();
        $this->load->library('../controllers/template');
        $this->view_path = "pages/";
        $this->script_path = $this->view_path."script/";
        $this->style_path = $this->view_path."style/";
	}

    function index(){
        $data['title']="Page Not Found";
        $data['content_view'] =  $this->load->view($this->view_path."error404_view", $data, true);
        $this->template->default_template($data);
    }

}
