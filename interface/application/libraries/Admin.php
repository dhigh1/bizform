<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin
{
	var $CI;
	function __construct()
	{
		$this->CI =& get_instance();
		if (!class_exists("phpmailer")) {
			require_once('PHPMailer/PHPMailerAutoload.php');
		}
	}

	function nocache()
	{
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}
	
	function common_files()
	{
		$org_data=array();
		$apidata=$this->CI->curl->execute("organization/1","GET");
		if($apidata['status']=='success' && !empty($apidata['data_list'])){
			$org_data['org_data']=$apidata['data_list'];
		}
		$data = array(
			'common_css' => $this->CI->load->view('users/common_files/common_css', $org_data, TRUE),
			'common_js' => $this->CI->load->view('users/common_files/common_js', NULL, TRUE),
			'header_main' => '',
			'header_menu' => '',
			'footer' => $this->CI->load->view('pages/common_files/footer', $org_data, TRUE)
		);
		return $data;
	}
	
	function common_user_files()
	{
		$org_data=array();
		$apidata=$this->CI->curl->execute("organization/1","GET");
		$org_data['org_data'] = array();
		if($apidata['status']=='success' && !empty($apidata['data_list'])){
			$org_data['org_data']=$apidata['data_list'];
		}
		$data = array(
			'common_css' => $this->CI->load->view('users/common_files/common_css', $org_data, TRUE),
			'common_js' => $this->CI->load->view('users/common_files/common_js', NULL, TRUE),
			'header_main' => $this->CI->load->view('users/common_files/header_main', $org_data, TRUE),
			'header_menu' => $this->CI->load->view('users/common_files/header_menu', NULL, TRUE),
			'footer' => $this->CI->load->view('users/common_files/footer', $org_data, TRUE)
		);
		return $data;
	}
	
	function common_public_files()
	{
		$org_data=array();
		$apidata=$this->CI->curl->execute("organization/1","GET");
		if($apidata['status']=='success' && !empty($apidata['data_list'])){
			$org_data['org_data']=$apidata['data_list'];
		}
		$data = array(
			'common_css' => $this->CI->load->view('public/common_files/common_css', NULL, TRUE),
			'common_js' => $this->CI->load->view('public/common_files/common_js', NULL, TRUE),
			'header_main' => $this->CI->load->view('public/common_files/header_main', $org_data, TRUE),
			'footer' => $this->CI->load->view('public/common_files/footer', $org_data, TRUE),
		);
		return $data;
	}
	
	function common_customer_files()
	{
		$org_data=array();
		$apidata=$this->CI->curl->execute("organization/1","GET");
		if($apidata['status']=='success' && !empty($apidata['data_list'])){
			$org_data['org_data']=$apidata['data_list'];
		}
		$data = array(
			'common_css' => $this->CI->load->view('customers/common_files/common_css', NULL, TRUE),
			'common_js' => $this->CI->load->view('customers/common_files/common_js', NULL, TRUE),
			'header_main' => $this->CI->load->view('customers/common_files/header_main', $org_data, TRUE),
			'header_menu' => $this->CI->load->view('customers/common_files/header_menu', NULL, TRUE),
			'footer' => $this->CI->load->view('customers/common_files/footer', $org_data, TRUE),
		);
		return $data;
	} 

	
	function sendmail($from, $fromtxt, $to, $cc, $sub, $txt,$attachment,$file_name)
	{	
	    $where = array('settingId' => 1 );
	    $sett=$this->CI->Mydb->get_table_data('mail_settings',$where,'*',true);

		$mail = new PHPMailer;
		$mail->IsSMTP(); // set mailer to use SMTP
		//$mail->SMTPDebug = 3;
		$mail->SMTPAuth = $sett->row()->smtpAuth; // turn on SMTP authentication 
		$mail->SMTPSecure = $sett->row()->smtpSecure;  
		$mail->Host = $sett->row()->host; // specify main and backup server 
		$mail->Port = $sett->row()->port; 
		$mail->Username = $sett->row()->hostUsername; // SMTP username 
		$mail->Password = $sett->row()->hostPassword; // SMTP password 
		$mail->From = $from == "" ? $sett->row()->from : $from; 
		$mail->FromName = $fromtxt == "" ? $sett->row()->fromText : $fromtxt; 
		$address = explode(",", $to); 
		foreach ($address as $t) {
			$mail->AddAddress($t); // Email on which you want to send mail
		}
		if ($cc != "") {
			$addresscc = explode(",", $cc); 
			foreach ($addresscc as $tcc) {
				$mail->AddCC($tcc);
			}
		}
		if($attachment!=""){
			$mail->addAttachment($attachment, $file_name);			
		}
		$mail->IsHTML(true);
		$mail->CharSet = "utf-8";
		$mail->MsgHTML($txt); 
		$mail->Subject = $sub; 
		$mail->Body = $txt;
		return $mail->Send();	
		
	}
	
	function randomCodenum($num) {
		$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $num; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
	function random_integer($num) {
		$alphabet = '1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $num; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	function getCustomDate($dateFormat,$date){		
        if(is_nan($date)){				
            return mdate($dateFormat,strtotime(trim($date)));
			
        }else{			
            return mdate($dateFormat,trim($date));			
        }
    }
	
	function escapespecialchrs($text){
        return str_replace("'","''",$text);
	}
    
	function convertNumber($number) {
		if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}
 
		$Gn = floor($number / 1000000);
		/* Millions (giga) */
		$number -= $Gn * 1000000;
		$kn = floor($number / 1000);
		/* Thousands (kilo) */
		$number -= $kn * 1000;
		$Hn = floor($number / 100);
		/* Hundreds (hecto) */
		$number -= $Hn * 100;
		$Dn = floor($number / 10);
		/* Tens (deca) */
		$n = $number % 10;
		/* Ones */
 
		$res = "";
 
		if ($Gn) {
			$res .= $this->convertNumber($Gn) .  "Million";
		}
 
		if ($kn) {
			$res .= (empty($res) ? "" : " ") .$this->convertNumber($kn) . " Thousand";
		}
 
		if ($Hn) {
			$res .= (empty($res) ? "" : " ") .$this->convertNumber($Hn) . " Hundred";
		}
 
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
 
		if ($Dn || $n) {
			if (!empty($res)) {
				$res .= " and ";
			}
 
			if ($Dn < 2) {
				$res .= $ones[$Dn * 10 + $n];
			} else {
				$res .= $tens[$Dn];
 
				if ($n) {
					$res .= "-" . $ones[$n];
				}
			}
		}
 
		if (empty($res)) {
			$res = "zero";
		}
 
		return $res;
	}
	
	function setWordbycount($string,$count){
        $string = strip_tags($string); $string = trim($string);
        if(strlen($string)<$count+1){
            $res = $string. " ".str_repeat("&nbsp;",$count-strlen($string));
        }else{

            $res = substr($string, 0, $count)."...";
        }
		return $res;
    }

	function get_duration($t){
		$to_time = strtotime($t);
		$from_time = now();
		$duration = "";
		$minute = round(abs($to_time - $from_time) / 60,0);
		switch ($minute) {
			case $minute < 60:
			$duration = $minute ." minute(s) ago";
			break;
			case $minute >= 60 && $minute < 1440 :
			$duration = floor($minute / 60)." hour(s) ago" ;
			break;
			case $minute >= 1440 :
			$duration = floor($minute /1440)." day(s) ago" ;
			break;
			default:
			break;
		}
		return $duration;
	}
}