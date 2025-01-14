<?php
class User extends CI_Model
{
    
	private $table_name='users';
	private static $db;

    function __construct(){
        parent::__construct();
        self::$db = &get_instance()->db;
    }
	
	static function check_session()
    {
      	$ci =& get_instance();
        // print_r(User::is_active());
        // exit();
        $ci->load->library('session');
        if(User::get_userId()==null || User::is_logged()==null){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
                $value=array(
                    'session'=>'false',
                    'status'=>'fail',
                    'result'=>'fail',
                    'message'=>'Session timeout, please <a href="'.base_url().'login">login</a> again!'
                );          
                echo json_encode($value);
                exit();
            }
            else{
                redirect(base_url().'login');
            }
        }
        if(User::is_active()!=7){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
                $value=array(                    
                    'session'=>'false',
                    'status'=>'fail',
                    'result'=>'fail',
                    'message'=>'Your account is suspended, please contact administrator!'
                );          
                echo json_encode($value);
                exit();
            }else{
                redirect(base_url().'logout');
            }
        }
        return;        
    }

	static function get_userId()
    {
		$ci =& get_instance();
        return $ci->session->userdata('userId');
    }

	static function get_userName()
    {
		$ci =& get_instance();
        return $ci->session->userdata('userName');
    }

    static function is_active()
    {
        $ci =& get_instance();
        $id=User::get_userId();
        // print_r($id);
        // exit();
        $apidata=$ci->curl->execute("users/$id","GET");
        return $apidata['data_list']['status'];
    }

	static function is_logged()
    {
	    $ci =& get_instance();
	    $logged_in =  $ci->session->userdata('userLogged');
		return $logged_in;        
    }

    static function is_admin()
    {
        $ci =& get_instance();
        $is_admin =  $ci->session->userdata('userisAdmin');
        return $is_admin;        
    }

    static function get_userRole()
    {
        $ci =& get_instance();
        $data =  $ci->session->userdata('userRoleId');
        return $data;        
    }

    static function get_userDept()
    {
        $ci =& get_instance();
        $data =  $ci->session->userdata('userDeptId');
        return $data;        
    }

    static function get_userClsLevel()
    {
        $ci =& get_instance();
        $data =  $ci->session->userdata('userClsLevel');
        return $data;        
    }

    static function get_ReferType()
    {   
        $id=24;
        return $id; 
    }
	
	static function activity($data)
    {
		if(isset($data['reference_id'])){
            $data['reference_id']=$data['reference_id'];
        }else{
            $data['reference_id']=User::get_userId();
        }
        if(isset($data['reference_name'])){
            $data['reference_name']=$data['reference_name'];
        }else{
            $data['reference_name']=User::get_userName();
        }
        $data['action']=strtolower($data['action']);
        $data['module']=strtolower($data['module']);
        $data['ip_address']=get_ipaddress();
		$data['reference_type']=User::get_ReferType();
		$ci =& get_instance();
        $apidata=$ci->curl->execute("activity_log","POST",$data); 
    }


    static function check_permission($ui_url='',$type=''){
        $ci =& get_instance();
        $is_admin=User::is_admin();
        if($is_admin==0 || empty($is_admin)){
            $data = array('roles_id'=>User::get_userRole(),'ui_url'=>$ui_url);
            $apidata = $ci->curl->execute("module_permissions/check_permission","POST",$data);
            $status = $apidata['status'];
            if($status=='success'){
                $result=true;
            }else{
                $result=false;
            }
            if($type=="check"){
                return $result;
            }else if($result==false){
                if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
                    $value=array(
                        'status'=>"fail",
                        'message'=>"You don't have permission. <br/>Please contact Admininstrator to request access."
                    );
                    echo json_encode($value);
                    exit;
                }else{            
                    redirect(base_url().'permission');
                }        
            }
        }else{
            return true;
        }
    }

    static function check_service_view($service_dept_id){
        $deptId=User::get_userDept();
        $classLevel=User::get_userClsLevel();
        if(User::is_admin()){
            return true;
        }
        if($deptId==$service_dept_id){
            return true;
        }else{
            return false;
        }
    }
	
    
}
