<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excelimport extends CI_Controller{
    function __construct(){
        parent::__construct();
        User::check_session();
        $this->load->library('../controllers/template');
        //$this->load->library('My_upload');
        $this->load->library('upload');
        $this->load->helper('security');
        $this->admin->nocache(); 
        $this->userId=User::get_userId();
	}


    function get_import(){
        $module=$this->input->post('module');
        User::check_permission($module.'/import');
        $data=array();
        if(!empty($module)){
            $data['module']=$module;
            $str =  $this->load->view("users/utils/import_view", $data, true);
        }else{
            $str='Unable to initialize import, module name not found!';          
        }       
        $value=array('message'=>$str,'status'=>'success');
        echo json_encode($value);
    } 

    function import_datas(){
        // print_r("HI");exit();
        $return_data='';
        $input=$this->input->post();
        $module=$input['module'];
        $data['created_by']=$this->userId;
        $file_res = upload_files('files','xlsx|xls',$module.'_import','','uploads/excel_import/');
        if($file_res['error_count']>0){
            $value=array('message'=>$file_res['message'],'status'=>'fail');
        }else if($file_res[0]['status']=='success'){
            $data['file_path']=$file_res[0]['real_path'].$file_res[0]['file_name'];
            $data['overwrite']=isset($input['overwrite']) ? $input['overwrite'] : 'no';
            $data=array_merge($data,$input);
            $apidata=$this->curl->execute($module."/import","POST",$data);
            if(!empty($apidata['data_list'])){
                $return_data=$apidata['data_list'];
            }
            $value=array('message'=>$apidata['message'],'status'=>$apidata['status'],'datas'=>$return_data);
        }        
        echo json_encode($value);
    }

}	