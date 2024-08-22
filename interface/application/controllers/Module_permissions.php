<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Module_permissions extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/module_permissions/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="module_permissions";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
		
    public function index() {
    	User::check_permission($this->module_name);	
		$data['title']="Module Permissions";
		$uid=User::get_userId();
       	// $data['filter_view'] =  $this->load->view($this->view_path."filter_view", $data, true);
       	$data['content_view'] =  $this->load->view($this->view_path."modules_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
	    $data['style'] =  $this->load->view($this->style_path."styles",'' , true);
       	$this->template->user_template($data);
    }

    function add(){
    	User::check_permission($this->module_name.'/add');	
    	$parent=$this->input->post('id');
    	$modules_id=$this->input->post('mid');
    	if(empty($modules_id)){
    		$value=array('message'=>'Please refresh the page and try again!','status'=>'success');
    		echo json_encode($value);
    		exit;
    	}
    	$data=array(
    		'modules_id'=>$modules_id
    	);
    	if(!empty($parent)){
    		$apidata=$this->curl->execute($this->module_name."/".$parent,"GET");
    		$data['parent_data']=$apidata['data_list'];
    	}
		$apidata=$this->curl->execute("modules/".$modules_id,"GET");
		$data['module_data']=$apidata['data_list'];
    	$str =  $this->load->view($this->view_path."add_view", $data, true);
    	$value=array('message'=>$str,'status'=>'success');
    	echo json_encode($value);
    }

    function edit(){
    	User::check_permission($this->module_name.'/edit');	
    	$id=$this->input->post('id');
    	$modules_id=$this->input->post('mid');
    	if(empty($modules_id) || empty($id)){
    		$value=array('message'=>'Please refresh the page and try again!','status'=>'success');
    		echo json_encode($value);
    		exit;
    	}
    	$data=array(
    		'modules_id'=>$modules_id,
    		'id'=>$id
    	);
    	if(!empty($parent)){
    		$apidata=$this->curl->execute($this->module_name."/".$parent,"GET");
    		$data['parent_data']=$apidata['data_list'];
    	}
		$apidata=$this->curl->execute("modules/".$modules_id,"GET");
		$data['module_data']=$apidata['data_list'];

    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
		$data['data_list']=$apidata['data_list'];
    	$str =  $this->load->view($this->view_path."edit_view", $data, true);
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
    		$message=ucwords($apidata['data_list'][$this->main_key])."-".$apidata['message'];
    		Activity::module_log($activity_name,'user',$apidata['data_list']);
    	}
    	$value=array('message'=>$message,'status'=>$apidata['status']);
    	echo json_encode($value);
    }
   
}