<?php
class Profiles_model extends CI_Model
{

	function __construct(){
        // Set table name 
        $this->table= 'workorder_profiles_checks';
        $this->workorders_table= 'workorders'; 
        $this->workorder_profiles_table= 'workorder_profiles'; 
        $this->customers_table= 'customers'; 
        $this->customer_branches_table= 'customer_branches';  
        $this->plans_table= 'plans'; 
        
        $this->services_table= 'services'; 
		$this->users_table = 'users';
		$this->lookups_table = 'lookups';
		
		$this->workflow_table= 'workflow'; 
		$this->log_table="workorders_log";
		
		$this->vendor_table= 'vendors'; 
    }
	
	protected $in_field = ['name'];
	 
	function filter($filter_data, $item=1, $page=1,$sortby='',$orderby='',$all=true) {
        $search_field = array("$this->table.id","$this->workorders_table.code","$this->workorder_profiles_table.name");
        if (($item == 0) && ($page == 0)) {
            $sql = "select count($this->table.id)  as countt 
                    FROM $this->table   
					LEFT JOIN $this->workorders_table on $this->table.workorders_id = $this->workorders_table.id 
					LEFT JOIN $this->workorder_profiles_table on $this->table.workorder_profiles_id = $this->workorder_profiles_table.id 

                    LEFT JOIN $this->customers_table on $this->workorders_table.customers_id = $this->customers_table.id 
					LEFT JOIN $this->customer_branches_table on $this->workorders_table.customer_branches_id = $this->customer_branches_table.id 
					LEFT JOIN $this->services_table on $this->table.services_id = $this->services_table.id 
					LEFT JOIN $this->workflow_table on $this->table.status = $this->workflow_table.id 
  
                    where ($this->table.id>0";
        } else {
            $sql = "select $this->table.*,
					$this->table.code  as check_code,
					$this->customers_table.name as customers_name,
					$this->customers_table.id as customers_id,
					$this->customer_branches_table.name as customer_branches_name, 
					$this->workorders_table.code as workorder_code,
					$this->workorder_profiles_table.code  as workorders_profiles_code,
					$this->workorder_profiles_table.name as workorders_profiles_name,
					$this->workorder_profiles_table.phone as workorders_profiles_phone,
					$this->workorder_profiles_table.email as workorders_profiles_email

					FROM $this->table 

					LEFT JOIN $this->workorders_table on $this->table.workorders_id = $this->workorders_table.id 
					LEFT JOIN $this->workorder_profiles_table on $this->table.workorder_profiles_id = $this->workorder_profiles_table.id 

                    LEFT JOIN $this->customers_table on $this->workorders_table.customers_id = $this->customers_table.id 
					LEFT JOIN $this->customer_branches_table on $this->workorders_table.customer_branches_id = $this->customer_branches_table.id 
					
					where ($this->table.id>0";
        }
		
		$sql.=") AND ($this->table.status>=1 ";
		
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
		$sql.=') ';
        if (($item == 0) && ($page == 0)) {		  
        	//$sql .= " GROUP BY $this->table.id "; 
            $sql .= " ORDER BY $sortby  $orderby  ";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $count = $row['countt'];
            } else {
                $count = 0;
            }
            
            return $count;
        }else{
			//$sql .= " GROUP BY $this->table.id "; 
			if(!empty($orderby)){
				$sql .=	 " ORDER BY $sortby  $orderby ";
			}				
			if(!$all){
				$sql .= "limit $page,$item";
			}
		}
		$query = $this->db->query($sql);
		return $query;
	}
	
	
}