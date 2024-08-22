<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/organization/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="organization";
		$this->main_key="name";
		$this->userId=User::get_userId();
	}
	
    public function index() {
    	User::check_permission($this->module_name);
		$data['title']="Organization Profile";
		$data['apidata']=$this->curl->execute($this->module_name."/1","GET");
       	$data['content_view'] =  $this->load->view($this->view_path."profile_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."organization",'' , true);
       	$this->template->user_template($data);
    }

    function save_data()
    {
    	User::check_permission($this->module_name.'/save_data');
    	$id=$this->input->post('id');
    	$data=array(
    		'name'=>$this->input->post('name'),
    		'tagline'=>$this->input->post('tagline'),
    		'address'=>$this->input->post('address'),
    		'updated_by'=>$this->userId
    	);
    	//print_r($sm_links);
		$apidata=$this->curl->execute($this->module_name."/1","PUT",$data);

		//print_r($apidata);
		if($apidata['status']=='success'){
			Activity::module_log($this->module_name.'_update','user',$apidata['data_list']);
		}
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status']);
    	echo json_encode($value);
    }

    function save_picture(){
    	User::check_permission($this->module_name.'/save_picture');
    	$file_res = upload_files('files','png|jpg|jpeg','organization_logo');
        if($file_res['error_count']>0){
            $value=array('message'=>$file_res['message'],'status'=>'fail');
        }else if($file_res[0]['status']=='success'){
        	$data=array(
        		'logo'=>$file_res[0]['uploads_id'],
        		'updated_by'=>$this->userId
        	);
			$apidata=$this->curl->execute($this->module_name."/1","PUT",$data);
			if($apidata['status']=='success'){
				$logData=array(
					'action'=>'update',
		        	'description'=>'updated the logo of an organization - '.$apidata['data_list']['name'],
		        	'data_id'=>1,
		        	'module'=>$this->module_name
		        );
		        User::activity($logData);
			}
            $value=array('message'=>$apidata['message'],'status'=>$apidata['status']);
        }else{
			$value = array('message'=>"Something went wrong", 'status'=>'fail');
		} 
        echo json_encode($value);
    }


	 
    function save_favicon(){
    	User::check_permission($this->module_name.'/save_picture');
    	$file_res = upload_files('files','png|jpg|jpeg','favicon');
		// print_r($file_res);exit();
        if($file_res['error_count']>0){
            $value=array('message'=>$file_res['message'],'status'=>'fail');
        }else if($file_res[0]['status']=='success'){
        	$data=array(
        		'favicon'=>$file_res[0]['uploads_id'],
        		'updated_by'=>$this->userId
        	);
			$apidata=$this->curl->execute($this->module_name."/1","PUT",$data);
			if($apidata['status']=='success'){
				$logData=array(
					'action'=>'update',
		        	'description'=>'updated the logo of an organization - '.$apidata['data_list']['name'],
		        	'data_id'=>1,
		        	'module'=>$this->module_name
		        );
		        User::activity($logData);
			}
            $value=array('message'=>$apidata['message'],'status'=>$apidata['status']);
        }        
        echo json_encode($value);
    }


  
}
