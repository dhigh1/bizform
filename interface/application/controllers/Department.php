<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/department/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="department";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
	
    public function index() {
    	User::check_permission($this->module_name);
		$data['title']="Organization Departments";
		if(isset($_GET['branch_id']) && !empty($_GET['branch_id'])){
			$branch_id=$_GET['branch_id'];
			$data['branch_data']=$this->curl->execute("organization_branches/$branch_id","GET");
			$data['depts_data']=$this->curl->execute($this->module_name,"GET",array('branch_id'=>$branch_id));
	       	$data['deptTbl'] =  $this->load->view($this->view_path."tbl_view", $data, true);
	       	$data['content_view'] =  $this->load->view($this->view_path."main_view", $data, true);
		    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
		    $data['style'] =  $this->load->view($this->style_path."style",'' , true);
	       	$this->template->user_template($data);
       }else{
       		redirect(base_url().'error404');
       }
    }

    function add(){
    	User::check_permission($this->module_name.'/add');	
    	$id=$this->input->post('id');
    	$mid=$this->input->post('mid');
    	$data['branch_id']=$mid;
    	if(empty($mid)){    	
	    	$value=array('message'=>'Unable to get branch details, please refresh the page!','status'=>'success');
	    	echo json_encode($value);
	    	exit;
    	}
    	if(empty($id)){
    		$str =  $this->load->view($this->view_path."add_view", $data, true);
    	}else{
	    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
    		if($apidata['status']=='success'){
    			$data['data_list']=$apidata['data_list'];
    			$str =  $this->load->view($this->view_path."add_view", $data, true);	
    		}else{
    			$str='Parent department not found...';
    		}    		
    	}    	
    	$value=array('message'=>$str,'status'=>'success');
    	echo json_encode($value);
    }

    function edit(){
    	User::check_permission($this->module_name.'/edit');	
    	$id=$this->input->post('id');
    	$mid=$this->input->post('mid');
    	$data['branch_id']=$mid;
    	if(empty($mid)){    		
	    	$value=array('message'=>'Unable to get branch details, please refresh the page!','status'=>'success');
	    	echo json_encode($value);
	    	exit;
    	}
    	if(empty($id)){
    		$str =  $this->load->view($this->view_path."add_view", $data, true);
    	}else{
	    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
    		if($apidata['status']=='success'){
    			$data['data_list']=$apidata['data_list'];
    			$str =  $this->load->view($this->view_path."edit_view", $data, true);	
    		}else{
    			$str='No record found...';
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
    		//print_r($apidata);
    		$message=$apidata['data_list'][$this->main_key]."-".$apidata['message'];
    		Activity::module_log($activity_name,'user',$apidata['data_list']);
    	}
    	$value=array('message'=>$message,'status'=>$apidata['status']);
    	echo json_encode($value);
    }    

}