<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_upload{
	var $ci;

    function upload_vendor_file($ext_type,$upload_dir,$file_array='',$size_limit=''){
        $img_extensions = array("jpeg","jpg","png","PNG","JPEG","JPG");
        $file_extensions = array("pdf","PDF","docx","DOCX","xlsx","XLSX");
        $all_extensions = array_merge($img_extensions,$file_extensions);
    
        if($file_array==''){
            $file_array=array('attachment');
        }
        $doc_name='';
        $doc_result='fail';
    
        if($ext_type=='image'){
            $extensions=$img_extensions;
        }else if($ext_type=='file'){
            $extensions=$file_extensions;
        }else if($ext_type=='all'){
            $extensions=$all_extensions;
        }else{
            $extensions=$all_extensions;
        }
    
        if(!file_exists($upload_dir)){
            mkdir($upload_dir,0777,true);
        }
    
        if($size_limit==''){
            $size_limit=1;
        }
        $size_limit_byte=$size_limit*1048576; //convert mb to bytes
    
        //foreach($file_array as $file_input_array)
        for ($i=0;$i<count($file_array);$i++)
        {     
            $file_input=$file_array[$i];
            $key=$i;
            //print_r($file_input);
            //foreach($_FILES[$file_input]['tmp_name'] as $key => $tmp_name)
            //{
                if(!empty($_FILES[$file_input]['tmp_name'][$key])){
                    $file_name = $_FILES[$file_input]['name'][$key];
                    $file_size =$_FILES[$file_input]['size'][$key];
                    $file_tmp =$_FILES[$file_input]['tmp_name'][$key];
                    $file_type=$_FILES[$file_input]['type'][$key];        
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    //print_r('file_size = '.$file_size);
                    //print_r('size_limit_byte = '.$size_limit_byte);
                    if($file_size > $size_limit_byte){
                        $msg='File size should not exceed '.$size_limit.' MB';
                    }else{
                        if(in_array($ext,$extensions) === true)
                        {
                            $target = $upload_dir.$file_name;
                            if(file_exists($target)){
                                $file_name = rand(01,1000).$file_name;
                            }
                            $target = $upload_dir.$file_name;
                            if(move_uploaded_file($file_tmp,$upload_dir.$file_name))
                            {
                                //rename($upload_dir.$file_name, create_slug($upload_dir.$file_name));
                                $doc_result='success';
                                $msg="Uploaded successfully";
                                $data = array(
                                    'file_name'=>$file_name,
                                    'file_size'=>$file_size,
                                    'file_ext'=>$ext,
                                    'file_url'=>$upload_dir,
                                    'uploaded_at'=>cur_datetime()
                                );
                            }else{
                                $msg = 'Error in uploading.<br>Server busy.';
                                $doc_result='fail';
                            }
                        }else{
                            $msg = 'Error in uploading.<br>File type is not allowed.';
                            $doc_result='fail';
                        }
                    }
                }else{
                   $msg='File is required';
                   $doc_result='fail';
                }
            //}
        }
        $data['msg']=$msg;
        $data['result']=$doc_result;
        return $data;
    }
}