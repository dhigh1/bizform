<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

function print_depts_tree($tree, $r = 0, $p = null) {
  //$output='';
  //print_r($tree);
   foreach ($tree as $i => $t) {
       $dash = ($t['parent'] == 0) ? '' : str_repeat('-', $r) .'';
       printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['name']);
       if ($t['parent'] == $p) {
           // reset $r
           $r = 0;
       }
       //print_r($t);
       if (isset($t['_children'])) {
        
           print_depts_tree($t['_children'], $r+1, $t['parent']);
       }
   }
   //return $output;
}


function array_flatten($array) { 
    if (!is_array($array)) { 
      return FALSE; 
    } 
    $result = array(); 
    foreach ($array as $key => $value) { 
      if (is_array($value)) { 
        $result = array_merge($result, array_flatten($value)); 
      } 
      else { 
        $result[$key] = $value; 
      } 
    } 
    return $result; 
  } 
  

function get_url_param_value($searchParam=''){
    $ci =& get_instance();
    $url_params=$ci->input->post('filter_data');
    $returnval='';
    if(empty($searchParam)){
        $returnval=[];
    }
    if(!empty($url_params)){
        foreach ($url_params as $k => $v) {
            if(!empty($searchParam)){
                if($v['type']==$searchParam){
                    $returnval=$v['value'];
                }
            }else{
                $returnval[]=array(
                    $v['type']=>$v['value']
                );
            }
        }
    }
    return $returnval;
}

function split_string_to_arr($text){
    //variable to store the result i.e. an array 
    $arr = [];
    //calculate string length
    $strLength = strlen($text);
    $dl = ','; //delimeter
    $j = 0;
    $tmp = ''; //a temp variable
    //logic - it will check all characters
    //and split the string when comma found
    for ($i = 0; $i < $strLength; $i++) {
        if($dl === $text[$i]) {
            $j++;
            $tmp = '';
            continue;
        }
        $tmp .= $text[$i];
        $arr[$j] = $tmp;
    }
    //return the result
    return $arr;
}

function create_slug($string){
  $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
  return strtolower($slug);
} 

if (!function_exists('setRemember')) {
    function setRemember($remember,$uname,$pwd){
        $trimmed = !empty($remember)?trim($remember):'';
        if($trimmed=='on') {
            $year = time() + 3600 * 24 * 365;
        }else if($remember=="") {            
            $year = time() - 3600 * 24 * 365;
        }
        setcookie('user_remember_me', $uname, $year);
        setcookie('user_password', $pwd, $year);
    }
}

if (!function_exists('get_ipaddress')) {    
    function get_ipaddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }     
}

if (!function_exists('cur_datetime')) {    
    function cur_datetime()
    {
        $date=date('Y-m-d H:i:s');
        return $date;
    }    
}

if(!function_exists('custom_date')){
  function custom_date($format,$originalDate){
    $newDate = date($format, strtotime($originalDate));
    return $newDate;
  }
}


if (!function_exists('withErrors')) {
    function withErrors($msg,$result=""){
         $value=array(
                'status'=>"fail", 
                'result' =>$result,
                'message'=>$msg,
                );
        return $value;
    }
}


if (!function_exists('withSuccess')) {
    function withSuccess($msg,$result=""){
         $value=array(
                'status'=>"success",
                'result' => $result,
                'message'=>$msg,
                );
        return $value;
    }
}


// sentence teaser
// this function will cut the string by how many words you want
function word_teaser($string, $count){
  $original_string = $string;
  $words = explode(' ', $original_string);
 
  if (count($words) > $count){
   $words = array_slice($words, 0, $count);
   $string = implode(' ', $words);
  }
 
  return $string;
}

function string_teaser($string,$count){
    $string = strip_tags($string); $string = trim($string);
    if(strlen($string)<$count+1){
        $res = $string;
    }else{

        $res = substr($string, 0, $count)."...";
    }
    return $res;
}

function filename_teaser($string,$count,$ext){
    $string = strip_tags($string); $string = trim($string);
    if(strlen($string)<$count+1){
        $res = $string.$ext;
    }else{

        $res = substr($string, 0, $count)."...".$ext;
    }
    return $res;
}

function moneyFormat($num) {
    $explrestunits = "" ;
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

function file_download($filepath){
	  if(file_exists($filepath)) {

            header('Content-Description: File Transfer');

            header('Content-Type: application/octet-stream');

            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');

            header('Expires: 0');

            header('Cache-Control: must-revalidate');

            header('Pragma: public');

            header('Content-Length: ' . filesize($filepath));

            flush(); // Flush system output buffer

            readfile($filepath);

            exit;

        }
	
}

 function fileSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

function humanTiming ($time)
{
    $time=strtotime($time);
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'min',
        1 => 'second'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
    }
}

if(!function_exists('currencyWords')){

function currencyWords($number) {
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
}

}


function send_email($templateName,$mailData){
    $ci =& get_instance();
    $content  = $ci->load->view('email-templates/'.$templateName, $mailData, TRUE); 
    $from='';
    $fromText='';
    $user_cc='';
    if(isset($mailData['attachment'])){
        $attachment=$mailData['attachment'];
    }else{
        $attachment='';
    }
    if(isset($mailData['attachmentName'])){
        $attachmentName=$mailData['attachmentName'];
    }else{
        $attachmentName='';
    }

    $mailsend = $ci->admin->sendmail($from, $fromText, $mailData['mailTo'], $user_cc, $mailData['mailSubject'], $content,$attachment,$attachmentName);             
    return $mailsend;
    
}

if(!function_exists('send_sms')){
    function send_sms($toMobile,$message){
        //print_r($toMobile);
        if(!empty($toMobile)){
            $ci =& get_instance();
            $ci->load->library('adminmodel',true);
            $sWhere = array('id' => 1 );
            $settings=$ci->adminmodel->get_table_data('sms_settings',$sWhere,'*',true);
            //print_r($this->db->last_query());

            $username = $settings->row()->username;
            $password = $settings->row()->password;
            $senderId = $settings->row()->senderId;
            $message = urlencode($message);
            if(is_array($toMobile)){
                $toMobile = implode(',', $toMobile);
            }
            
            $msgURL = "http://smsalert.dmudra.com/api/smsapi.aspx?username=$username&password=$password&to=$toMobile&from=$senderId&message=$message";
            //$msgURL = "http://smsalert.dmudra.com/api/smscredit.aspx?username=odopix&password=odopix098";

            $_h = curl_init();
            curl_setopt($_h, CURLOPT_HEADER, 1);
            curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($_h, CURLOPT_HTTPGET, 1);
            curl_setopt($_h, CURLOPT_URL, $msgURL);
            curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
            curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );

            //var_dump(curl_exec($_h));
            //var_dump(curl_getinfo($_h));
            //var_dump(curl_error($_h));
            $html=curl_exec($_h);
            if($html === false) {
                $msg=curl_error($_h);
                $result=0;
            }else {
                $msg= 'Operation completed without any errors';
                $result=1;
            }

            //print_r($_h);
            curl_close($_h);
        }else {
            $msg= 'Mobile number is compulsary to send sms';
            $result=0;
        }
        $value = array('msg' =>$msg ,'result'=>$result );
        return $value;
    }
}

function xss_clean($data)
{
    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);

    // we are done...
    return $data;
}


function create_directory($dir_name){
    if(empty($dir_name)){
        $dir_name='uploads/'.date('m-Y').'/';
    }
    $dir = $dir_name;
    if(!file_exists($dir)){
        mkdir($dir , 0777, true);
    }else{
        $msg="Directory already exists!";
    }
    $newFileName = $dir."index.html";
    if(!file_exists($newFileName)){    
        $newFileContent = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
        if (file_put_contents($newFileName, $newFileContent) !== false) {
            $msg= "File created (" . basename($newFileName) . ")";
        } else {
            $msg= "Cannot create file (" . basename($newFileName) . ")";
        }
    }
    $data=array('msg'=>$msg,'dir'=>$dir);
    return $dir;
}


function upload_files($files,$allowed_types='',$purpose='',$max_size='',$path=''){
    $ci =& get_instance();
    $target_dir = create_directory($path);
    $error_note="";
    if(!empty($allowed_types)){
        $error_note.="Allowed file extension(s) are - ".str_replace('|', ', ', $allowed_types);
    }
    if(empty($allowed_types)){
        $allowed_types='*';
    }
    $config = array(
        'upload_path'   => $target_dir,
        'allowed_types' => $allowed_types,        
        'remove_spaces' => TRUE,
        'encrypt_name' => TRUE,
        'file_ext_tolower'=>TRUE
    );
    if(!empty($max_size)){
        $max_size=1024*$max_size;
        if(!empty($error_note)){
            $error_note.=' and ';
        }
        $error_note.="Maximum file size is ".$max_size;
        $config['max_size']=$max_size;
    }

    $ci->load->library('upload', $config);

    $images = array();
    $files=$_FILES[$files];
    $return_data = array();
    $success_count=0;
    $error_count=0;
    $total_count=0;
    $return_message='';

    foreach ($files['name'] as $key => $image) {
        $_FILES['images[]']['name']= $files['name'][$key];
        $_FILES['images[]']['type']= $files['type'][$key];
        $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
        $_FILES['images[]']['error']= $files['error'][$key];
        $_FILES['images[]']['size']= $files['size'][$key];

        $fileName = $image;

        $images[] = $fileName;

        $config['file_name'] = $fileName;

        $ci->upload->initialize($config);

        if ($ci->upload->do_upload('images[]')) {
            $upload_data=$ci->upload->data();
            $success_data=array(
                'status'=>'success',
                'file_name'=>$upload_data['file_name'],
                'orig_name'=>$upload_data['orig_name'],
                'file_size'=>$upload_data['file_size'],
                'file_ext'=>$upload_data['file_ext'],
                'real_path'=>$upload_data['file_path'],
                'base_path'=>base_url(),
                'file_path'=>$target_dir,
                'upload_for'=>$purpose
            );
            if(User::is_logged()){
                $success_data['created_by']=User::get_userId();
                $success_data['upload_by_type']=58;
            }else if(Vendor::is_logged()){
                $success_data['created_by']=Vendor::get_userId();
                $success_data['upload_by_type']=59;
            }else if(Customer::is_logged()){
                $success_data['created_by']=Customer::get_userId();
                $success_data['upload_by_type']=60;
            }
            $apidata=$ci->curl->execute("media_library","POST",$success_data);
            if($apidata['status']=='success'){
                $upload_id=$apidata['data_list'][0]['id'];
            }else{
                $upload_id=null;
            }
            $success_data['uploads_id']=$upload_id;            
            array_push($return_data,$success_data);
            $success_count++;
        } else {
            $error_data=array(
                'status'=>'error',
                'file_name'=>$fileName,
                'message'=>strip_tags($ci->upload->display_errors())
            );           
            array_push($return_data,$error_data);
            $error_count++;
            if(!empty($fileName)){
                $return_message.='<p>'.$fileName.' - '.$error_data['message'].'</p>';
            }else{
                $return_message.='<p>'.$error_data['message'].'</p>';
            }
        }
        $total_count++;
    }
    if(!empty($error_note) && !empty($return_message)){
        $return_message=$return_message.'<p>'.$error_note.'</p>';
    }
    $return_data['message']=$return_message;
    $return_data['total_count']=$total_count;
    $return_data['success_count']=$success_count;
    $return_data['error_count']=$error_count;

    return $return_data;
}


function download_url_file($url,$save_path,$file_name=''){
    $status='fail';
    $file_url='';    
    create_directory($save_path);
    //$url=urlencode($url);
    
    $newfname = $save_path . $file_name;

    $file = fopen ($url, "rb");
    if ($file) {
      $newf = fopen ($newfname, "wb");

      if ($newf)
      while(!feof($file)) {
        fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
      }
    }

    if ($file) {
      fclose($file);
    }

    if ($newf) {
      fclose($newf);
      $status='success';
      $file_url=$newfname;
    }
    $value=array('status'=>$status,'file_url'=>$file_url);
    return $value;
}

function print_image($image,$path='',$type='img',$class_name=''){
    $image_url=base_url().'uploads/no-image-alt.jpg';
    if(!empty($image)){
        if(file_exists($path.$image)){
            $image_url=base_url().$path.$image;
        }
    }
    if($type=='src'){
        $image=$image_url;
    }else{
        $image='<img src="'.$image_url.'" class="'.$class_name.'">';
    }
    echo  $image;
}

function print_icon($icon,$color='#1272a4'){
    $color_code='#1272a4';
    if(!empty($color)){
        $color_code=$color;
    }
    if(!empty($icon)){
        echo '<i class="'.$icon.' service-icon" style="color:'.$color_code.'"></i>';
    }
}

function get_print_download($url){
    echo '<a href="'.base_url().$url.'" target="_blank" download><i class="fa fa-download"></i></a>';
}


function is_base64($s){
    // Check if there are valid base64 characters
   // if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;
    // Decode the string in strict mode and check the results
    $decoded = base64_decode($s, true);
    //print_r($decoded);
    //exit();
    if(false === $decoded) return false;
    // Encode the string again
    if(base64_encode($decoded) != $s) return false;
    return true;
}

function is_base64_encoded($str) {

       $decoded_str = base64_decode($str);
       $Str1 = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $decoded_str);
       if ($Str1!=$decoded_str || $Str1 == '') {
          return 'fail';
       }
       return 'success';
    }

function download_base64_file($base64string,$path,$file_name){
    //if(is_base64($base64string) == true){  
        //$base64string = "data:image/jpeg;base64,".$base64string;
        //$this->check_size($base64string);
        create_directory($path);
        check_file_type($base64string);
        
        /*=================uploads=================*/
        list($type, $base64string) = explode(';', $base64string);
        list(,$extension)          = explode('/',$type);
        list(,$base64string)       = explode(',', $base64string);
        $fileName                  = $file_name.'_'.date('Y_m_d_h_i_s').'.'.$extension;
        $base64string              = base64_decode($base64string);
        file_put_contents($path.$fileName, $base64string);
        return array('status' =>'success','message' =>'Successfully uploaded!','file_name'=>$fileName,'file_url'=>$path.$fileName);
    //}else{
       // return array('status' =>'fail','message' => 'This Base64 String is invalid !');
    //}
}

function check_file_type($base64string){
    $mime_type = @mime_content_type($base64string);
    $allowed_file_types = ['image/png', 'image/jpeg', 'application/pdf'];
    if (! in_array($mime_type, $allowed_file_types)) {
        // File type is NOT allowed
       print_r(json_encode(array('status' =>false,'message' => 'File type is NOT allowed !')));exit;
    }
    return true;
}

function get_random_value($length){
    $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    );

    shuffle($chars);

    $num_chars = count($chars) - 1;
    $token = '';

    for ($i = 0; $i < $length; $i++){
        $token .= $chars[mt_rand(0, $num_chars)];
    }

    return $token;
}
