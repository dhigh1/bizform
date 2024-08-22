<?php
class Usersmodel extends CI_Model
{


	 function __construct() { 
        // Set table name 
        $this->table = 'users'; 
		$this->roles_table = 'roles';
		$this->users_table = 'users';
		$this->department_table = 'departments';
		$this->lookups_table = 'lookups';
		$this->branch_table = 'organization_branches';
		$this->uploads_table = 'uploads'; 
    } 
     
	 protected $in_field = ['login_id','first_name','last_name','email','mobile'];
	 
	function filter($filter_data, $item=1, $page=1,$sortby='',$orderby='',$all=true) {
         $search_field = array("$this->table.login_id","$this->table.first_name","$this->table.last_name","$this->table.email","$this->table.mobile");
        if (($item == 0) && ($page == 0)) {
            $sql = "select count($this->table.id)  as countt "
                    . "FROM $this->table 
                    left join $this->branch_table on $this->table.organization_branches_id = $this->branch_table.id 
                    left join $this->department_table on $this->table.departments_id = $this->department_table.id 
					left join $this->roles_table on $this->table.roles_id = $this->roles_table.id
					left join $this->lookups_table as create_type_table on $this->table.create_type = create_type_table.id 
					left join $this->lookups_table as status_table on $this->table.status = status_table.id 
					left join $this->users_table as created_users_table on  $this->users_table.created_by = created_users_table.id
					left join $this->users_table as updated_users_table on   $this->users_table.updated_by = updated_users_table.id 
					where ($this->table.id>0";
        } else {
            $sql = "select $this->table.*, $this->department_table.name as departments_name, 
					$this->branch_table.name as organization_branches_name,
					$this->roles_table.name as roles_name,
					 created_users_table.login_id as created_username, updated_users_table.login_id as updated_username, 
					 status_table.l_value as status_name, status_table.color_name as status_color_name, 
					 restriction_table.l_value as restriction_name, restriction_table.color_name as restriction_color_name, 
					 create_type_table.l_value as create_type_name,				 
					$this->uploads_table.file_name as picture_name,$this->uploads_table.file_ext as picture_ext,$this->uploads_table.file_path as picture_path 
					from ".$this->table." 
                    left join $this->branch_table on $this->table.organization_branches_id = $this->branch_table.id 
					left join $this->department_table on $this->table.departments_id = $this->department_table.id 
					left join $this->roles_table on $this->table.roles_id = $this->roles_table.id
					left join $this->lookups_table as create_type_table on $this->table.create_type = create_type_table.id 
					left join $this->lookups_table as status_table on $this->table.status = status_table.id 
					left join $this->lookups_table as restriction_table on $this->table.data_restriction = restriction_table.id 
					left join $this->users_table as created_users_table on  $this->users_table.created_by = created_users_table.id
					left join $this->users_table as updated_users_table on   $this->users_table.updated_by = updated_users_table.id
					left join $this->uploads_table on $this->table.picture = $this->uploads_table.id
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

		
		public function check_duplicate_user($data){
			
		$this->db->where("(email='".$data['email']."' OR login_id='".$data['login_id']."')");
		$query=$this->db->get('users');
		return $query->row_array();
			
			
		}
		
	public function hash($password)
	{
       $hash = password_hash($password,PASSWORD_DEFAULT);
       return $hash;
	}

	//verify password
	public function verifyHash($password,$vpassword)
	{
		if(password_verify($password,$vpassword))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
		
    
}