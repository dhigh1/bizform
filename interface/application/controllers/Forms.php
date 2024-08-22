<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('../controllers/template');
        $this->view_path = "public/forms/";
        $this->script_path = $this->view_path . "script/";
        $this->style_path = $this->view_path . "style/";
        $this->module_name = "campaign";
        $this->main_key = "name";
        $this->userId = User::get_userId();
    }

    public function index()
    {
        $campaign_id = isset($_GET['campaign']) ? $_GET['campaign'] : '';
        $get_campaign = $this->curl->execute('campaigns', "GET", array('url' => $campaign_id));
        if ($get_campaign['status'] == 'success' && !empty($get_campaign['data_list'])) {
            if ($get_campaign['data_list'][0]['status_name'] != 'Stop') {
                if ($get_campaign['data_list'][0]['status'] != 'Hold') {
                    if (isset($_GET['response']) && !empty($_GET['response'])) {
                        // checking if the response ID is there in GET Request and if there if valid or not. If not valid it'll go to else part and create a response ID
                        $token = $_GET['response'];
                        $error = '';
                        $data = array();
                        $data['campaign_data'] = $get_campaign['data_list'][0];
                        $data['candidate_id'] = $token;
                        $bizform_candidate = $this->curl->execute('bizform_candidates/', 'GET', array('bizform_candidates-candidate_id'=>$this->input->get('response'))); 
                        if($bizform_candidate['status']=='success' && !empty($bizform_candidate['data_list']) && $bizform_candidate['data_list'][0]['status_name']!='Cancelled'){
                            $get_response_apidata = $this->curl->execute('campaigns/response/' . $token, 'GET');
                                if ($get_response_apidata['status'] == 'success') {
                                    // if(!empty($get_response_apidata['data_list']['status'])){
                                        if ($get_response_apidata['data_list']['pending_row'] == 0) {
                                            $error = $this->load->view($this->view_path . 'thanks', $data, true);
                                            $data['pending_row'] = 0;
                                        } else {
                                            $data['response_row'] = $get_response_apidata['data_list']['response_row'];
                                            $data['form_template'] = $get_response_apidata['data_list']['form_data'];
                                            $data['pending_row'] = 1;
                                        }
                                    // }else{
                                    //     redirect(base_url().'forms/cancel');
                                    // }
                                    } else {
                                        $error = '<div class="alert alert-danger text-center">Could not load template! Please Refresh the page or contact the admin</div>';
                                    }
                        }else{
                            redirect(base_url().'forms/cancel');
                        }
                        $data['error'] = $error;
                        $data['response_id'] = $token;
                        $data['title'] = "Form";
                        $data['content_view'] = $this->load->view($this->view_path . "main_view", $data, true);
                        $data['script'] = $this->load->view($this->script_path . "script", '', true);
                        $data['style'] = $this->load->view($this->style_path . "style", '', true);
                        $this->template->public_template($data);
                    } else {
                        $campaign_id = $get_campaign['data_list'][0]['id'];
                        $url = $get_campaign['data_list'][0]['url'];
                        $session_id = '';
                        $apidata = $this->curl->execute('campaigns/campaign_list/' . $campaign_id, 'GET');
                        if ($apidata['status'] == 'success' && !empty($apidata['data_list'])) {
                            if (is_array($apidata['data_list'])) {
                                $insert_data = array();
                                $insert_data['candidate_id'] = get_random_value(13);
                                $insert_data['campaign_id'] = $campaign_id;
                                $insert_data['status'] = 75;
                                $create_candidate = $this->curl->execute('campaigns/create_candidate', 'POST', $insert_data);
                                if ($create_candidate['status'] == 'success' && !empty($create_candidate['data_list'])) {
                                    $insert_data['candidates_id'] = $create_candidate['data_list']['candidate_id'];
                                    $insert_data['templates'] = json_encode($apidata['data_list']);
                                    $create_responses = $this->curl->execute('campaigns/response', 'POST', $insert_data);
                                    if ($create_responses['status'] == 'success' && !empty($create_responses['data_list'])) {
                                        $responseData = $create_responses['data_list'];
                                        $candidateId = $responseData['user_code'];
                                        $id = $campaign_id;
                                        redirect(base_url() . 'forms?campaign=' . $url . '&response=' . $candidateId);
                                    } else {
                                        $error = '<div class="alert alert-danger text-center">Uh Oh!! Something is not right. Please try again. Could not initiate the case.</div>';
                                    }
                                }
                            }
                        } else {
                            $error = '<div class="alert alert-danger text-center">Uh Oh!! Something is not right. Please try again.</div>';
                        }
                    }
                } else {
                    $error = '<div class="alert alert-danger text-center">Uh Oh, The case is in Hold. Please try again later</div>';
                    $data['error'] = $error;
                    $data['title'] = "Form";
                    $data['content_view'] = $this->load->view($this->view_path . "main_view", $data, true);
                    $data['script'] = $this->load->view($this->script_path . "script", '', true);
                    $data['style'] = $this->load->view($this->style_path . "style", '', true);
                    $this->template->public_template($data);
                }
            } else { 
                $error = '<div class="alert alert-danger text-center">Uh Oh, The case is stopped</div>';
                $data['error'] = $error;
                $data['title'] = "Form";
                $data['content_view'] = $this->load->view($this->view_path . "main_view", $data, true);
                $data['script'] = $this->load->view($this->script_path . "script", '', true);
                $data['style'] = $this->load->view($this->style_path . "style", '', true);
                $this->template->public_template($data);
            }
        } else {
            $error = '<div class="alert alert-danger text-center">Incorrect URL! Please Check the page url or contact admin</div>';
        }
    }

    function cancel_case()
    {
        $user = (string) $this->input->post('user_id');
        $cancel = $this->curl->execute('campaigns/cancel_candidate/'.$user, 'PUT');
        $redirect_url = '';
        if ($cancel['status'] == 'success') {
            $status = 'success';
            $message = 'Cancelled Successfully!!';
            $redirect_url = base_url() . 'forms/cancel';
        } else {
            $status = 'fail';
            $message = $cancel['message'];
        }
        echo json_encode(array('status' => $status, 'message' => $message, 'redirect_url' => $redirect_url));
        return;
    }

    function cancel()
    {
        $error = '<div class="alert alert-danger text-center">The case is Cancelled.</div>';
        $data['error'] = $error;
        $data['title'] = "Form";
        $data['content_view'] = $this->load->view($this->view_path . "main_view", $data, true);
        $data['script'] = $this->load->view($this->script_path . "script", '', true);
        $data['style'] = $this->load->view($this->style_path . "style", '', true);
        $this->template->public_template($data);
        return;
    }


    function save_data()
    {
        $input = $this->input->post();
        $data = array();
        $data['updated_by'] = $input['user_id'];
        $data['fields_json'] = $input['fields_json'];
        $data['status'] = 76;
        $data['response_row'] = $input['row_id'];
        $data['user_id'] = $input['user_id'];
        $apidata = $this->curl->execute('campaigns/response', "PUT", $data);
        $activity_name = $this->module_name . '_update';
        $message = $apidata['message'];
        $value = array('message' => $message, 'status' => $apidata['status']);
        echo json_encode($value);
    }

    function save_files()
    {
        $allowedExtensions = array('png', 'jpeg', 'jpg');
        $campaign_name = '';
        $input_name = $this->input->post('name');
        $user_id = $this->input->post('user_id');
        $row_id = $this->input->post('row_id');
        $campaign_id = $this->input->post('campaignID');
        $campaign_data = $this->curl->execute('campaigns/' . $campaign_id, 'GET');
        if ($campaign_data['status'] == 'success' && !empty($campaign_data['data_list'])) {
            $campaign_name = $campaign_data['data_list']['name'];
        $form_id = $this->input->post('formID');
        $form_data = $this->curl->execute('formbuilder/' . $form_id, 'GET');
        // print_r($form_data);exit();
        if ($form_data['status'] == 'success' && !empty($form_data['data_list'])) {
            $html_form = $form_data['data_list']['html_json'];
            $decoded_values = json_decode($html_form, true);
            $extensions = array("jpeg","jpg","png","PNG","JPEG","JPG");
            $dir = 'uploads/responses/' . create_slug($campaign_name) . '/' . $form_id . '/';
            create_directory($dir);
	        if(!empty($_FILES)){
	                if(!empty($_FILES['file']['tmp_name'])){
	                    $file_name = $_FILES['file']['name'];
                        // print_r($file_name);
                        // exit();
	                    $file_size =$_FILES['file']['size'];
	                    $file_tmp =$_FILES['file']['tmp_name'];
	                    $file_type=$_FILES['file']['type'];        
	                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
	                    if($file_size > 2048) {
	                        $msg='File size should not exceed 2 MB';
	                    }
	                    if(in_array($ext,$extensions ) === true)
	                    {  

	                        $target = $dir.$file_name;
	                        if(file_exists($target)){
	                            $file_name = rand(01,1000).$file_name;
	                        }
	                        $target = $dir.$file_name;
	                        if(move_uploaded_file($file_tmp, $dir.$file_name)){
	                            $data['feature_image']=$file_name;
	                            $result='success';
                                // saving
                                $data['campaign_name'] = $campaign_name;
                                $data['campaign_id'] = $campaign_id;
                                $data['form_id'] = $form_id;
                                $data['candidate_id'] = $user_id;
                                $data['row_id'] = $row_id;
                                $data['file_name'] = $file_name;
                                $data['input_name'] = $input_name;
                                $data['file_size'] = $file_size;
                                $data['file_ext'] = $ext;
                                $data['file_path'] = $dir;
                                $data['ip_address'] = get_ipaddress();
                                $data['uploaded_at'] = cur_datetime();
                                $post = $this->curl->execute('campaigns/upload_file', "POST", $data);
                                if ($post['status'] == 'success' && !empty($post['data_list'])) {
                                    $response = array('status' => 'success', 'message' => 'Uploaded successfully');
                                } else {
                                    $response = array('status' => 'fail', 'message' => 'Upload failed');
                                }
	                        }else{
                                $response = array('status'=>'fail', 'message'=>'Error Uploading the file');
	                        }
                            
	                    }else{
                            $response = array('status'=>'fail', 'message'=>'Error in uploading file. <br>File type is not allowed.');
	                    }
	                }else{
                        $response = array('status'=>'fail', 'message'=>'Please select the file to upload1');
	                }
	        }else{
                $response = array('status'=>'fail', 'message'=>'Please select the file to upload2');
	        }
            echo json_encode($response);
            return;
        }
        }else{
            $response = array('status'=>'fail', 'message'=>'Unknown Response. Please reload the page');
            echo json_encode($response);
        }
    }
}