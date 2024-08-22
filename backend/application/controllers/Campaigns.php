<?php

require APPPATH . 'libraries/REST_Controller.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Campaigns extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("campaignsmodel", "", true);
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
            $data = $this->db->get_where("campaigns", ['id' => $id])->row_array();
            if (empty($data)) {
                $message = $this->lang->line('no_result_found');
            }
            $data = array('details' => $data);
        } else {
            $data = $this->Mydb->do_search('campaigns', 'campaignsmodel');
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

    public function campaign_detail($id = 0)
    {
        $message = "success";
        if (!empty($id)) {
            $data = $this->db->get_where("campaigns", ['id' => $id])->row_array();
            if (empty($data)) {
                $message = $this->lang->line('no_result_found');
            }
            $data = array('details' => $data);
        } else {
            $data = $this->Mydb->do_search('campaigns', 'campaignsmodel');
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
            // 'name' => ['Name', 'required|max_length[200]|is_unique[campaigns.name]'],
			'name' => ['Name','required|min_length[3]|max_length[200]|is_unique[campaigns.name]'],
            // 'date' => ['Campaign Date', 'required'],
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
            $status = '';
            $data = array(
                'name' => $input['name'],
                'description' => $input['details'],
                'created_by' => $input['created_by'],
                'created_at' => cur_date_time(),
                'url' => $input['url'],
                'status'=>79
            );
            $id = $this->Mydb->insert_table_data('campaigns', $data);
            if($id>0){
                $result['details'] = $this->db->get_where('campaigns', array('id' => $id))->row_array();
                $create_form_lists = $this->multi_forms($id, $input['forms']);
                if($create_form_lists['status']=='success'){
                    $value  = withSuccess($this->lang->line('campaign_created_success'), $result);
                }else{
                    $this->Mydb->delete_table_data('campaigns', array('id'=>$id));
                    $value  = withErrors('Campaign Could Not Be Created', $result);
                }
            }else{
                $value = withErrors('Campaign Could Not Be Created');
            }
            $this->response($value, REST_Controller::HTTP_OK);
        }
    }

    /**

     * Update data from this method.

     *

     * @return Response

     */

    public function index_put($id)
    {
        $rules = array();
        $data = array();
        $input = $this->put();
        if (!empty($input['name'])) {
            $rules['name'] = ['Name', 'required|min_length[3]|max_length[200]|is_unique[campaigns.name]'];
            $data['name'] = $input['name'];
        }
        if (!empty($input['details'])) {
            $rules['details'] = ['Description', 'required'];
            $data['description'] = $input['details'];
        }
        // if (!empty($input['date'])) {
        //     $rules['date'] = ['Campaign Date', 'required'];
        //     $data['campaign_date'] = $input['date'];
        // }
        if (!empty($input['url'])) {
            $rules['url'] = ['Campaign URL', 'required'];
            $data['url'] = $input['url'];
        }
        if (!empty($input['updated_by'])) {
            $rules['updated_by'] = ['Updated By', 'required'];
            $data['updated_by'] = $input['updated_by'];
        }
        if (!empty($input['status'])) {
            $rules['status'] = ['Status', 'required|numeric'];
            $data['status'] = $input['status'];
        }
        $message = [
            'edit_unique' => 'The %s is already exists',
        ];

        Validator::setMessage($message);

        if (array_filter($input)) {
            if (!empty($rules)) {
                Validator::make($rules);
            }
            if (!Validator::fails()) {
                Validator::error();
            }
        }
        $data['updated_at'] = cur_date_time();
        // print_r($data);exit();
        $is_update = $this->Mydb->update_table_data('campaigns', array('id' => $id), $data);
        $result['details'] = $this->db->get_where('campaigns', array('id' => $id))->row_array();
        if ($is_update > 0) {
            $value  = withSuccess($this->lang->line('campaign_updated_success'), $result);
            $delete = $this->Mydb->delete_table_data('campaigns_list', array('campaign_id'=>$id));
            $create_form_lists = $this->multi_forms($id, $input['forms'], 'update');
        } else {
            $value  = withErrors($this->lang->line('failed_to_update'), $result);
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }



    /**

     * Delete data from this method.

     *

     * @return Response

     */

    public function index_delete($id)
    {

        $data = $this->db->get_where("campaigns", ['id' => $id])->row_array();
        $res = $this->Mydb->delete_table_data('campaigns', array('id' => $id));
        if ($res == 1) {
            $this->Mydb->delete_table_data('campaigns_list', array('campaign_id'=>$id));
            $this->Mydb->delete_table_data('bizform_candidates', array('campaign_id'=>$id));
            $this->Mydb->delete_table_data('candidate_form_lists', array('campaign_id'=>$id));
            $result = array('details' => $data);
            $value  = withSuccess($this->lang->line('campaign_deleted_success'), $result);
        } else
			if ($res == -1451) {
            $value = withErrors($this->lang->line('failed_to_delete'));
        } else {
            $value = withErrors($this->lang->line('failed_to_delete'));
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }

    /**

     * Get response List of the campaign opened.

     *

     * @return Response

     */
    public function response_get($id)
    {
        $details = array();
        if (empty($id)) {
            $value = withErrors('ID is required');
        } else { 
            $rows_left = $this->db->query("select * from candidate_form_lists where candidate_id = '$id' AND status=75")->num_rows();
            if ($rows_left > 0) {
                $details['pending_row'] = $rows_left;
                $q = "SELECT * FROM candidate_form_lists WHERE candidate_id= '$id' AND status = 75 ORDER BY template_order, status ASC LIMIT 1";
                $query = $this->db->query($q);
                $result = $query->row_array();
                if (empty($result['form_id'])) {
                    $value = withErrors('Something went wrong');
                } else {
                    $details['pending_row'] = $rows_left;
                    $details['response_row'] = $result;
                    $details['form_data'] = $this->db->get_where('forms', array('id' => $result['form_id']))->row_array();
                    $details['status']=$result['status'];
                    if (!empty($details)) {
                        $value = withSuccess('Data Fetched Successfully', array('details'=>$details));
                    } else {
                        $value = withErrors('Something went wrong2');
                    }
                }
            } else {
                $q = $this->Mydb->update_table_data('bizform_candidates', array('candidate_id' => $id), array('status' => 76, 'updated_at'=>cur_date_time()));
                $details['pending_row'] = $rows_left;
                $details['response_row'] = '';
                $details['form_data'] = '';
                $details['status'] = '';
                $value = withSuccess('Data Fetched Successfully', array('details'=>$details));
            }
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }



    /**

     * Create response of the forms opened.

     *

     * @return Response

     */

    public function response_put()
    {
        $rules = array();
        $data = array();
        $input = $this->put();
        if (!empty($input['fields_json'])) {
            $rules['fields_json'] = ['Form JSON', 'required'];
            $data['output_json'] = $input['fields_json'];
        }
        if (!empty($input['response_row'])) {
            $rules['response_row'] = ['Response Row', 'required'];
        }
        if (!empty($input['updated_by'])) {
            $rules['updated_by'] = ['Updated By', 'required'];
            $data['updated_by'] = $input['updated_by'];
        }
        if (!empty($input['status'])) {
            $rules['status'] = ['Status', 'required'];
            $data['status'] = $input['status'];
        }
        $message = [
            'edit_unique' => 'The %s is already exists',
        ];

        Validator::setMessage($message);

        if (array_filter($input)) {
            if (!empty($rules)) {
                Validator::make($rules);
            }
            if (!Validator::fails()) {
                Validator::error();
            }
        }
        $data['updated_at'] = cur_date_time();
        $get_data = $this->db->get_where('candidate_form_lists', array('id' => $input['response_row']))->row_array();
        if (!empty($get_data)) {
            $is_update = $this->Mydb->update_table_data('candidate_form_lists', array('id' => $get_data['id']), $data);
            // $q = $this->db->last_query();
            $result['details'] = $this->Mydb->get_table_data('candidate_form_lists', array('id' => $get_data['id']));
            if ($is_update > 0) {
                $value  = withSuccess($this->lang->line('form_submit_success'), '');
            } else {
                $value  = withErrors($this->lang->line('form_submit_fail'), $result);
            }
        } else {
            $value = withErrors($this->lang->line($this->table . '_not_found'));
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }

    /**

     * Create response of the forms opened.

     *

     * @return Response

     */

    public function response_post()
    {
        $input = $this->input->post();
        $rules = [
            'campaign_id' => ['Campaign Date', 'required'],
            'status' => ['Campaign Status', 'required'],
        ];
        $message = [
            'is_unique' => 'The %s is already exists',
        ];
        Validator::setMessage($message);
        Validator::make($rules);
        if (!Validator::fails()) {
            Validator::error();
        } else {
            $res = 1;
            $user_id = '';
            $templates = json_decode($input['templates'], true);
            foreach ($templates as $template) {
                $data = array(
                    'campaign_id' => $input['campaign_id'],
                    'status' => $input['status'],
                    'form_id' => $template['form_id'],
                    'candidate_id' => $input['candidates_id'],
                    'template_order' => $template['order'],
                    'created_at' => cur_date_time()
                );
                $id = $this->Mydb->insert_table_data('candidate_form_lists', $data);
                $res *= $id;
            }
            if ($id) {
                $result['details'] = array('user_code' => $input['candidate_id']);
                $value = withSuccess('Response user Created successfully', $result);
            } else {
                $value = withErrors('Something Went Wrong', '');
            }
            $this->response($value, REST_Controller::HTTP_OK);
        }
    }

    /**

     * Delete response of the forms opened.

     *

     * @return Response

     */
    public function response_delete($id)
    {
        if (empty($id)) {
            $value = withErrors('User ID is required');
            $this->response($value, REST_Controller::HTTP_OK);
        }

        $data = $this->db->get_where('bizform_candidates', array('candidate_id' => $id))->row_array();
        if (!empty($data)) {
            $res = $this->Mydb->delete_table_data('candidate_form_lists', array('candidate_id' => $id));
            if ($res>0) {
                $deleteCandidate = $this->Mydb->delete_table_data('bizform_candidates', array('candidate_id'=>$id));

                $value  = withSuccess($this->lang->line('form_deleted_success'), $data);
            } else {
                $value = withErrors($this->lang->line('failed_to_delete'));
            }
        } else {
            $value = withErrors($this->lang->line($this->table . '_not_found'));
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }


    public function upload_file_post()
    {
        $input = $this->input->post();
        $rules = [
            'campaign_name' => ['Campaign Name', 'required'],
            'campaign_id' => ['Campaign ID', 'required'],
            'form_id' => ['Form ID', 'required'],
            'candidate_id' => ['Candidate ID', 'required'],
            'row_id' => ['Response ID', 'required'],
            'file_name' => ['File Name', 'required'],
            'file_size' => ['File Size', 'required'],
            'file_ext' => ['File Extension', 'required'],
            'file_path' => ['File Path', 'required'],
            'ip_address' => ['IP Address', 'required'],
            'uploaded_at' => ['Uploaded Date', 'required']
        ];
        $message = [
            'is_unique' => 'The %s is already exists',
        ];
        Validator::setMessage($message);
        Validator::make($rules);
        if (!Validator::fails()) {
            Validator::error();
        } else {
            $check = array(
                'campaign_name' => $input['campaign_name'],
                'campaign_id' => $input['campaign_id'],
                'form_id' => $input['form_id'],
                'candidate_id' => $input['candidate_id'],
                'row_id' => $input['row_id'],
                'input_name' => $input['input_name'],
            );
            $data = array(
                'campaign_name' => $input['campaign_name'],
                'campaign_id' => $input['campaign_id'],
                'form_id' => $input['form_id'],
                'candidate_id' => $input['candidate_id'],
                'row_id' => $input['row_id'],
                'input_name' => $input['input_name'],
                'file_name' => $input['file_name'],
                'file_size' => $input['file_size'],
                'file_ext' => $input['file_ext'],
                'file_path' => $input['file_path'],
                'ip_address' => $input['ip_address'],
                'uploaded_at' => $input['uploaded_at']
            );
            $check_data = $this->Mydb->get_table_data('response_upload', $check);
            if (empty($check_data)) {
                $id = $this->Mydb->insert_table_data('response_upload', $data);
                $result['details'] = $this->Mydb->get_table_data('response_upload', array('id' => $id));
                $value  = withSuccess($this->lang->line('uploads_success'), $result);
            } else {
                $this->Mydb->delete_table_data('response_upload', $check);
                $id = $this->Mydb->insert_table_data('response_upload', $data);
                $result['details'] = $this->Mydb->get_table_data('response_upload', array('id' => $id));
                $value  = withSuccess($this->lang->line('uploads_success'), $result);
            }
            $this->response($value, REST_Controller::HTTP_OK);
        }
    }



    /**

     * Save Multiple Forms from this method.

     *

     * @return Response

     */

    public function multi_forms($campaign_id, $forms, $type='create')
    {
        $ids = json_decode($forms, true);
        $res_ids = array();
        $i = 0;
        foreach ($ids as $id) {
            $data = array(
                'template_order' => $i,
                'campaign_id' => $campaign_id,
                'form_id' => $id,
                'status' => 1,
                'created_at' => cur_date_time(),
                'created_by' => $this->input->post('created_by'),
            );
            $id = $this->Mydb->insert_table_data('campaigns_list', $data);
            if ($id > 0) {
                array_push($res_ids, $id);
            } else {
                $value  = withErrors('Something Went Wrong. Try again');
                return $value;
            }
            $i++;
        }
        if (!empty($res_ids)) {
            $value  = withSuccess($this->lang->line('campaign_created_success'));
            return $value;
        } else {
            $value = withErrors('Something went wrong');
            return $value;
        }
    }


    public function campaign_list_get($id)
    {
        // print_R($id);
        // exit();
        // print_R("HERE");exit();
        if (empty($id)) {
            $value = withErrors('Campaign ID cannot be empty');
        }
        $result = $this->db->get_where('campaigns_list', array('campaign_id' => $id))->result_array();
        // print_r($result);
        // exit();
        $ids = array();
        foreach ($result as $res) {
            array_push($ids, array('form_id' => $res['form_id'], 'order' => $res['template_order']));
        }
        if (!empty($result)) {
            $value  = withSuccess('Data Fetched Successfully', array('details'=>$ids));
        } else {
            $value = withErrors('Something went wrong');
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }

    public function delete_campaign_template_post()
    {
        $input = $this->input->post();
        $rules = [
            'id' => ['Form ID', 'required'],
            'c_id' => ['Campaign ID', 'required'],
        ];
        $message = [
            'is_unique' => 'The %s is already exists',
        ];
        Validator::setMessage($message);
        Validator::make($rules);
        if (!Validator::fails()) {
            Validator::error();
        } else {
            $form_id = $input['id'];
            $campaign_id = $input['c_id'];
            $get_data = $this->db->get_where('campaigns_list', array('form_id' => $form_id, 'campaign_id' => $campaign_id))->row_array();
            if (!empty($get_data)) {
                $delete_row = $this->db->delete('campaigns_list', array('campaign_id' => $input['c_id'], 'form_id' => $form_id));
                if ($delete_row > 0) {
                    $value = withSuccess(' Deleted Successfully', $get_data);
                } else {
                    $value = withErrors('Something Went Wrong', '');
                }
            } else {
                $value = withErrors('Unknown Campaign List');
            }
            $this->response($value, REST_Controller::HTTP_OK);
        }
    }

    public function create_candidate_post()
    {
        $input = $this->input->post();
        // print_r($input);exit();
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
            $candidate = $this->Mydb->insert_table_data('bizform_candidates', array('campaign_id' => $campaign_id, 'status' => $status, 'created_at' => $created_at, 'candidate_id'=>$candidate_id));
            if ($candidate > 0) {
                    $get_candidate = $this->db->get_where('bizform_candidates', array('id' => $candidate))->row_array();
                    $value = withSuccess('Candidate Created Successfully', array('details'=>$get_candidate));
            } else {
                $value = withErrors('Something Went Wrong', '');
            }
            $this->response($value, REST_Controller::HTTP_OK);
        }
    }

    public function cancel_candidate_put($id){
        $q = $this->db->get_where('bizform_candidates', array('candidate_id'=>$id));
        if($q->num_rows()>0){
            $result = $q->row_array();
            $campaign_id = $result['campaign_id'];
            $campaignQ = $this->db->get_where('campaigns', array('id'=>$campaign_id));
            if($campaignQ->num_rows()>0){
                $cancelCase = $this->db->update('bizform_candidates', array('status'=>'82'), array('candidate_id'=>$id));
                // print_R($cancelCase);
                // echo "<hr>";
                // print_r($this->db->last_query());
                // exit();
                $candidateData = $this->db->get_where('bizform_candidates', array('candidate_id'=>$id))->row_array();
                if($cancelCase){
                    $value = withSuccess('Cancelled Successfully', array('details'=>$candidateData));
                }else{
                    $value = withErrors('Case Canecllation Failed', array('details'=>$candidateData));
                }
            }else{
                $value = withErrors('Case Canecllation Failed');
            }
        }else{
            $value = withErrors('Case Canecllation Failed');
        }
        $this->response($value, REST_Controller::HTTP_OK);
        return;
    }
}
