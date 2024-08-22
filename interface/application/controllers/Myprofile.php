<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myprofile extends CI_Controller {

	function __construct(){
		parent::__construct();
		User::check_session();
		$this->load->library('../controllers/template');
		$this->view_path = "users/myprofile/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";

		$this->module_name="users";
		$this->main_key="login_id";
		$this->userId=User::get_userId();
	}
		
    public function index() {
    	User::check_permission('myprofile');
		$data['title']="My Profile";
		$apidata=$this->curl->execute($this->module_name."/".$this->userId,"GET");
		$data['data_list']=$apidata['data_list'];
       	$data['content_view'] =  $this->load->view($this->view_path."profile_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."profile",'' , true);
       	$this->template->user_template($data);
    }

    function save_data()
    {
    	$data=$this->input->post();
		$apidata=$this->curl->execute($this->module_name."/".$this->userId,"PUT",$data);
		if($apidata['status']=='success'){
			$logData=array(
				'action'=>'update',
	        	'description'=>'updated their profile details',
	        	'data_id'=>$this->userId,
	        	'module'=>'myprofile'
	        );
	        User::activity($logData);
		}
    	$value=array('message'=>$apidata['message'],'status'=>$apidata['status']);
    	echo json_encode($value);
    }

    function change_password() {
    	User::check_permission('myprofile');
		$data['title']="Change Password";
       	$data['content_view'] =  $this->load->view($this->view_path."password_view", $data, true);
	    $data['script'] =  $this->load->view($this->script_path."password",'' , true);
       	$this->template->user_template($data);
    }

    function save_password()
    {
    	$input=$this->input->post();
		$apidata=$this->curl->execute($this->module_name."/".$this->userId,"GET");
		$data_list=$apidata['data_list'];
		$check_pass = $this->Mydb->verifyHash($input['password'], $data_list['password']);
		if($check_pass){
			$data=array(
				'password'=>$input['new_password']
			);
			$apidata=$this->curl->execute($this->module_name."/".$this->userId,"PUT",$data);
			$message=$apidata['message'];
			if($apidata['status']=='success'){
				$logData=array(
					'action'=>'update',
		        	'description'=>'updated their account login password',
		        	'data_id'=>$this->userId,
		        	'module'=>'myprofile'
		        );
		        User::activity($logData);
		        $message='Your account password has been updated';
			}
	    	$value=array('message'=>$message,'status'=>$apidata['status']);
		}else{
			$value=array('message'=>'Current password is invalid!','status'=>'fail');
		}
    	echo json_encode($value);
    }

    function save_picture(){
    	$file_res = upload_files('files','png|jpg|jpeg','user_picture');
        if($file_res['error_count']>0){
            $value=array('message'=>$file_res['message'],'status'=>'fail');
        }else if($file_res[0]['status']=='success'){
        	$data=array(
        		'picture'=>$file_res[0]['uploads_id']
        	);
			$apidata=$this->curl->execute($this->module_name."/".$this->userId,"PUT",$data);
			$message=$apidata['message'];
			if($apidata['status']=='success'){
				$logData=array(
					'action'=>'update',
		        	'description'=>'updated their account profile picture',
		        	'data_id'=>$this->userId,
		        	'module'=>'myprofile'
		        );
		        User::activity($logData);
		        $message='Your profile picture has been updated';
			}

            $value=array('message'=>$message,'status'=>$apidata['status']);
        }        
        echo json_encode($value);
    }    


}