<?php
class Module_permissionsmodel extends CI_Model
{


	function __construct() { 
        // Set table name 
        $this->table = 'module_permissions'; 
		$this->role_permissions_table = 'roles_permissions_map'; 
		$this->lookups_table = 'lookups';
		$this->modules_table = 'modules';
		$this->users_table = 'users';
    } 
     

	
    function TreeList()
    {		
		$sql   = "select $this->table.*, 
				created_users_table.login_id as created_username, 
				updated_users_table.login_id as updated_username,
				$this->lookups_table.l_value as status_name,
				$this->lookups_table.color_name as status_color_name
				from $this->table  
				left join $this->lookups_table on $this->table.status = $this->lookups_table.id
				left join $this->users_table as created_users_table on  $this->table.created_by = created_users_table.id
				left join $this->users_table as updated_users_table on   $this->table.updated_by = updated_users_table.id
				inner join $this->modules_table on  $this->table.modules_id =  $this->modules_table.id 
				ORDER BY $this->modules_table.name ASC";
        $query = $this->db->query($sql);
        $data  = array();
        
        foreach ($query->result_array() as $row) {            
            $data[] = $row;            
        }
        return $data;
    }
	
	
	
	function buildTree(Array $data, $parent = 0)
    {
        $tree = array();
        foreach ($data as $d) {
            if ($d['parent'] == $parent) {
                $children = $this->buildTree($data, $d['id']);
                // set a trivial key
                if (!empty($children)) {
                    $d['_children'] = $children;
                }
                $tree[] = $d;
            }
        }
        return $tree;
    }
    
    public function roles_permission_list($roles_id){
		
	$sql = "select $this->role_permissions_table.*, $this->table.name as module_permissions_name,  $this->table.api_url, $this->table.api_method,
				$this->modules_table.table_name as modules_name 
				from $this->role_permissions_table 
				inner join $this->table on   $this->role_permissions_table.module_permissions_id = $this->table.id
				inner join $this->modules_table on  $this->table.modules_id = $this->modules_table.id where $this->role_permissions_table.roles_id = '".$roles_id."'";
		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
	
    public function get_single_details($id){		
		$sql = "select $this->table.*, 
			$this->modules_table.name as modules_name,$this->modules_table.table_name as modules_table_name 
			from $this->table 
			inner join $this->modules_table on  $this->table.modules_id = $this->modules_table.id 
			where $this->table.id = '".$id."'";
		$query = $this->db->query($sql);
		return $query->row_array();		
	}
	
	function check_permission($data){
		$sql = "select $this->role_permissions_table.*, 
				$this->table.name as modules_name,
				$this->table.ui_url as ui_url, 
				$this->table.api_url as api_url 
				FROM $this->role_permissions_table 
				INNER join $this->table on $this->role_permissions_table.module_permissions_id = $this->table.id 
				WHERE $this->table.ui_url = '".$data['ui_url']."'
				AND $this->role_permissions_table.roles_id = '".$data['roles_id']."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_user_permissions($roles_id){
		$sql = "select $this->role_permissions_table.*, 
				$this->table.name as modules_name,
				$this->table.ui_url as ui_url, 
				$this->table.api_url as api_url,
				$this->table.api_method as api_method,
				$this->table.parent as parent 
				FROM $this->role_permissions_table 
				INNER join $this->table on $this->role_permissions_table.module_permissions_id = $this->table.id 
				WHERE $this->role_permissions_table.roles_id = '".$roles_id."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
}