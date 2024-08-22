<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		//$this->load->library('../controllers/utils');
		$this->view_path = "users/users/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="users";
		$this->main_key="login_id";
		$this->userId=User::get_userId();
	}
	
    public function index() {
    	User::check_permission($this->module_name);
		$data['title']="Users";
       	$data['filter_view'] =  $this->load->view($this->view_path."filter_view", $data, true);
       	$data['content_view'] =  $this->load->view($this->view_path."main_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
	    $data['style'] =  $this->load->view($this->style_path."style",'' , true);
       	$this->template->user_template($data);
    }

    function add(){
    	$id=$this->input->post('id');
    	$data=array();
	    $data['branch_data']=$this->curl->execute("organization_branches","GET");
    	if(empty($id)){
    		User::check_permission($this->module_name.'/add');
    		$str =  $this->load->view($this->view_path."add_view", $data, true);
    	}else{
    		User::check_permission($this->module_name.'/edit');
	    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
    		if($apidata['status']=='success'){
    			$data['data_list']=$apidata['data_list'];
    			if(!empty($data['data_list'])){
    				$data['depts_data']=$this->curl->execute("department","GET",array('branch_id'=>$data['data_list']['organization_branches_id']));
    				$data['roles_data']=$this->curl->execute("roles","GET",array('departments_id'=>$data['data_list']['departments_id']));
	    			$str =  $this->load->view($this->view_path."edit_view", $data, true);
    			}else{
    				$str='User not found...';
    			}
    		}else{
    			$str='User not found...';
    		}    		
    	}    	
    	$value=array('message'=>$str,'status'=>'success');
    	echo json_encode($value);
    }

    function save_data()
    {
    	$id=$this->input->post('id');
    	$data=$this->input->post();
    	
    	if(isset($_POST['dob'])){
    		$data['dob']=custom_date('Y-m-d',$data['dob']);
    	}
    	if(isset($_POST['status'])){
    		$data['status']=$data['status'];
    	}else{
    		$data['status']=7;
    	}

    	if(!empty($id)){
    		$data['updated_by']=$this->userId;
			$apidata=$this->curl->execute($this->module_name."/".$id,"PUT",$data);
			$activity_name=$this->module_name.'_update';
    	}else{
    		unset($data['id']);
    		$data['created_by']=$this->userId;
    		$data['create_type']=9;
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