<?php

require APPPATH . 'libraries/REST_Controller.php';   

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Activity_log extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->database();
	   $this->load->model("activitylog_model", "", true);
	   $this->lang->load('response', 'english');
    }
       

    /**

     * Get All Data from this method.

     *

     * @return Response

    */

	public function index_get($id = 0)
	{
		$message = "success";
        if(!empty($id)){
            $data = $this->get_single_result($id);
			if(empty($data)){
				$message = $this->lang->line('no_result_found');
			}
			$data = array('details'=>$data);
        }else{			
			$data = $this->search();
			if(empty($data['data_list'])){
				$message = $this->lang->line('no_result_found');
			}			
        }
		$value  = withSuccess($message,$data);
		$this->response($value, REST_Controller::HTTP_OK);
	}
	
	public function get_single_result($id){	
		$filter_data[0]['type'] = 'activity_log.id'; $filter_data[0]['value'] = $id;		
		$getData = $this->activitylog_model->filter($filter_data);
		return $getData->row_array();
	}

     

    /**

     * Insert data from this method.

     *

     * @return Response

    */

    public function index_post()
    {
        $input = $this->input->post();
		$rules = [
			'reference_id' => ['Reference ID','required|numeric'],
			'reference_name' => ['Reference Name','required'],
			'reference_type' => ['Reference Type','required|numeric'],
			'data_id' => ['Data ID','required|numeric'],
			'action' => ['Action Name','required'],
			'module' => ['Module Name','required'],
			'description' => ['Description','required'],
			'ip_address' => ['IP Address','required']
		];
		Validator::make($rules);
		if (!Validator::fails()){
            Validator::error();
        }else{
			$data = array(
				'reference_id'=>$input['reference_id'],
				'reference_type'=>$input['reference_type'],
				'reference_name' =>$input['reference_name'],
				'data_id' =>$input['data_id'],
				'action' =>$input['action'],
				'module' =>$input['module'],
				'description' =>$input['description'],
				'ip_address'=>$input['ip_address'],
				'created_at'=>cur_date_time()
			);
			$id = $this->Mydb->insert_table_data('activity_log',$data);
			//print_r($this->db->last_query());
			$value  = withSuccess($this->lang->line('uploads_success'));
			$this->response($value, REST_Controller::HTTP_OK);
		}
    }
	
	
	/**
	
	* Search data from this method.
	
	*
	
	* @return Response
	
	*/

	public function search()
    {
		$param_default = array('search','perpage','page','sortby','orderby');
		$parameters = $this->input->get();
		$diff = array();
		$data = array();
		$data['data_list'] = array();	
		$search = "";
		$perpage = 10;
		$page = 1;
		$sortby = "activity_log.id";
		$orderby = "DESC";
		$all = false;
		$data['slno'] ='';
		
		if(!empty($parameters)){
			$parem_key = array_keys($parameters);
			$diff = array_diff($parem_key,$param_default);
			$intersect = array_intersect($parem_key,$param_default);
		}		
		if(array_key_exists('page',$parameters)){
			$all = false;
		}		
		if(!empty($intersect)){
			foreach($intersect as $inst){	
				$rml =  str_replace('-','.',$parameters[$inst]);
				$$inst = $rml;
			}
		}
		$filter_data[0]['type'] = 'search'; $filter_data[0]['value'] = $search;		
		if(!empty($diff)){
			$i = count($filter_data);
			foreach($diff as $p){
				if(!empty($this->input->get($p))){
					$pa = str_replace('-','.',$p);
					$filter_data[$i]['type'] = $pa;
					$filter_data[$i]['value'] = $this->input->get($p);
				}
				$i++;
			}
		}	
		$total_rows = $this->activitylog_model->filter($filter_data, 0, 0,$sortby,$orderby,$all);	   
		$udata = $this->Mydb->getPaginationData($perpage, $page, $total_rows);
		$data = array_merge($data,$udata);			
		$getData = $this->activitylog_model->filter($filter_data, $perpage, $data['page_position'],$sortby,$orderby,$all);			
		$data['pagination'] = $this->Mydb->paginate_function($perpage, $data['page_number'], $total_rows, $data['total_pages']);
        if ($getData->num_rows() > 0) {            
			foreach ($getData->result() as $row) {
                $data['data_list'][] = $row;
			}
			if ($page == 1) {
				$data['slno'] = 1;
			} else {
				$data['slno'] = (($page - 1) * $perpage) + 1;
			}
		}			
		if($all){
			array_splice($data,1);
		}		
		return $data;
    }
	


	public function daily_activity_get(){
        $data = array();
        $date = explode(' ', cur_date_time());
        $start = $date[0].' 00:00:00';
        $end = $date[0].' 23:59:59';
        $q = "SELECT a.*
            FROM activity_log a 
            WHERE a.created_at BETWEEN '$start' AND '$end' ORDER BY a.created_at DESC"; 
        $result = $this->db->query($q)->result_array();
        if(!empty($q)){
            $value = withSuccess('Activity Data Fetched Successfully', array('details'=>$result));
        }else{
            $value = withErrors('No Data Found for Activity logs');
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }
	
	
	/**

     * Export data from  file using this method.

     *

     * @return Response

    */

	public function export_get(){
		$rand        = rand(1234, 9898);
        $presentDate = date('d_m_Y_h_i_s_A');
        $file_name    = "report_activity_log_". $presentDate . ".xlsx";
		$_GET['perpage'] = '10000';
		$data = $this->search();
		
		if(!empty($data['data_list'])){
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$sheet->setCellValue('A1', 'IP Address');
			$sheet->setCellValue('B1', 'Type');
			$sheet->setCellValue('C1', 'Username');
			$sheet->setCellValue('D1', 'Action');		
			$sheet->setCellValue('E1', 'Module');	
			$sheet->setCellValue('F1', 'Description');	
			$sheet->setCellValue('G1', 'Time');

			$count = 2;

			foreach($data['data_list'] as $row)
			{			
				$sheet->setCellValue('A' . $count, $row->ip_address);
				$sheet->setCellValue('B' . $count, $row->refer_type);
				$sheet->setCellValue('C' . $count, $row->reference_name);
				$sheet->setCellValue('D' . $count, $row->action);
				$sheet->setCellValue('E' . $count, $row->module);
				$sheet->setCellValue('F' . $count, $row->description);
				$sheet->setCellValue('G' . $count, custom_date('d-m-Y h:i:s A',$row->created_at));
				$count++;
			}

			$writer = new Xlsx($spreadsheet);
			$filePath = 'reports/' . $file_name;			
			$writer->save($filePath);			
			$res =  array(
				'filename' => $file_name,
				'url' => base_url().$filePath
			); 
			$result=array('details'=>$res);
			$value = withSuccess($this->lang->line('report_generated_successfully'),$result);
		}else{
			$value = withErrors($this->lang->line('no_result_found'));
		}       
		$this->response($value, REST_Controller::HTTP_OK);
	}	

}	