<?php

require APPPATH . 'libraries/REST_Controller.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'workorder_profiles_checks';
        $this->load->database();
        $this->model_name = 'report_model';
        $this->load->model($this->model_name, "", true);
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
        $data = array();
        if (!empty($id)) {
            $data = $this->Mydb->get_single_result($id, $this->table, $this->model_name);
        } else {
            $data = $this->Mydb->do_search($this->table, $this->model_name);
        }
        if (!empty($data)) {
            $value  = withSuccess($message, $data);
        } else {
            $value  = withSuccess($this->lang->line('no_result_found'));
        }

        $this->response($value, REST_Controller::HTTP_OK);
    }

    public function download_report_get()
    {
        $message = "success";
        $data = array();

        $inputs=$this->input->get();
        $rows = $this->Mydb->do_search($this->table, $this->model_name, 'true');
        $arr = [];
        foreach($rows['data_list'] as $object){
            array_push($arr, json_encode($object, true));
        }
        $datas = [];
        foreach($arr as $ar){
            array_push($datas, json_decode($ar, true));
        }
        if (!empty($datas)) {
            $presentDate = date('d_m_Y_h_i_s_A');
            $file_name    = "template" . $presentDate . ".xlsx";
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Check ID')->getColumnDimension('A')->setWidth(30);
            $sheet->setCellValue('B1', 'Vendor Check ID')->getColumnDimension('B')->setWidth(20);
            $sheet->setCellValue('C1', 'Profile Name')->getColumnDimension('C')->setWidth(20);
            $sheet->setCellValue('D1', 'Check Name')->getColumnDimension('D')->setWidth(25);
            $sheet->setCellValue('E1', 'Customer Name')->getColumnDimension('E')->setWidth(25);
            $sheet->setCellValue('F1', 'Customer Branches Name')->getColumnDimension('F')->setWidth(25);
            $sheet->setCellValue('G1', 'Contact Person Name')->getColumnDimension('G')->setWidth(25);
            $sheet->setCellValue('H1', 'TAT Time(in hours)')->getColumnDimension('H')->setWidth(15);
            $sheet->setCellValue('I1', 'Status Name')->getColumnDimension('I')->setWidth(15);
            $sheet->setCellValue('J1', ucwords(str_replace('_',' ',$inputs['datetype'])))->getColumnDimension('K')->setWidth(15);
            if (!empty($datas)) {
                $count = 2;
                foreach ($datas as $row) {
                    $sheet->setCellValue('A' . $count, $row['code']);
                    $sheet->setCellValue('B'.$count, $row['vendor_check_id']);
                    $sheet->setCellValue('C' . $count, $row['workorders_profiles_name']);
                    $sheet->setCellValue('D' . $count, $row['services_name']);
                    $sheet->setCellValue('E' . $count, $row['customers_name']);
                    $sheet->setCellValue('F' . $count, $row['customer_branches_name']);
                    $sheet->setCellValue('G' .$count, $row['contact_person_name']);
                    $sheet->setCellValue('H' . $count, $row['tat_time']);
                    $sheet->setCellValue('I' . $count, $row['status_name']);
                    $sheet->setCellValue('J' . $count, custom_date('d-m-Y h:i A',$row['date_value']));
                    $count++;
                }
            }
            $writer = new Xlsx($spreadsheet);
            $filePath = 'reports/reports/templates' . $file_name;
            $writer->save($filePath);
            $res =  array(
                'filename' => $file_name,
                'url' => base_url() . $filePath
            );
            $result = array('details' => $res);
            
            $value = withSuccess($this->lang->line('Report downloaded'), $result);
        } else {
            $value = withErrors($this->lang->line('no_result_found'));
        }
        $this->response($value, REST_Controller::HTTP_OK);
    }
}
