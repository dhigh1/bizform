<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Workflow extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/workflow/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="workflow";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
	
    public function index(){
    	User::check_permission($this->module_name);
		$data['title']="Workflow";
		$data['filter_view'] =  $this->load->view($this->view_path."filter_view", $data, true);
       	$data['content_view'] =  $this->load->view($this->view_path."main_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
	    $data['style'] =  $this->load->view($this->style_path."style",'' , true);
       	$this->template->user_template($data);
    }

    function add()
    {
    	User::check_permission($this->module_name.'/add');
    	$data=array();
    	$checklists=$this->curl->execute("checklists","GET");
    	$data['checklists']=$checklists['data_list'];
    	$workflow=$this->curl->execute("workflow","GET",array('sortby'=>'workflow.orders','orderby'=>'ASC','perpage'=>100));
    	$data['workflows']=$workflow['data_list'];
    	$message =  $this->load->view($this->view_path."add_view", $data, true);
    	$value=array('status'=>'success','message'=>$message);
    	echo json_encode($value);
    }

    function edit()
    {
    	User::check_permission($this->module_name.'/edit');
    	$id=$this->input->post('id');
    	$data=array();
    	$checklists=$this->curl->execute("checklists","GET");
    	$data['checklists']=$checklists['data_list'];
    	$workflow=$this->curl->execute("workflow","GET",array('sortby'=>'workflow.orders','orderby'=>'ASC','perpage'=>100));
    	$data['workflows']=$workflow['data_list'];
    	$apidata=$this->curl->execute("workflow/".$id,"GET");
    	$data['data_list']=$apidata['data_list'];
    	$message =  $this->load->view($this->view_path."edit_view", $data, true);
    	$value=array('status'=>'success','message'=>$message);
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
    	//print_r($apidata);
    	if($apidata['status']=='success'){
    		$message=ucwords($apidata['data_list'][$this->main_key])."-".$apidata['message'];
    		Activity::module_log($activity_name,'user',$apidata['data_list']);
    	}
    	$value=array('message'=>$message,'status'=>$apidata['status']);
    	echo json_encode($value);
    }


}