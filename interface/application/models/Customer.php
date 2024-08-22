<?php
class Customer extends CI_Model
{
    
    private $table_name='customer_branches_persons';
    private static $db;

    function __construct(){
        parent::__construct();
        self::$db = &get_instance()->db;
    }
    
    static function check_session()
    {
        $ci =& get_instance();
        $ci->load->library('session');
        if(Customer::get_userId()==null || Customer::is_logged()==null){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
                $value=array(
                    'session'=>'false',
                    'status'=>'fail',
                    'result'=>'fail',
                    'message'=>'Session timeout, please <a href="'.base_url().'customer/login">login</a> again!'
                );          
                echo json_encode($value);
                exit();
            }else{
                redirect(base_url().'customer/login');
            }
        }
        if(Customer::is_active()<=0){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
                $value=array(                    
                    'session'=>'false',
                    'status'=>'fail',
                    'result'=>'fail',
                    'message'=>'Your account is disabled, please contact administrator!'
                );          
                echo json_encode($value);
                exit();
            }else{
                redirect(base_url().'customer/logout');
            }
        }
        return;        
    }

    static function get_userId()
    {
        $ci =& get_instance();
        return $ci->session->userdata('personId');
    }

    static function get_customerId()
    {
        $ci =& get_instance();
        return $ci->session->userdata('customerId');
    }

    static function get_branchId()
    {
        $ci =& get_instance();
        return $ci->session->userdata('branchId');
    }

    static function get_userName()
    {
        $ci =& get_instance();
        return $ci->session->userdata('customerName');
    }

    static function is_active()
    {
        $ci =& get_instance();
        $id=Customer::get_userId();
        $apidata=$ci->curl->execute("customer_branches_persons/$id","GET");
        //print_r($apidata['data_list']);
        return $apidata['data_list']['login_enabled'];
    }

    static function is_logged()
    {
        $ci =& get_instance();
        $logged_in =  $ci->session->userdata('customerLogged');
        return $logged_in;        
    }

    static function get_ReferType()
    {   
        $id=26;
        return $id;
    }
    
    static function activity($data)
    {
        if(isset($data['reference_id'])){
            $data['reference_id']=$data['reference_id'];
        }else{
            $data['reference_id']=Customer::get_userId();
        }
        if(isset($data['reference_name'])){
            $data['reference_name']=$data['reference_name'];
        }else{
            $data['reference_name']=Customer::get_userName();
        }
        $data['action']=strtolower($data['action']);
        $data['module']=strtolower($data['module']);
        $data['ip_address']=get_ipaddress();
        $data['reference_type']=Customer::get_ReferType();
        $ci =& get_instance();
        $apidata=$ci->curl->execute("activity_log","POST",$data);
    }
    
    
}
