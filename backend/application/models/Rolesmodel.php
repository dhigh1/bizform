<?php
class Rolesmodel extends CI_Model
{


	 function __construct() { 
        // Set table name 
        $this->table = 'roles'; 
		$this->department_table = 'departments';
		$this->org_branch_table = 'organization_branches';
		$this->lookups_table = 'lookups';
    } 
     
	 protected $in_field = ['name','departments_name'];
	 
	function filter($filter_data, $item=1, $page=1,$sortby='',$orderby='',$all=true) {
         $search_field = array("$this->table.name", "$this->org_branch_table.name", "$this->department_table.name");
        if (($item == 0) && ($page == 0)) {
            $sql = "select count($this->table.id)  as countt "
                    . "FROM ".$this->table."  "
					."left join $this->department_table on $this->table.departments_id = $this->department_table.id "
					."left join $this->lookups_table as status_table on $this->table.status = status_table.id "
					."left join $this->org_branch_table on $this->department_table.organization_branches_id = $this->org_branch_table.id "
                    . "Where($this->table.id>0";
        } else {
            $sql = "select $this->table.*, 
					$this->department_table.name as departments_name,
					status_table.l_value as status_name, status_table.color_name as status_color_name,
					$this->org_branch_table.name as organization_branches_name,$this->org_branch_table.id as organization_branches_id  
					from ".$this->table." 
					left join $this->department_table on $this->table.departments_id = $this->department_table.id 
					left join $this->lookups_table as status_table on $this->table.status = status_table.id 
					left join $this->org_branch_table on $this->department_table.organization_branches_id = $this->org_branch_table.id where ($this->table.id>0";
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
		  
             if(!empty($sortby)){
				$sql .=	 " ) ORDER BY $sortby  $orderby ";
			}
            

            $query = $this->db->query($sql);
			//print_r($sql);

            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $count = $row['countt'];
            } else {
                $count = 0;
            }
            return $count;
        } else {
         
                $sql .= ")"; 

				if(!empty($sortby)){
					$sql .=	 "ORDER BY $sortby  $orderby ";
				}
				
				if(!$all){
				 $sql .= "limit $page,$item";
				}
            }
			
            $query = $this->db->query($sql);
            return $query;
        }

		
    
}