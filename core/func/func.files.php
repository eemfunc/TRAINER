<?php

class files{
    
    public $FULL_NAME;
    public $TMP_NAME;
    public $NAME;
    public $SIZE;
    public $NEW_NAME;
    public $EXTENSION;
    public $FILE_URL;
    public $UPLOAD_URL = null;
    public $ALLOWED_EXTS = array();
    public $EXT_ERR = false;
    public $SIZ_ERR = false;

    private $UPLOAD_FOLDER = V_UPLOAD_FOLDER;
    private $UPLOAD_DIR = null;
    
    function __construct($file, $exts, $dir = null){
        global $core;
        
        if(!is_array($exts))
            $exts = (array) $exts;
        
        $this->FULL_NAME    = $file['name'];
        $this->TMP_NAME     = $file['tmp_name'];
        $this->NAME         = pathinfo($this->FULL_NAME, PATHINFO_FILENAME);
        $name_explode_arr   = explode('.', $this->FULL_NAME);
        $this->EXTENSION    = strtolower(end($name_explode_arr));
        $this->NEW_NAME     = $core->randStr(8, "A-0").'-'.$this->FULL_NAME;
        $this->SIZE         = $file['size'];
        $this->ALLOWED_EXTS = $exts;
        $this->UPLOAD_DIR = $dir;

        if($dir != null){
            $this->UPLOAD_URL = $this->UPLOAD_FOLDER.$dir.$this->NEW_NAME;
        }else
            $this->UPLOAD_URL = $this->UPLOAD_FOLDER.$this->NEW_NAME;
        
        $this->FILE_URL = '/'.V_MAIN_FOLDER.$this->UPLOAD_URL;
        
        $this->chkExtension();
        $this->chkSize();
    }
    
    private function chkExtension(){
        if(in_array($this->EXTENSION, $this->ALLOWED_EXTS) === false)
            $this->EXT_ERR = true;
    }
    
    private function chkSize(){
        if($this->SIZE > V_MAXIMUM_UPLOAD_FILE_SIZE)
            $this->SIZ_ERR = true;
    }
    
    public function uploadNow(){
        $this->chkFolder($this->UPLOAD_FOLDER.$this->UPLOAD_DIR);

        if(move_uploaded_file($this->TMP_NAME, $this->UPLOAD_URL))
            return true;
        else
            return false;
    }
    
    public function chkFolder($url){
        if(!file_exists($url)){
            mkdir($url, 0777, true);
            return false;
        }else
            return true;
    }
}

?>