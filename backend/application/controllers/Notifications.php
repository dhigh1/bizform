<?php

require APPPATH . 'libraries/REST_Controller.php';

class Notifications extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->database();
	   $this->load->model("notifications_model", "", true);
	   $this->lang->load('response', 'english');
	   $this->table = 'notifications';
	   $this->model_name='notifications_model';
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
		$filter_data[0]['type'] = 'notifications.id'; $filter_data[0]['value'] = $id;		
		$getData = $this->notifications_model->filter($filter_data);
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
			'reference_type' => ['Reference Type','required|numeric'],
			'title'=> ['Title', 'required'],
			'description' => ['Description','required'],
		];
		// 'ip_address' => ['IP Address','required']
		// 'action' => ['Action Name','required'],
		// 'module' => ['Module Name','required'],
		// 'reference_name' => ['Reference Name','required'],
		// 'data_id' => ['Data ID','required|numeric'],
		Validator::make($rules);
		if (!Validator::fails()){
            Validator::error();
        }else{
			// 'reference_name' =>$input['reference_name'],
			// 'data_id' =>$input['data_id'],
			// 'action' =>$input['action'],
			// 'module' =>$input['module'],
			// 'ip_address'=>$input['ip_address'],
			$data = array(
				'reference_id'=>$input['reference_id'],
				'reference_type'=>$input['reference_type'],
				'description' =>$input['description'],
				'reference_url' =>$input['reference_url'],
				'is_seen' =>$input['is_seen'],
				'created_at'=>cur_date_time()
			);
			$id = $this->Mydb->insert_table_data('notifications',$data);
			// print_r($id);
			// exit();
			//print_r($this->db->last_query());
			$value  = withSuccess($this->lang->line('uploads_success'));
			$this->response($value, REST_Controller::HTTP_OK);
		}
    }


    public function index_put($id=0)
    {
        if(empty($id)){
            $value=withErrors('Id is required');
            $this->response($value, REST_Controller::HTTP_OK);
        }

        $input = $this->put();
        $rules = array();

        if(!empty($input)){
            $get_data = $this->db->get_where($this->table, array('id'=>$id))->row_array();
            if(!empty($get_data)){

                $is_update = $this->Mydb->update_table_data($this->table, array('id'=>$id), array('is_seen'=>0));
                if($is_update>0){
                    $result = $this->Mydb->get_single_result($id,$this->table,$this->model_name);
                    $value  = withSuccess($this->lang->line($this->table.'_updated_success'),$result);
                }else{
                    $value  = withErrors('Unable to update notification, something wrong with data input!');
                }
            }else{
                $value  = withErrors($this->lang->line($this->table.'_not_found'));
            }
        }else{
            $value  = withErrors($this->lang->line('no_data_for_update'));
        }
        $this->response($value, REST_Controller::HTTP_OK);

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
		$sortby = "notifications.id";
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
		$total_rows = $this->notifications_model->filter($filter_data, 0, 0,$sortby,$orderby,$all);	   
		$udata = $this->Mydb->getPaginationData($perpage, $page, $total_rows);
		$data = array_merge($data,$udata);			
		$getData = $this->notifications_model->filter($filter_data, $perpage, $data['page_position'],$sortby,$orderby,$all);			
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
	

}	