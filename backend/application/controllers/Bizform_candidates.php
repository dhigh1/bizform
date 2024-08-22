<?php

require APPPATH . 'libraries/REST_Controller.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Bizform_candidates extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("campaignsmodel", "", true);
        $this->load->model("candidatesmodel", "", true);
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


    public function index_post()
    {
        $input = $this->input->post();
        $rules = [
            'candidate_id' => ['Form ID', 'required'],
            'campaign_id' => ['Campaign ID', 'required'],
            'status' => ['Status', 'required']
        ];
        $message = [
            'is_unique' => 'The %s is already exists',
        ];
        Validator::setMessage($message);
        Validator::make($rules);
        if (!Validator::fails()) {
            Validator::error();
        } else {
            $candidate_id = $input['candidate_id'];
            $campaign_id = $input['campaign_id'];
            $status = $input['status'];
            $created_at = cur_date_time();
            $candidate = $this->Mydb->insert_table_data('bizform_candidates', array('campaign_id' => $campaign_id, 'status' => $status, 'created_at' => $created_at));
            if ($candidate > 0) {
                $is_update = $this->Mydb->update_table_data('bizform_candidates', array('id' => $candidate), array('candidate_id' => $candidate_id . '-' . $candidate));
                if ($is_update > 0) {
                    $get_candidate = $this->db->get_where('bizform_candidates', array('id' => $candidate))->row_array();
                    $value = withSuccess($get_candidate, '');
                } else {
                    $value = withErrors('Something Went Wrong');
                }
            } else {
                $value = withErrors('Something Went Wrong', '');
            }
            $this->response($value, REST_Controller::HTTP_OK);
        }
    }

    

    public function analytics_get($id){
        $data = $this->db->query("select * from bizform_candidates WHERE campaign_id='$id'")->result_array();
        if(!empty($data)){
            $total_pending_links = 0;
            $total_opened_links = count($data);
            $completed_links = 0;
            foreach($data as $d){
                if($d['status']==76){
                    $completed_links++;
                }
            }
            if($total_opened_links>0 && $completed_links>0){
                $total_pending_links = $total_opened_links - $completed_links;
            }
            $value = withSuccess('Data Fetched Successfully', array('details'=>array('total_opened_links'=>$total_opened_links, 'total_pending_links'=>$total_pending_links, 'total_completed_links'=>$completed_links)));
        }else{
            $value = withErrors('No Data Found');
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }
}
