<?php
class Formbuildermodel extends CI_Model
{


    function __construct()
    {
        // Set table name 
        $this->table = 'forms';
        $this->customers_table = 'customers';
        $this->countries_table = 'countries';
        $this->states_table = 'states';
        $this->cities_table = 'cities';
        $this->lookups_table = 'lookups';
        $this->users_table = 'users';
        $this->categories_table = 'form_categories';
    }

    protected $in_field = ['name', 'branch_code'];

    function filter($filter_data, $item = 1, $page = 1, $sortby = '', $orderby = '', $all = true)
    {

        $search_field = array("$this->table.name", "$this->table.form_code", "category_table.name");
        if (($item == 0) && ($page == 0)) {
            $sql = "select count($this->table.id)  as countt "
                . "FROM $this->table
					left join $this->lookups_table on $this->table.status = $this->lookups_table.id 
					left join $this->categories_table as category_table on $this->table.category_id = category_table.id
					left join $this->users_table as created_users_table on $this->table.created_by = created_users_table.id
					left join $this->users_table as updated_users_table on $this->table.updated_by = updated_users_table.id "
                . "Where($this->table.id>0";
        } else {
            $sql = "select $this->table.*,  
					created_users_table.login_id as created_username, updated_users_table.login_id as updated_username, $this->lookups_table.l_value as status_name, $this->lookups_table.color_name as status_color_name, category_table.name as category_name, category_table.code as category_code
                    FROM  $this->table
					left join $this->lookups_table  on $this->table.status = $this->lookups_table.id 
					left join $this->categories_table as category_table on $this->table.category_id = category_table.id
					left join $this->users_table as created_users_table on  $this->table.created_by = created_users_table.id
					left join $this->users_table as updated_users_table on $this->table.updated_by = updated_users_table.id " . " Where($this->table.id>0";
        }
        if (!empty($filter_data)) {
            foreach ($filter_data as $k => $v) {
                if (($v['type'] == 'search') && ($v['value'] != "")) {
                    $values = $v['value'];
                    array_walk($search_field, function (&$value, $key) use ($values) {
                        $value .= " like '%" . $values . "%'";
                    });

                    $sql .= ") AND (" . implode(" OR ", $search_field);
                } else {

                    if ($v['value'] != "") {

                        if (in_array($v['type'], $this->in_field)) {
                            $v['type'] = $this->table . "." . $v['type'];
                        }

                        $sql .= ") AND ( " . $v['type'] . " ='" . $v['value'] . "'";
                    }
                }
            }
        }

        if (($item == 0) && ($page == 0)) {
            $sql .= ")";
            if (!empty($sortby)) {
                $sql .=     "ORDER BY $sortby  $orderby ";
            }
            // print_r($sql);exit();
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
            if (!empty($sortby)) {
                $sql .=     "ORDER BY $sortby  $orderby ";
            }
            if (!$all) {
                $sql .= "limit $page,$item";
            }
        }

        $query = $this->db->query($sql);
        return $query;
    }


    public function check_duplicate_branch_code($data)
    {
        $this->db->where("(branch_code='" . $data['branch_code'] . "')");
        $query = $this->db->get('customer_branches');
        return $query->row_array();
    }

    public function check_duplicate_branch_persons($data)
    {
        $this->db->where("(customer_branches_id='" . $data['customer_branches_id'] . "' && phone='" . $data['phone'] . "')");
        $query = $this->db->get('customer_branches_persons');
        return $query->row_array();
    }
}
