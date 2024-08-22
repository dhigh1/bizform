<?php

require APPPATH . 'libraries/REST_Controller.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Publish extends REST_Controller
{




	public function __construct()
	{

		parent::__construct();

		$this->load->database();
		$this->load->model("publishmodel", "", true);
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
			$data = $this->db->get_where("customers", ['id' => $id])->row_array();
			if (empty($data)) {
				$message = $this->lang->line('no_result_found');
			}
			$data = array('details' => $data);
		} else {
			$data = $this->Mydb->do_search('customers', 'customersmodel');
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
		//print_r($input);
		$rules = [
			'customer_code' => ['Customer Code', 'required|max_length[7]|is_unique[customers.customer_code]'],
			'name' => ['Name', 'required|max_length[200]'],
			'email' => ['Email', 'required|valid_email|max_length[120]'],
			'phone' => ['Phone', 'required|max_length[20]|min_length[5]'],
			'address' => ['Address', 'required|max_length[500]|min_length[10]']
		];

		$message = [
			'is_unique' => 'The %s is already exists',
		];
		Validator::setMessage($message);
		Validator::make($rules);

		//print_r(Validator::fails());
		if (!Validator::fails()) {
			Validator::error();
		} else {
			$data = array(
				'customer_code' => createSlug($input['customer_code']),
				'name' => $input['name'],
				'email' => $input['email'],
				'phone' => $input['phone'],
				'address' => $input['address'],
				'created_at' => cur_date_time(),
				'created_by' => $input['created_by'],
				'status' => 18,
			);
			if (!empty($input['docx_report_id'])) {
				$data['docx_report_id'] = $input['docx_report_id'];
			}
			if (!empty($input['pdf_report_id'])) {
				$data['pdf_report_id'] = $input['pdf_report_id'];
			}
			$id = $this->Mydb->insert_table_data('customers', $data);
			$result['details'] = $this->Mydb->get_table_data('customers', array('id' => $id));
			$value  = withSuccess($this->lang->line('customer_created_success'), $result);
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

		if (!empty($input['customer_code'])) {
			$rules['customer_code'] = ['Customer code', 'required|max_length[7]|edit_unique[customers.customer_code.id.' . $id . ']'];
			$data['customer_code'] = createSlug($input['customer_code']);
		}
		if (!empty($input['name'])) {
			$rules['name'] = ['Name', 'required|min_length[3]|max_length[200]'];
			$data['name'] = $input['name'];
		}
		if (!empty($input['email'])) {
			$rules['email'] = ['Email', 'required|valid_email|min_length[3]|max_length[200]'];
			$data['email'] = $input['email'];
		}
		if (!empty($input['phone'])) {
			$rules['phone'] = ['Phone', 'required|min_length[10]|max_length[15]'];
			$data['phone'] = $input['phone'];
		}
		if (!empty($input['address'])) {
			$rules['address'] = ['Address', 'required|min_length[5]|max_length[300]'];
			$data['address'] = $input['address'];
		}
		if (!empty($input['updated_by'])) {
			$data['updated_by'] = $input['updated_by'];
		}
		if (!empty($input['status'])) {
			$data['status'] = $input['status'];
		}
		if (!empty($input['docx_report_id'])) {
			$data['docx_report_id'] = $input['docx_report_id'];
		}
		if (!empty($input['pdf_report_id'])) {
			$data['pdf_report_id'] = $input['pdf_report_id'];
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

		$is_update = $this->Mydb->update_table_data('customers', array('id' => $id), $data);
		$result['details'] = $this->Mydb->get_table_data('customers', array('id' => $id));
		if ($is_update > 0) {
			$value  = withSuccess($this->lang->line('customer_updated_success'), $result);
		} else {
			$value  = withErrors($this->lang->line('failed_to_update'), $result);
		}
		$this->response($value, REST_Controller::HTTP_OK);
	}

	/**

	 * Import data from  file using this method.

	 *

	 * @return Response

	 */


	public function import_post()
	{
		$input = $this->post();
		//$rules = [
		//'file_path' => ['Excel File','required'],
		//'created_by' => ['Created By','required|numeric']
		//];
		//Validator::make($rules);
		//if (!Validator::fails()){
		//  Validator::error();
		//}else{
		$excel_validation = new Excelvalidation();

		if (isset($input['file_path'])) {
			if (file_exists($input['file_path'])) {
				$file = $input['file_path'];
				$ext_array = array(
					'xlsx',
					'xls'
				);
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				if (in_array($ext, $ext_array)) {
					$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					$spreadsheet 	= $reader->load($file);
					$this->db->trans_begin();
					$data         = array();
					$count        = 0;
					$update_count = 0;
					$sheetCount = 0;
					$overwrite = 'no';
					// $data['created_by'] = 0;
					$duplicate_data = array();
					$update_data = array();
					$vntype_data = array();
					$colum_heading = array('Name', 'Email',);
					$get_excel_heading = $excel_validation->get_excel_heading($spreadsheet);
					$check_excel_heading = $excel_validation->check_excel_heading($colum_heading, $get_excel_heading);

					if (!empty($check_excel_heading)) {
						$excel_validation->excelheading_error();
					}

					if (isset($input['overwrite'])) {
						$overwrite = $input['overwrite'];
					}
					$excelSheet = $spreadsheet->getActiveSheet();
					$spreadSheetAry = $excelSheet->toArray();
					$sheetCount = count($spreadSheetAry);
					$q = array();
					for ($i = 1; $i <= $sheetCount - 1; $i++) {
						$data['name'] = $spreadSheetAry[$i][0];
						$data['email'] = $spreadSheetAry[$i][1];
						$data['phone'] = $spreadSheetAry[$i][2];
						$check_user = $this->publishmodel->check_duplicate_candidates($data);
						if ($check_user<1) {
							$data['created_at'] = cur_date_time();
							if (isset($input['created_by'])) {
								$data['created_by'] = $input['created_by'];
							}
							$res_id = $this->Mydb->insert_table_data('candidates', $data);
							++$count;
							$q[$res_id] = $this->db->last_query();
						} else {
							$dup_data = '{' . $data['name'] . ' - ' . $data['email'] . '}<br/>';
							array_push($duplicate_data, $dup_data);
							if ($overwrite == 'yes') {
								$data['updated_by'] = $data['created_by'];
								$data['updated_at'] = cur_date_time();
								$res_id = $this->Mydb->update_table_data('candidates', array('id' => $check_user['id']), $data);
								++$update_count;
							}
						}
					}
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$value = withErrors($this->lang->line('excel_upload_error'));
					} else {
						$this->db->trans_commit();
						$msg = "";
						$msg .= "Total number of candidates found in uploaded file: " . ($sheetCount - 1) . "<br/>Number of vendors added: " . $count . '<br/>';
						if (!empty($duplicate_data) && $update_count == 0) {
							$msg .= "Number of Candidates skipped: " . count($duplicate_data) . "<br/>";
						}
						if ($update_count > 0) {
							$msg .= "Number of Candidates updated: " . $update_count . "<br/>";
						}
						if (!empty($duplicate_data) && $update_count == 0) {
							$msg .= $excel_validation->add_index_error($duplicate_data, $this->lang->line('duplicate_vendors_data'));
						}
						if (!empty($duplicate_data) && $update_count > 0) {
							$msg .= $excel_validation->add_index_error($duplicate_data, 'Duplicate Candidates updated');
						}
						if (!empty($vntype_data)) {
							$msg .= $excel_validation->add_index_error($vntype_data, $this->lang->line('unknown_vendor_type'));
						}
						$value = withSuccess($msg);
					}
					$this->response($value, REST_Controller::HTTP_OK);
				} else {
					$value = withErrors("Only xlsx, xls extension file accepted!!!");
					$this->response($value, REST_Controller::HTTP_OK);
				}
			} else {
				$value = withErrors("File doesn't exists in the specified folder");
				$this->response($value, REST_Controller::HTTP_OK);
			}
		} else {
			$value = withErrors("Please provide the file path");
			$this->response($value, REST_Controller::HTTP_OK);
		}
		//}
	}


	/**

	 * Delete data from this method.

	 *

	 * @return Response

	 */

	public function index_delete($id)
	{
		$p_data = $this->db->get_where("customer_branches", ['customers_id' => $id])->num_rows();
		if ($p_data == 0) {
			$data = $this->db->get_where("customers", ['id' => $id])->row_array();
			$res = $this->Mydb->delete_table_data('customers', array('id' => $id));
			if ($res == 1) {
				$result = array('details' => $data);
				$value  = withSuccess($this->lang->line('customer_deleted_success'), $result);
			} else
			if ($res == -1451) {
				$value = withErrors($this->lang->line('failed_to_delete'));
			} else {
				$value = withErrors($this->lang->line('failed_to_delete'));
			}
		} else {
			$value = withErrors($this->lang->line('customer_has_branch'));
		}

		$this->response($value, REST_Controller::HTTP_OK);
	}
}
