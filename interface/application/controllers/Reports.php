<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        User::check_session();
		$this->userId = User::get_userId();
        $this->load->library('../controllers/template');
        $this->view_path = "users/reports/";
        $this->script_path = $this->view_path . "script/";
        $this->style_path = $this->view_path . "style/";
    }

    public function workorders()
    {
        $data['title'] = "Reports";

		$data['company_list'] = $this->curl->execute("customers", "GET", array('perpage' => 1000, 'sortby' => 'name', 'orderby' => 'ASC'));
        $data['services'] = $this->curl->execute('services', 'GET');
        $data['workorders'] = $this->curl->execute('workorders', 'GET');
        $data['vendors'] = $this->curl->execute('vendors', 'GET', array('perpage'=>1000, 'sortby'=>'name', 'orderby'=>'ASC'));
        $data['workflow'] = $this->curl->execute('workflow', 'GET');
        $data['content_view'] =  $this->load->view($this->view_path . "main_view", $data, true);
        $data['script'] =  $this->load->view($this->script_path . "script", '', true);
        $data['style'] =  $this->load->view($this->style_path . "style", '', true);
        $this->template->user_template($data);
    }


    function get_datas()
    {
        $filter_data = $this->input->post('filter_data');
		$page = $this->input->post('page');
		$filterData[] = array();
		if (!empty($page)) {
			$filterData['page'] = $page;
		}
		$filterData['orderby'] = 'DESC';
		if (!empty($filter_data)) {
			foreach ($filter_data as $k => $v) {
				if (!empty($v['type'])) {
                    if($v['type'] == 'customer_select'){
                        $v['type'] = 'customers-id';
                    }else if($v['type'] == 'cbranch_select'){
                        $v['type'] = 'customer_branches-id';
                    }else if($v['type'] == 'cbranch_person_select'){
                        $v['type'] = 'workorders-customer_branches_persons_id';
                    }
					$filterData[$v['type']] = $v['value'];
				}
			}
		}


        // print_r($filterData);
        // exit();
        $get_report = $this->curl->execute('report', 'GET', $filterData, 'filter');
        if ($get_report['status'] == 'success' && !empty($get_report['data_list'])) {
            $check_data['data_list'] = $get_report['data_list'];
            if (isset($get_report['pagination_data'])) {
                $check_data['pagination_data'] = $get_report['pagination_data'];
            }
            $str = $this->load->view($this->view_path . "tbl_view", $check_data, true);
            $value = array('message' => $str, 'status' => $get_report['status']);
        } else {
            $value = array('status'=>'fail', 'message'=>'No Checks found');
        }
        echo json_encode($value);
    }

    function report_download(){
        $filter_data = $this->input->post('filter_data');
		$page = $this->input->post('page');
		$filterData[] = array();
		$filterData['orderby'] = 'DESC';
		if (!empty($filter_data)) {
			foreach ($filter_data as $k => $v) {
				if (!empty($v['type'])) {
                    if($v['type'] == 'customer_select'){
                        $v['type'] = 'customers-id';
                    }else if($v['type'] == 'cbranch_select'){
                        $v['type'] = 'customer_branches-id';
                    }else if($v['type'] == 'cbranch_person_select'){
                        $v['type'] = 'workorders-customer_branches_persons_id';
                    }
					$filterData[$v['type']] = $v['value'];
				}
			}
		}

        $report = $this->curl->execute('report/download_report', 'GET', $filterData);

        if($report['status']=='success' && !empty($report['data_list'])){
            $value = array('status'=>$report['status'], 'url'=>$report['data_list']['url'], 'message'=>'Report downloded successfully.');
        }else{
            $value = array('status'=>$report['status'], 'message'=>'Report could not be downloaded');
        }
        echo json_encode($value);
    }
}

            // $check_data['pagination_data']
            // $logData=array(
            //     'action'=>'report',
            //     'description'=>'Generated report by the user',
            //     'data_id'=>User::get_userId(),
            //     'reference_id'=>User::get_userId(),
            //     'reference_name'=>User::get_userName(),
            //     'module'=>'report'
            // );
            // User::activity($logData);