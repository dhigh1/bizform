<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(User::is_logged()){
			redirect(base_url().'dashboard');
		}
		$this->load->library('../controllers/template');
		$this->load->library('user_agent');
		$this->view_path = "users/auth/";
		$this->script_path = $this->view_path."script/";
		$this->style_path = $this->view_path."style/";
	}

	public function index()
	{
		$data['title'] = "User Login";
		$data['login_var']="Login ID/Email address";
	    $data['script'] =  $this->load->view($this->script_path."auth",'' , true);
       	$data['style'] =  $this->load->view($this->style_path."auth",'' , true);
       	$this->template->login_template($data);
	}
	function authentication()
	{
		$apidata = $this->curl->execute("users/authentication", "GET");

		$urldirect = "";
		$result = 'fail';
		$msg = '';
		$uid = $this->input->post("uid");
		$password = $this->input->post("pwd");	
		$remember = $this->input->post('remember');
		$apidata = $this->curl->execute("users/authentication", "GET", array('uid' => $uid));
		$row_data = $apidata['data_list'];
	
		if (is_array($row_data) && !empty($row_data)) {
			if ($row_data['status'] == "7") {
				$check_pass = $this->Mydb->verifyHash($password, $row_data['password']);
				$rolesdata = $this->curl->execute('roles/' . $row_data['roles_id'], 'GET');
				$rolesStatus = 0;
	
				if ($rolesdata['status'] == 'success' && !empty($rolesdata['data_list'])) {
					$rolesStatus = $rolesdata['data_list']['status'];
				}
	
				if ($check_pass && $rolesStatus == 5) {
					$userdata = array(
						'userId' => $row_data['id'],
						'userName' => $row_data['login_id'],
						'userRoleId' => $row_data['roles_id'],
						'userisAdmin' => $row_data['is_sadmin'],
						'userDeptId' => $row_data['departments_id'],
						'userLogged' => 1
					);
	
					//$this->Mydb->setlog($row_data['id'],'users');
					$this->session->set_userdata($userdata);
					setRemember($remember, $uid, $password);
					$result = 'success';
					$msg = "Login success! Redirecting...";
					$logData = array(
						'action' => 'login',
						'description' => 'logged in to the system',
						'data_id' => $row_data['id'],
						'module' => 'session'
					);
					User::activity($logData);
					$urldirect = base_url() . 'dashboard';
				} else {
					$msg = "Username or Password wrong";
				}
			} else {
				$msg = "Your account is inactive, please contact administrator!";
			}
		} else {
			$msg = "It seems your account does not exist, please contact the administrator!";
		}
	
		$value = array(
			'status' => $result,
			'message' => $msg,
			'urlredirect' => $urldirect
		);

		echo json_encode($value);
	}
	
		
}
