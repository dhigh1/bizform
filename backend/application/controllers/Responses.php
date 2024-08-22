<?php

require APPPATH . 'libraries/REST_Controller.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Responses extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("candidatesmodel", "", true);
        $this->load->model("responsesmodel", "", true);
        $this->load->model("responseuploadsmodel", "", true);
        $this->load->library('excelvalidation');
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
        if (!empty($id)) {
            $data = $this->db->get_where("bizform_candidates", ['id' => $id])->row_array();
            if (empty($data)) {
                $message = $this->lang->line('no_result_found');
            }
            $data = array('details' => $data);
        } else {
            $data = $this->Mydb->do_search('bizform_candidates', 'candidatesmodel');
            if (empty($data['data_list'])) {
                $message = $this->lang->line('no_result_found');
            }
        }
        $value  = withSuccess($message, $data);
        $this->response($value, REST_Controller::HTTP_OK);
    }



    /**

     * Get All Upload Data from this method.

     *

     * @return Response

    */

    public function response_uploads_get($id = 0)
    {
        $message = "success";
        if (!empty($id)) {
            $data = $this->db->get_where("response_upload", ['id' => $id])->row_array();
            if (empty($data)) {
                $message = $this->lang->line('no_result_found');
            }
            $data = array('details' => $data);
        } else {
            $data = $this->Mydb->do_search('response_upload', 'responseuploadsmodel');
            if (empty($data['data_list'])) {
                $message = $this->lang->line('no_result_found');
            }
        }
        $value  = withSuccess($message, $data);
        $this->response($value, REST_Controller::HTTP_OK);
    }


    /**

     * Get All Data from this method.

     *

     * @return Response

     */

    public function responses_get($id = 0)
    {
        $message = "success";
        if (!empty($id)) {
            $data = $this->db->get_where("responses", ['id' => $id])->row_array();
            if (empty($data)) {
                $message = $this->lang->line('no_result_found');
            }
            $data = array('details' => $data);
        } else {
            $data = $this->Mydb->do_search('candidate_form_lists', 'responsesmodel');
            if (empty($data['data_list'])) {
                $message = $this->lang->line('no_result_found');
            }
        }
        $value  = withSuccess($message, $data);
        $this->response($value, REST_Controller::HTTP_OK);
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
            'name' => ['Name', 'required|max_length[200]'],
            'date' => ['Campaign Date', 'required'],
            'status' => ['Campaign Status', 'required'],
            'created_by' => ['Created By', 'required'],
            // 'form' => ['Form ', 'required']
        ];

        $message = [
            'is_unique' => 'The %s is already exists',
        ];

        Validator::setMessage($message);
        Validator::make($rules);

        if (!Validator::fails()) {
            Validator::error();
        } else {
            // $campaign_list = array();
            // if(!empty($input['form'])){
            //     // $campaign_list['form1'] = $input['form1_id'];
            //     array_push($campaign_list, $input['form1_id']);
            // }
            $data = array(
                'name' => $input['name'],
                'description' => $input['details'],
                'status' => $input['status'],
                'campaign_date' => $input['date'],
                'created_by' => $input['created_by'],
                'created_at' => cur_date_time(),
                // 'form' => $input['form']
            );
            $id = $this->Mydb->insert_table_data('campaigns', $data);
            // if($id>0){
            //     $this->Mydb->insert_table_data('campaigns_list', array('campaign_id'=>$id, 'form_id'=>$input['form']));
            // }
            $result['details'] = $this->Mydb->get_table_data('campaigns', array('id' => $id));
            $value  = withSuccess($this->lang->line('campaign_created_success'), $result);
            $this->response($value, REST_Controller::HTTP_OK);
        }
    }



    /**

     * Delete data from this method.

     *

     * @return Response

     */

    public function index_delete($id)
    {

        $data = $this->db->get_where("bizform_candidates", ['candidate_id' => $id])->row_array();
        $res = $this->Mydb->delete_table_data('bizform_candidates', array('candidate_id' => $id));
        if ($res == 1) {
            $deleteResponses = $this->Mydb->delete_table_data('bizform_candidates', array('candidate_id'=>$id));
            $result = array('details' => $data);
            $value  = withSuccess($this->lang->line('candidate_deleted_success'), $result);
        } else
			if ($res == -1451) {
            $value = withErrors($this->lang->line('failed_to_delete'));
        } else {
            $value = withErrors($this->lang->line('failed_to_delete'));
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }

}
