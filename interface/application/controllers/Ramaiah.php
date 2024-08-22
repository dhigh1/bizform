<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ramaiah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        User::check_session();
        $this->load->library('../controllers/template');
        $this->view_path = "users/ramaiah/";
        $this->script_path = $this->view_path . "script/";
        $this->style_path = $this->view_path . "style/";
        $this->module_name = "ramaiah";
        // $this->module_name="service_templates";
        $this->main_key = "name";
        $this->userId = User::get_userId();
    }

    public function index()
    {
        $data = array();
        $data['title'] = "Ramaiah Capital";
        $data['filter_view'] =  $this->load->view($this->view_path . "filter_view", $data, true);
        $data['content_view'] =  $this->load->view($this->view_path . "main_view", $data, true);
        $data['script'] =  $this->load->view($this->script_path . "script", '', true);
        $data['style'] =  $this->load->view($this->style_path . "style", '', true);
        $this->template->user_template($data);
    }


    public function create()
    {
        $course_id = isset($_POST['course_id']) ? $_POST['course_id'] : '';
        $course_type = isset($_POST['course_type']) ? $_POST['course_type'] : '';
        $sem_id = isset($_POST['sem_id']) ? $_POST['sem_id'] : '';
        $message = '';
        $status = 'fail';
        $students = $this->db->get_where('students_ug', array('course_id' => $course_id, 'course_type' => $course_type, 'sem_id' => $sem_id))->result_array();
        $fee_data = json_encode(array(
            'amount' => 80000,
            'due_date' => '29-11-2022',
            'due_date_1_fee' => 1000,
            'enable_at' => cur_date_time()
        ));
        $created = 1;
        if (!empty($students)) {
            $this->db->trans_start();
            foreach ($students as $student) {
                if (!empty($student['payment_data'])) {
                    $data = array(
                        'studentId' => $student['studentId'],
                        'course_id' => $student['course_id'],
                        'course_type' => $student['course_type'],
                        'sem_id' => $student['sem_id'],
                        'sem_status' => 0,
                        'pay_status' => 1,
                        'payment_data' => json_encode($fee_data),
                        'created_at' => cur_date_time(),
                        'updated_at' => cur_date_time(),
                        'created_by' => User::get_userId(),
                        'updated_by' => User::get_userId()
                    );
                    $create = $this->db->insert('student_ug', $data);
                }
            }
            if ($this->db->trans_status() === FALSE) {
                $message = 'Something went wrong';
                $this->db->trans_rollback();
            } 
            else {
                $this->db->trans_commit();
                $status = 'success';
                $message = 'Inserted Successfully';
            }
        } else {
            $message = 'Unable to proceed';
        }
        $value = array('status' => $status, 'message' => $message);
        echo json_encode($value);
    }

    // function save_sem_status()
    // {

    //     $inputs = $this->input->post();

    //     $this->form_validation->set_error_delimiters('<label class="invalid-feedback">', '</label>');
    //     $this->form_validation->set_rules('amount', 'Fee Amount', 'required|numeric');
    //     $this->fo;
    //     rm_validation->set_rules('due_date_1', 'Due Date', 'required');
    //     $this->form_validation->set_rules('due_date_1_fee', 'Due Date Fine', 'required|numeric');
    //     if (!empty($inputs['due_date_2'])) {
    //         $this->form_validation->set_rules('due_date_2_fee', '2nd Due Date Fine', 'numeric|required');
    //     }
    //     if (!empty($inputs['due_date_2_fee'])) {
    //         $this->form_validation->set_rules('due_date_2', '2nd Due Date', 'required');
    //     }

    //     if (!empty($inputs['pay_status'])) {
    //         $this->form_validation->set_rules('payment_id', 'Payment ID', 'required');
    //         $this->form_validation->set_rules('paid_amount', 'Paid Payment', 'required');
    //         $this->form_validation->set_rules('paid_at', 'Paid Date', 'required');
    //     }

    //     if ($this->form_validation->run() == FALSE) {
    //         form_validation_error();
    //     } else {

    //         $get_student = $this->semester_model->get_candidate_details($inputs['studentId'], $this->course_type);
    //         if (!empty($get_student)) {

    //             $enable_data = array();
    //             $fields = array('amount', 'due_date_1', 'due_date_1_fee', 'due_date_2', 'due_date_2_fee');
    //             foreach ($fields as $field_name) {
    //                 if (isset($_POST[$field_name]) && !empty($inputs[$field_name])) {
    //                     $enable_data[$field_name] = $inputs[$field_name];
    //                 }
    //             }
    //             $enable_data['enable_at'] = cur_date_time();

    //             $payment_data = array();
    //             $payment_fields = array('pay_status', 'payment_id', 'paid_amount', 'paid_at');
    //             foreach ($payment_fields as $pay_field) {
    //                 if (isset($_POST[$pay_field]) && !empty($inputs[$pay_field])) {
    //                     $payment_data[$pay_field] = $inputs[$pay_field];
    //                 }
    //             }

    //             $data = array(
    //                 'studentId' => $inputs['studentId'],
    //                 'course_id' => $get_student['course_id'],
    //                 'course_type' => $this->course_type,
    //                 'sem_id' => $inputs['sem_id'],
    //                 'sem_status' => 0,
    //                 'pay_status' => 0,
    //                 'enable_data' => json_encode($enable_data),
    //                 'created_at' => cur_date_time(),
    //                 'updated_at' => cur_date_time(),
    //                 'created_by' => User::get_userId(),
    //                 'updated_by' => User::get_userId()
    //             );
    //             $cur_sem_status = 0;
    //             $description = '';
    //             $send_email = false;

    //             if (!empty($payment_data) && !empty($inputs['pay_status'])) {
    //                 $data['sem_status'] = 1;
    //                 $data['pay_status'] = 1;
    //                 $payment_data['pay_status_by'] = 'Backend Team';
    //                 $data['payment_data'] = json_encode($payment_data);
    //             }
    //             $where = array('studentId' => $inputs['studentId'], 'course_id' => $get_student['course_id'], 'course_type' => $this->course_type, 'sem_id' => $inputs['sem_id']);
    //             $get_sem = $this->db->get_where($this->sem_table, $where)->row_array();
    //             if (!empty($get_sem)) {
    //                 unset($inputs['created_at']);
    //                 unset($inputs['created_by']);
    //                 $db_sem = $this->Mydb->update_table_data($this->sem_table, $where, $data);

    //                 $description = 'Updated the ' . ordinal($inputs['sem_id']) . ' sem details';
    //             } else {
    //                 unset($inputs['updated_at']);
    //                 unset($inputs['updated_by']);
    //                 $db_sem = $this->Mydb->insert_table_data($this->sem_table, $data);

    //                 $description = 'Enabled the ' . ordinal($inputs['sem_id']) . ' sem as pass & enabled to pay the fees';
    //             }
    //             // print_r($this->db->last_query());
    //             if ($db_sem > 0) {
    //                 $student_data = array(
    //                     'cur_sem' => $inputs['sem_id'],
    //                     'cur_sem_status' => $cur_sem_status
    //                 );
    //                 $this->Mydb->update_table_data($this->student_table, array('id' => $inputs['studentId']), $student_data);

    //                 //save log
    //                 if (!empty($payment_data) && !empty($inputs['pay_status'])) {
    //                     $description .= ' & updated the sem fee status as paid with payment details.';
    //                 }
    //                 $this->save_log($data, $description);

    //                 //send email notification
    //                 if (!empty($inputs['send_email']) && !empty($get_student['email'])) {
    //                     $maildata = array(
    //                         'course_type' => strtoupper($this->course_type),
    //                         'course_name' => $get_student['course_name'],
    //                         'acm_year' => $get_student['acm_year'],
    //                         'sem_id' => $inputs['sem_id'],
    //                         'enable_data' => $enable_data,
    //                         'name' => ucwords($get_student['first_name'] . ' ' . $get_student['last_name']),
    //                         'email' => $get_student['email'],
    //                         'mobile' => $get_student['mobile'],
    //                         'login_url' => base_url() . $this->course_type . '-registration/login',
    //                     );

    //                     $mailsubject = "Semester Payment Alert | RCL";
    //                     $email_content = $this->load->view('email-template/semesters/' . $this->course_type . '/sem_payment_enabled', $maildata, true);
    //                     $mailsend = $this->admin->sendmail("", "", $maildata['email'], "", $mailsubject, $email_content, "");
    //                 }

    //                 $value = withSuccess($get_student['first_name'] . "'s " . ordinal($inputs['sem_id']) . " sem has been updated.");
    //             } else {
    //                 $value = withErrors($get_student['first_name'] . "'s " . ordinal($inputs['sem_id']) . " sem update failed.");
    //             }
    //         } else {
    //             $value = withErrors('Student data not found.');
    //         }
    //         echo json_encode($value);
    //     }
    // }
}
