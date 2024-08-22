<?php
class Template extends CI_Model
{   
    private $table_name='users';
    private static $db;
    
    function __construct(){
        parent::__construct();
        //$this->admin->nocache();
        self::$db = &get_instance()->db;
    }
    
    public function default_template($param)
    {        
        $data = $this->admin->common_files();
	    $data = array_merge($data,$param);
        unset($data['header_menu'],$data['header_main']); 
        $this->load->view('template/default_view', $data);
    }
	
	public function user_template($param)
    {        
        $data = $this->admin->common_user_files();
    	if(!isset($param['script'])){ $param['script'] = "";  }	
    	if(!isset($param['style'])){ $param['style'] = "";  }	
	    $data = array_merge($data,$param);
        $this->load->view('template/user_view', $data);
    }

    public function public_template($param)
    {        
        $data = $this->admin->common_public_files();
        if(!isset($param['script'])){ $param['script'] = "";  } 
        if(!isset($param['style'])){ $param['style'] = "";  }   
        $data = array_merge($data,$param);
        $this->load->view('template/public_view', $data);
    }

    public function customer_template($param)
    {        
        $data = $this->admin->common_customer_files();
        if(!isset($param['script'])){ $param['script'] = "";  } 
        if(!isset($param['style'])){ $param['style'] = "";  }   
        $data = array_merge($data,$param);
        $this->load->view('template/customer_view', $data);
    }    

    public function login_template($param)
    {        
        $data = $this->admin->common_user_files();
        $data = array_merge($data,$param);
        unset($data['header_menu'],$data['header_main']); 
        $this->load->view('template/login_view', $data);
    }
    
   
    
}