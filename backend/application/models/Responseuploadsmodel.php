<?php
class Responseuploadsmodel extends CI_Model
{


    function __construct()
    {
        // Set table name 
        $this->table = 'response_upload';
        $this->users_table = 'users';
        $this->lookups_table = 'lookups';
        $this->campaigns_table = 'campaigns';
        $this->forms_table = 'forms';
    }

    protected $in_field = ['table_name'];

    function filter($filter_data, $item = 1, $page = 1, $sortby = '', $orderby = '', $all = true)
    {
        $search_field = array("$this->table.campaign_id,$this->table.form_id");
        if (($item == 0) && ($page == 0)) {
            $sql = "select count($this->table.id) as countt "
                . "FROM " . $this->table . "  "
                . "Where($this->table.id>0";
        } else {
            $sql = "select $this->table.*, campaigns_table.name as campaign_name, forms_table.name as form_name 
					from " . $this->table . " 
					left join $this->campaigns_table as campaigns_table on  $this->table.campaign_id = campaigns_table.id
					left join $this->forms_table as forms_table on $this->table.form_id = forms_table.id
					where ($this->table.id>0";
        }
        if (!empty($filter_data)) {
            foreach ($filter_data as $k => $v) {
                if (($v['type'] == 'search') && ($v['value'] != "")) {
                    $values = $v['value'];
                    array_walk($search_field, function (&$value, $key) use ($values) {
                        $value .= " like '%" . $values . "%'";
                    });

                    $sql .= ") AND (" . implode(" || ", $search_field);
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
            if (!empty($sortby)) {
                $sql .=     ") ORDER BY $sortby  $orderby ";
            }

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

    public function check_duplicate_customer($data)
    {
        $this->db->where("(customer_code='" . $data['customer_code'] . "')");
        $query = $this->db->get('customers');
        return $query->row_array();
    }
}
