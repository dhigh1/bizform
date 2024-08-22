<?php
class Report_model extends CI_Model
{

    function __construct()
    {
        $this->table = 'workorder_profiles_checks';
        $this->workorders_table = 'workorders';
        $this->workorder_profiles_table = 'workorder_profiles';
        $this->customers_table = 'customers';
        $this->customer_branches_table = 'customer_branches';
        $this->customer_branches_persons_table = 'customer_branches_persons';
        $this->plans_table = 'plans';
        $this->templates_table = 'form_templates';

        $this->services_table = 'services';
        $this->users_table = 'users';
        $this->lookups_table = 'lookups';

        $this->workflow_table = 'workflow';
        $this->log_table = "workorders_log";

        $this->departments_table = 'departments';

        $this->vendor_table = 'vendors';
        $this->datetime_table = 'datetime_data';
    }

    protected $in_field = ['name'];

    function filter($filter_data, $item = 1, $page = 1, $sortby = '', $orderby = '', $all = true)
    {
        $arr = [];
        $arr1 = [];
        foreach($filter_data as $key=>$val){
            if($val['type']=='daterange'){
                array_push($arr,$key);
                $arr1['daterange'] = $val;
            }
            if($val['type']=='datetype'){
                array_push($arr, $key);
                $arr1['datetype'] = $val;
            }
        }

        $from = '';
        $to = '';
        if (!empty($arr1['daterange'])) {
            $daterange = $arr1['daterange']['value'];
            $fromTime = substr($daterange, 0, 10);
            $toTime = substr($daterange, 13, 10);
            $fromTime = $fromTime != "" ? custom_date("Y-m-d", $fromTime) : "";
            $toTime = $toTime != "" ? custom_date("Y-m-d", $toTime) : "";
            $from = $fromTime . ' 00:00:00';
            $to = $toTime . ' 23:59:59';
        }

        $datetype = '';
        if(!empty($arr1['datetype'])){
            $datetype = $arr1['datetype']['value'];
        }

        for($i=0; $i<count($arr); $i++){
            unset($filter_data[$arr[$i]]);
        }


        $search_field = array("$this->table.id", "$this->workorders_table.code", "$this->workorder_profiles_table.name");
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
					$this->workflow_table.name as status_name,
					$this->workflow_table.class_name as status_color_name,
					$this->services_table.name as services_name,
					$this->services_table.icon as services_icon,
					$this->services_table.icon_color as services_icon_color,
					$this->customers_table.name as customers_name,
					$this->customer_branches_table.name as customer_branches_name, 
					$this->workorders_table.code as workorder_code,
					$this->workorder_profiles_table.code  as workorders_profiles_code,
					$this->workorder_profiles_table.name as workorders_profiles_name,
					$this->workorder_profiles_table.phone as workorders_profiles_phone,
					$this->workorder_profiles_table.email as workorders_profiles_email,
					$this->datetime_table.date_type,
					$this->datetime_table.date_value,
                    $this->customer_branches_persons_table.name as contact_person_name

					FROM $this->table 
					LEFT JOIN $this->workorders_table on $this->table.workorders_id = $this->workorders_table.id 
					LEFT JOIN $this->workorder_profiles_table on $this->table.workorder_profiles_id = $this->workorder_profiles_table.id 

					LEFT JOIN $this->templates_table on $this->table.services_id = $this->templates_table.services_id

                    LEFT JOIN $this->customers_table on $this->workorders_table.customers_id = $this->customers_table.id 
					LEFT JOIN $this->customer_branches_table on $this->workorders_table.customer_branches_id = $this->customer_branches_table.id 
					LEFT JOIN $this->customer_branches_persons_table on $this->workorders_table.customer_branches_persons_id =$this->customer_branches_persons_table.id 

					LEFT JOIN $this->services_table on $this->table.services_id = $this->services_table.id 
					LEFT JOIN $this->workflow_table on $this->table.status = $this->workflow_table.id 

					INNER JOIN $this->datetime_table on $this->table.id = $this->datetime_table.data_id 

					where ($this->table.id>0) AND ($this->datetime_table.date_type='$datetype') AND ($this->datetime_table.date_value BETWEEN '$from' AND '$to'";
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
        $sql .= ') ';
        if (($item == 0) && ($page == 0)) {
            $sql .= " ORDER BY $sortby  $orderby  ";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $count = $row['countt'];
            } else {
                $count = 0;
            }

            return $count;
        } else {
            if (!empty($orderby)) {
                $sql .=     " ORDER BY $sortby  $orderby ";
            }
            if (!$all) {
                $sql .= "limit $page,$item";
            }
        }
        $query = $this->db->query($sql);
        // print_r($this->db->last_query());
        // exit();
        return $query;
    }
}
