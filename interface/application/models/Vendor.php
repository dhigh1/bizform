<?php
class Vendor extends CI_Model
{
    
	private $table_name='vendors';
	private static $db;

    function __construct(){
        parent::__construct();
        self::$db = &get_instance()->db;
    }
	
	static function check_session()
    {
      	$ci =& get_instance();
        $ci->load->library('session');
        if(Vendor::get_userId()==null || Vendor::is_logged()==null){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
                $value=array(
                    'session'=>'false',
                    'status'=>'fail',
                    'result'=>'fail',
                    'message'=>'Session timeout, please <a href="'.base_url().'vendor/login">login</a> again!'
                );          
                echo json_encode($value);
                exit();
            }else{
                redirect(base_url().'vendor/login');
            }
        }
        //print_r(User::is_active());
        if(Vendor::is_active()!=43){
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
                // /redirect(base_url().'logout');
            }
        }
        return;        
    }

	static function get_userId()
    {
		$ci =& get_instance();
        return $ci->session->userdata('vendorId');
    }

	static function get_userName()
    {
		$ci =& get_instance();
        return $ci->session->userdata('vendorName');
    }

    static function is_active()
    {
        $ci =& get_instance();
        $id=Vendor::get_userId();
        $apidata=$ci->curl->execute("vendors/$id","GET");
        //print_r($apidata['data_list']);
        return $apidata['data_list']['status'];
    }

	static function is_logged()
    {
	    $ci =& get_instance();
	    $logged_in =  $ci->session->userdata('vendorLogged');
		return $logged_in;        
    }

    static function get_vendorType()
    {
        $ci =& get_instance();
        $vendorType =  $ci->session->userdata('vendorType');
        return $vendorType;        
    }

    static function get_vendorIndType()
    {
        $ci =& get_instance();
        $vendorIndType =  $ci->session->userdata('vendorIndType');
        return $vendorIndType;        
    }    

    static function get_ReferType()
    {   
        $id=25;
        return $id; 
    }
	
	static function activity($data)
    {
		if(isset($data['reference_id'])){
            $data['reference_id']=$data['reference_id'];
        }else{
            $data['reference_id']=Vendor::get_userId();
        }
        if(isset($data['reference_name'])){
            $data['reference_name']=$data['reference_name'];
        }else{
            $data['reference_name']=Vendor::get_userName();
        }
        $data['action']=strtolower($data['action']);
        $data['module']=strtolower($data['module']);
        $data['ip_address']=get_ipaddress();
		$data['reference_type']=Vendor::get_ReferType();
		$ci =& get_instance();
        $apidata=$ci->curl->execute("activity_log","POST",$data);
    }



    function download_cases($data,$from,$to)
	{
		$sql = "SELECT $this->case_table.case_id as Case_Id,$this->case_table.ref_id as Reference_Id,
				$this->case_table.first_name as First_Name, $this->case_table.last_name as Last_Name, 
                $this->case_table.email as Email, $this->case_table.mobile as Mobile,
				$this->case_table.address as Address_Lane,
                $this->states_table.name as State,
                $this->cities_table.name as City,
                $this->case_table.pincode as Pincode,
                $this->case_table.comments as Comments,
                $this->client_table.company as Client,
                $this->client_branch_table.name as Client_Branch,
                $this->case_table.created_at as Created_Date,
                created_user_table.username as Created_By,
                $this->data_table.created_at as Verification_Date,
                $this->case_table.qa_date as QA_Date,
                qa_user_table.username as QA_By,
                $this->case_table.qa_comment as QA_Comments,
                status_table.data_value as Status,
                report_status_table.data_value as Report_Status,
                $this->map_data_table.from_to as Distance_From,
                $this->map_data_table.final_distance as Distance,
                $this->map_data_table.unit as Distance_Unit,
                $this->map_data_table.final_status as Distance_status";

        $sql.= " FROM $this->case_table

                INNER JOIN $this->order_table
                ON $this->order_table.id=$this->case_table.order_id

                LEFT JOIN $this->templates
                ON $this->templates.formId=$this->case_table.formId

                LEFT JOIN $this->data_table
                ON $this->data_table.verifyId=$this->case_table.verifyId

                LEFT JOIN $this->map_data_table
                ON $this->map_data_table.verifyId=$this->case_table.verifyId

                LEFT JOIN $this->address_type_table
                ON $this->address_type_table.id=$this->case_table.addtype_id

                LEFT JOIN $this->client_table
                ON $this->order_table.client_id=$this->client_table.client_id
                LEFT JOIN $this->client_branch_table
                ON $this->order_table.branch_id=$this->client_branch_table.id

                LEFT JOIN $this->states_table
                ON $this->states_table.id=$this->case_table.state
                LEFT JOIN $this->cities_table
                ON $this->cities_table.id=$this->case_table.city
                LEFT JOIN $this->country_table
                ON $this->country_table.id=$this->case_table.country

                LEFT JOIN $this->users_table as created_user_table
                ON created_user_table.userId=$this->case_table.created_by
                LEFT JOIN $this->users_table as updated_user_table
                ON updated_user_table.userId=$this->case_table.updated_by
                
                LEFT JOIN $this->users_table as qa_user_table
                ON qa_user_table.userId=$this->case_table.qa_by                

                LEFT JOIN $this->lookups_table as status_table
                ON status_table.id=$this->case_table.status

                LEFT JOIN $this->lookups_table as report_status_table
                ON report_status_table.id=$this->data_table.report_status";

		if($data['dateType']=="created"){
            $sql.=" WHERE $this->case_table.created_at BETWEEN '$from' AND '$to' ";
        }else if($data['dateType']=="verification"){
            $sql.=" WHERE $this->data_table.created_at BETWEEN '$from' AND '$to' ";
        }else if($data['dateType']=="decison"){
            $sql.=" WHERE $this->case_table.qa_date BETWEEN '$from' AND '$to' ";
        }else{
            $sql.=" WHERE $this->case_table.created_at BETWEEN '$from' AND '$to' ";
        }
        
        if($data['status']!=""){
            $sql.=" AND $this->case_table.status='".$data['status']."'";
        }
        if($data['client_id']!=""){
            $sql.=" AND $this->order_table.client_id='".$data['client_id']."'";
        }
        if($data['branch_id']!=""){
            $sql.=" AND $this->order_table.branch_id='".$data['branch_id']."'";
        }
        $sql.=" ORDER BY $this->case_table.created_at ASC";
        
        //print_r($sql);
        $query=$this->db->query($sql);
        return $query;
	}
	
    
}
