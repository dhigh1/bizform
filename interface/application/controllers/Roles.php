<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/roles/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="roles";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
	
    public function index() {
    	User::check_permission($this->module_name);
		$data['title']="Roles";
       	$data['filter_view'] =  $this->load->view($this->view_path."filter_view", $data, true);
       	$data['content_view'] =  $this->load->view($this->view_path."main_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
	    $data['style'] =  $this->load->view($this->style_path."styles",'' , true);
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
	    			$str =  $this->load->view($this->view_path."edit_view", $data, true);
    			}else{
    				$str='Role not found...';
    			}
    		}else{
    			$str='Role not found...';
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
    	//print_r($apidata);
    	if($apidata['status']=='success'){
    		$message=$apidata['data_list'][$this->main_key]."-".$apidata['message'];
    		Activity::module_log($activity_name,'user',$apidata['data_list']);
    	}
    	$value=array('message'=>$message,'status'=>$apidata['status']);
    	echo json_encode($value);
    }

    function manage_permission(){
    	User::check_permission($this->module_name.'/manage_permission');
		$input=$this->input->post();
		if(!empty($input['id'])){
			$data['roles_id']=$input['id'];
			$role_data=$this->curl->execute("roles/".$input['id'],"GET");
			if($role_data['status']=='success' && !empty($role_data['data_list'])){
				$modules_data=$this->curl->execute("modules","GET",array('perpage'=>100,'sortby'=>'modules-name','orderby'=>'ASC'));
				$submodules_data=$this->curl->execute("module_permissions","GET");
				$permissions=$this->curl->execute("module_permissions/set_permission/".$input['id'],"GET");
				$data['role']=$role_data['data_list'];
				$data['modules']=$modules_data['data_list'];
				$data['modules']=$modules_data['data_list'];
				$data['submodules']=$submodules_data['data_list'];
				$data['permissions']=$permissions['data_list'];
		       	$str =  $this->load->view($this->view_path."role_permissions_view", $data, true);
		    }else{
		    	$str="Role data not found! Please refresh the page & try again.";
		    }
       	}else{
       		$str="Role id is invalid! Please reload the page.";
       	}
    	$value=array('message'=>$str,'status'=>'success');
    	echo json_encode($value);
    }

    function save_permissions()
    {
		$data=$this->input->post();
		$data['created_by']=$this->userId;
		$apidata=$this->curl->execute("module_permissions/save_permission/".$data['roles_id'],"PUT",$data);
		$message=$apidata['message'];
		if($apidata['status']=='success'){
    		$message='Updated the permissions for the role '.$apidata['data_list'][$this->main_key].' of '.$apidata['data_list']['departments_name'].' department';
    		$activity_name=$this->module_name.'_permission_update';
    		Activity::module_log($activity_name,'user',$apidata['data_list']);
    	}
    	$value=array('message'=>$message,'status'=>$apidata['status']);
    	echo json_encode($value);
    }


}