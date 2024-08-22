<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modules extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/modules/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="modules";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
		
    public function index() {
    	User::check_permission($this->module_name);
		$data['title']="Modules";
		$uid=User::get_userId();
       	$data['filter_view'] =  $this->load->view($this->view_path."filter_view", $data, true);
       	$data['content_view'] =  $this->load->view($this->view_path."modules_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
       	$this->template->user_template($data);
    }

    function add(){
    	$id=$this->input->post('id');
    	$data=array();
    	if(empty($id)){
    		User::check_permission($this->module_name.'/add');
    		$str =  $this->load->view($this->view_path."add_view", $data, true);
    	}else{
    		User::check_permission($this->module_name.'/edit');
	    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
    		if($apidata['status']=='success'){
    			$data['data_list']=$apidata['data_list'];
    			if(!empty($data['data_list'])){
	    			$str =  $this->load->view($this->view_path."edit_view", $data, true);
    			}else{
    				$str='Module not found...';
    			}
    		}else{
    			$str='Module not found...';
    		}    		
    	}    	
    	$value=array('message'=>$str,'status'=>'success');
    	echo json_encode($value);
    }
 
    function save_data()
    {
    	$id=$this->input->post('id');
    	$data=$this->input->post();

    	if(!empty($id)){
    		$data['updated_by']=$this->userId;
			$apidata=$this->curl->execute($this->module_name."/".$id,"PUT",$data);
			$activity_name=$this->module_name.'_update';
    	}else{
    		unset($data['id']);
    		$data['created_by']=$this->userId;
    		$apidata=$this->curl->execute($this->module_name,"POST",$data);
    		$activity_name=$this->module_name.'_create';
    	}
    	$message=$apidata['message'];
    	if($apidata['status']=='success'){
    		$message=$apidata['data_list'][$this->main_key]."-".$apidata['message'];
    		Activity::module_log($activity_name,'user',$apidata['data_list']);
    	}
    	$value=array('message'=>$message,'status'=>$apidata['status']);
    	echo json_encode($value);
    }
  
}