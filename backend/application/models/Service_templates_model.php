<?php
class Service_templates_model extends CI_Model
{
	 function __construct() { 
        // Set table name 
        $this->table = 'form_templates';
		$this->services_table = 'services';
		$this->users_table = 'users';
		$this->lookups_table = 'lookups'; 
		$this->customers_table = 'customers';
    } 
     
	 protected $in_field = ['form_code','name'];
	 
	function filter($filter_data, $item=1, $page=1,$sortby='',$orderby='',$all=true) {
         $search_field = array("$this->table.name","$this->table.form_code");
        if (($item == 0) && ($page == 0)) {
            $sql = "select count($this->table.id)  as countt 
					FROM $this->table 
					left join $this->services_table on $this->table.services_id = $this->services_table.id
					left join $this->lookups_table as status_table on $this->table.status = status_table.id
					left join $this->customers_table on $this->table.customers_id = $this->customers_table.id
					left join $this->users_table as created_users_table on  $this->table.created_by = created_users_table.id
					left join $this->users_table as updated_users_table on   $this->table.updated_by = updated_users_table.id 
					where ($this->table.id>0";
        } else {
            $sql = "select $this->table.*, 
					$this->customers_table.customer_code as customers_code,
					$this->customers_table.name as customers_name,
					$this->services_table.service_code as services_code,
					$this->services_table.name as services_name,
					$this->services_table.execution_type as services_execution_type,
					$this->services_table.executor_id as services_executor_id,
					$this->services_table.departments_id as services_execution_department_id,
					created_users_table.login_id as created_username, 
					updated_users_table.login_id as updated_username, 
					status_table.l_value as status_name, 
					status_table.color_name as status_color_name					
					from $this->table 
					left join $this->services_table on $this->table.services_id = $this->services_table.id
					left join $this->lookups_table as status_table on $this->table.status = status_table.id 
					left join $this->customers_table on $this->table.customers_id = $this->customers_table.id
					left join $this->users_table as created_users_table on  $this->table.created_by = created_users_table.id
					left join $this->users_table as updated_users_table on   $this->table.updated_by = updated_users_table.id
					where ($this->table.id>0";
        }
		if(!empty($filter_data)){
			foreach ($filter_data as $k => $v) {
				if (($v['type'] == 'search') && ($v['value'] != "")) {
					$values = $v['value'];
					array_walk($search_field, function(&$value, $key) use ($values) {
						$value .= " like '%" . $values . "%'";
					});
					$sql .= ") AND (" . implode(" || ", $search_field);
				}else{					
					if($v['value']!=""){							
						if(in_array($v['type'],$this->in_field)){
							$v['type'] = $this->table.".".$v['type'];
						}						
						$sql .= ") AND ( ".$v['type']." ='".$v['value']."'";
					}					
				}			
			}
		}
        if (($item == 0) && ($page == 0)) {           
            $sql .= ")  order by $sortby  $orderby  ";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $count = $row['countt'];
            } else {
                $count = 0;
            }
            return $count;
        } else {         
			$sql .= ")";
			if(!empty($orderby)){
				$sql .=	 "ORDER BY $sortby  $orderby ";
			}			
			if(!$all){
			 $sql .= "limit $page,$item";
			}
		}
		$query = $this->db->query($sql);
		return $query;
	}

	public function check_duplicate_vendor($data){
		$this->db->where("(form_code='".$data['form_code']."'");
		$query=$this->db->get('form_templates');
		return $query->row_array();			
	}
	
		
    
}