<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_branches extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/organization_branches/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="organization_branches";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
	
    public function index() {
    	User::check_permission($this->module_name);
		$data['title']="Organization Branches";
       	$data['filter_view'] =  $this->load->view($this->view_path."filter_view", $data, true);
       	$data['content_view'] =  $this->load->view($this->view_path."main_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."script",'' , true);
       	$this->template->user_template($data);
    }

    function add(){
    	$id=$this->input->post('id');
    	$data['countries']=$this->curl->execute("country","GET");
    	if(empty($id)){
    		User::check_permission($this->module_name.'/add');
    		$str =  $this->load->view($this->view_path."add_view", $data, true);
    	}else{
    		User::check_permission($this->module_name.'/edit');
	    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
    		if($apidata['status']=='success'){
    			$data['data_list']=$apidata['data_list'];
    			//print_r($data['data_list']);
    			if(!empty($data['data_list']['countries_id'])){
    				$data['states']=$this->curl->execute("state","GET",array('country_id'=>$data['data_list']['countries_id']));
    			}
    			if(!empty($data['data_list']['states_id'])){
    				$data['cities']=$this->curl->execute("city","GET",array('state_id'=>$data['data_list']['states_id']));
    			}
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
    	$data['organization_id']=1;

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

    function view(){
    	User::check_permission($this->module_name.'/view');
    	$id=$this->input->post('id');
    	$apidata=$this->curl->execute($this->module_name."/".$id,"GET");
    	$str=$apidata['message'];
    	if($apidata['status']=='success' && !empty($apidata['data_list']))	{
    		$data['data_list']=$apidata['data_list'];
    		$str =  $this->load->view($this->view_path."details_view", $data, true);	
    	}
    	$value=array('message'=>$str,'status'=>'success');
    	echo json_encode($value);
    }


  
}
