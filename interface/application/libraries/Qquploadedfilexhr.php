<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return $_GET['file'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path,$file_name) {
        if(!move_uploaded_file($_FILES[$file_name]['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName($file_name) {
        return $_FILES[$file_name]['name'];
    }
    function getSize($file_name) {
        return $_FILES[$file_name]['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10, $file_name='file'){       
        $sizeLimit = $sizeLimit * 1024 * 1024; 
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET[$file_name])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES[$file_name])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        //$postSize = $this->toBytes(ini_get('post_max_size'));
        //$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        

        $postSize=10000000;
        $uploadSize=1000000;
        
        // if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
        //     $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
        //     die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        // }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory,$file_name="file",$replaceOldFile = FALSE){

        if(!file_exists($uploadDirectory)){
            mkdir($uploadDirectory, 0777, true);
        }        
        
        if (!is_writable($uploadDirectory)){
            return array('status'=>'fail','msg' => "Server error. Upload directory isn't writable.");
        }
        
        if (!$this->file){
            return array('status'=>'fail','msg' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize($file_name);
        
        if ($size == 0) {
            return array('status'=>'fail','msg' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('status'=>'fail','msg' => 'File is too large');
        }
        
        $pathinfo = pathinfo($this->file->getName($file_name));
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];
        
        
        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('status'=>'fail','msg' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }

        
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext,$file_name)){
            //return array('success'=>true);
            return array('status'=>'success','msg'=>'File uploaded successfully', 'file_name'=>$filename . '.' . $ext, 'file_size'=>$size,'file_ext'=>$ext);
        } else {
            return array('status'=>'fail','msg'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    
}


