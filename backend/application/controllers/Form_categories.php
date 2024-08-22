<?php

require APPPATH . 'libraries/REST_Controller.php';

class Form_categories extends REST_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model("formcategoriesmodel", "", true);
		$this->lang->load('response', 'english');
		$this->table = 'form_categories';
		$this->model_name = 'formcategoriesmodel';
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
			$data = $this->Mydb->do_search('form_categories', 'formcategoriesmodel');
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
			'name' => ['Categories Name', 'required'],
			'code' => ['Form Code', 'required|is_unique[form_categories.code]'],
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
				'name' => $input['name'],
				'code' => $input['code'],
				'created_at' => cur_date_time(),
				'created_by' => $input['created_by'],
				'status' => 1,
			);
			$id = $this->Mydb->insert_table_data($this->table, $data);
			$result = $this->Mydb->get_single_result($id, $this->table, $this->model_name);
			$value  = withSuccess($this->lang->line('category_created_success'), $result);
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

		if (!empty($input['name'])) {
			$rules['name'] = ['Name', 'required'];
			$data['name'] = $input['name'];
		}
		if (!empty($input['code'])) {
			$rules['code'] = ['Category code', 'required|min_length[2]|edit_unique[form_categories.code.id.'.$id.']'];
			$data['code'] = underscore_slug($input['code']);
		}
		if (!empty($input['updated_by'])) {
			$rules['updated_by'] = ['Updated By', 'required'];
			$data['updated_by'] = $input['updated_by'];
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
		$is_update = $this->Mydb->update_table_data('form_categories', array('id' => $id), $data);
		$result = $this->Mydb->get_single_result($id, $this->table, $this->model_name);
		if ($is_update > 0) {
			$value  = withSuccess($this->lang->line('category_updated_success'), $result);
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
		if (!empty($data['details'])) {
			$check_forms = $this->db->get_where('forms', array('category_id'=>$data['details']['id']));
			if($check_forms->num_rows()>0){
				$value = withErrors('Form Categories Contains more than one forms, cannot delete. Please delete related forms first.');
			}else{
				$res = $this->Mydb->delete_table_data($this->table, array('id' => $id));
				if ($res == 1) {
					$value  = withSuccess($this->lang->line('category_deleted_success'), $data);
				} else {
					$value = withErrors($this->lang->line('failed_to_delete'));
				}
			}
		} else {
			$value = withErrors($this->lang->line($this->table . '_not_found'));
		}
		$this->response($value, REST_Controller::HTTP_OK);
	}


	// function save_check_log($data)
	// {
	// 	$data['created_at'] = cur_date_time();
	// 	$data['ip_address'] = getRealIpAddr();
	// 	$this->Mydb->insert_table_data('workorders_log', $data);
	// }
}
