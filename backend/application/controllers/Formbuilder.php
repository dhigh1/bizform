<?php

require APPPATH . 'libraries/REST_Controller.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Formbuilder extends REST_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model("formbuildermodel", "", true);
		$this->load->library('excelvalidation');
		$this->lang->load('response', 'english');
		$this->table = 'forms';
		$this->model_name = 'formbuildermodel';
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
			$data = $this->db->get_where($this->table, ['id' => $id])->row_array();
			if (empty($data)) {
				$message = $this->lang->line('no_result_found');
			}
			$data = array('details' => $data);
		} else {
			$data = $this->Mydb->do_search('forms', 'formbuildermodel');
			if (empty($data['data_list'])) {
				$message = $this->lang->line('no_result_found');
			}
		}
		$value  = withSuccess($message, $data);
		$this->response($value, REST_Controller::HTTP_OK);
	}


	/**

	 * Get the list of customers from this method.

	 *

	 * @return Response

	 */

	function list_get()
	{
		$message = "success";
		$data = $this->db->get_where("customers")->result_array();
		if (empty($data)) {
			$message = $this->lang->line('no_result_found');
		}
		$data = array('data_list' => $data);
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
			'form_code' => ['Form Code', 'required|is_unique[forms.form_code]'],
			'name' => ['Name', 'required|max_length[200]'],
			'category_id' => ['Category', 'required'],
			// 'description' => ['Description', 'required|max_length[500]'],
			'created_by' => ['Created By', 'required']
		];

		$message = [
			'is_unique' => 'The %s is already exists',
		];
		Validator::setMessage($message);
		Validator::make($rules);

		if (!Validator::fails()) {
			Validator::error();
		} else {
			$data = array(
				'form_code' => createSlug($input['form_code']),
				'name' => $input['name'],
				'category_id' => $input['category_id'],
				'description' => isset($input['description'])?$input['description']:'',
				'created_at' => cur_date_time(),
				'created_by' => $input['created_by'],
				'status' => 78,
			);
			$id = $this->Mydb->insert_table_data($this->table, $data);
			if($id){
				$result = $this->Mydb->get_single_result($id, $this->table, $this->model_name);
				$value  = withSuccess($input['name']. ' Form Created Successfully', $result);
			}else{
				$value=withError('Form Could Not Be Created');
			}
			$this->response($value, REST_Controller::HTTP_OK);
		}
		// $this->table.'_deleted_success'
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

		if (!empty($input['category_id'])) {
			$rules['category_id'] = ['Category', 'required'];
			$data['category_id'] = $input['category_id'];
		}
		if (!empty($input['form_code'])) {
			$rules['form_code'] = ['Form code', 'required|min_length[2]|edit_unique[forms.form_code.id.'.$id.']'];
			$data['form_code'] = underscore_slug($input['form_code']);
		}
		if (!empty($input['name'])) {
			$rules['name'] = ['Name', 'required|min_length[5]|max_length[250]'];
			$data['name'] = $input['name'];
		}
		if (!empty($input['description'])) {
			$rules['description'] = ['Description', 'required|max_length[250]'];
			$data['description'] = $input['description'];
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
		$is_update = $this->Mydb->update_table_data('forms', array('id' => $id), $data);
		$result = $this->Mydb->get_single_result($id, $this->table, $this->model_name);
		if ($is_update > 0) {
			$value  = withSuccess($this->lang->line('form_updated_success'), $result);
		} else {
			$value  = withErrors($this->lang->line('failed_to_update'), $result);
		}
		$this->response($value, REST_Controller::HTTP_OK);
	}


	/**

	 * Update contents from this method.

	 *

	 * @return Response

	 */

	public function contents_put($id = 0)
	{
		$rules = array();
		$data = array();
		$input = $this->put();
		if (!empty($input['html_json'])) {
			$rules['html_json'] = ['HTML JSON', 'required'];
			$data['html_json'] = $input['html_json'];
		}
		if (!empty($input['uploads_json'])) {
			$rules['uploads_json'] = ['Uploads JSON', 'required'];
			$data['uploads_json'] = $input['uploads_json'];
		}
		if (!empty($input['output_html_json'])) {
			$rules['output_html_json'] = ['Output HTML JSON', 'required'];
			$data['output_html_json'] = $input['output_html_json'];
		}
		if (!empty($input['output_uploads_json'])) {
			$rules['output_uploads_json'] = ['Output Uploads JSON', 'required'];
			$data['output_uploads_json'] = $input['output_uploads_json'];
		}
		if (!empty($input['updated_by'])) {
			$data['updated_by'] = $input['updated_by'];
		}

		$data['updated_at'] = cur_date_time();
		$is_update = $this->Mydb->update_table_data('forms', array('id' => $id), $data);

		//$sql = "UPDATE form_templates SET html_json = '$html_json' WHERE id = $id";
		//$query = $this->db->query($sql);
		//$is_update=$id = $this->db->affected_rows();

		//print_r($this->db->last_query());

		$result = $this->Mydb->get_single_result($id, $this->table, $this->model_name);
		if ($is_update > 0) {
			$this->Mydb->update_table_data('forms', array('id'=>$id), array('status'=>77));
			$value  = withSuccess($this->lang->line('service_templates_updated_success'), $result);
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
		if (empty($id)) {
			$value = withErrors('Form ID is required');
			$this->response($value, REST_Controller::HTTP_OK);
		}
		$input = $this->input->get();

		if (empty($input['users_id'])) {
			$value = withErrors('User id is required');
			$this->response($value, REST_Controller::HTTP_OK);
		}

		$data = $this->Mydb->get_single_result($id, $this->table, $this->model_name);
		if (!empty($data)) {
			$res = $this->Mydb->delete_table_data($this->table, array('id' => $id));
			if ($res == 1) {
				// $logData = array(
				// 	'form_id' => $id,
				// 	'created_by' => $input['users_id'],
				// 	'description' => 'Deleted the Form ' . $data['details']['name'] . ' Deleted'
				// );
				// $this->save_check_log($logData); 
				$value  = withSuccess($this->lang->line($this->table . '_deleted_success'), $data);
			} else {
				$value = withErrors($this->lang->line('failed_to_delete'));
			}
		} else {
			$value = withErrors($this->lang->line($this->table . '_not_found'));
		}
		$this->response($value, REST_Controller::HTTP_OK);
	}


	function save_check_log($data)
	{
		$data['created_at'] = cur_date_time();
		$data['ip_address'] = getRealIpAddr();
		$this->Mydb->insert_table_data('workorders_log', $data);
	}
}
