<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_reports extends CI_Controller {

	function __construct(){
		parent::__construct();
		//User::check_session();
	}

	function do_upload(){
		$input=$this->input->post();
		//print_r($input);
		if(!empty($input) && !empty($input['file_url']) && !empty($input['file_folder'])  && !empty($input['file_name'])){

			if($input['download_type']=='base64'){
				$file_res=download_base64_file($input['file_url'],$input['file_folder'],$input['file_name']);
			}else if($input['download_type']=='url'){
				$file_res=download_url_file($input['file_url'],$input['file_folder'],$input['file_name']);
			}else{
				$result = array('status'=>'fail','message'=>'Unknown download type.');
				echo json_encode($result);
				exit();
			}
			if($file_res['status']=='success' && !empty($file_res['file_url'])){
				$result=array('status'=>'success','message'=>'Downloaded the report to a file folder.','file_url'=>$file_res['file_url']);
			}
			//print_r($file_res);
		}else{
			$result = array('status'=>'fail','message'=>'File data fields are missing.');
		}
		echo json_encode($result);
	}


}