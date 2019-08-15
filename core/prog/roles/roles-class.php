<?php

class roles{
    
    public $ID = null;
    public $NAME = null;
    public $ROLES = null;
    public $TABLE_ARR = array();
    public $PAGE = 1;
    public $TOTAL_PAGES = 1;
    public $TOTAL_ROWS = 1;
    public $START_FROM = 1;
    public $START_TO = 1;
    private $CLOSE_DB;
    
    function __construct($id = null, $oc = true){
        
        $this->CLOSE_DB = $oc;
            
        if($id != null){
            $this->ID = $id;
            $this->chkId();
            $this->prepareVars();
        }
        
    }
    
    private function chkId(){
        global $core;
        if(!$core->dbNumRows('roles', array('id' => $this->ID), null, $this->CLOSE_DB)){
            $core->err(404);
            return false;
        }else
            return true;
    }
    
    public function prepareVars(){
        global $core;
        
        $rows = $core->dbFetch('roles', array('id' => $this->ID), null, $this->CLOSE_DB);
        foreach($rows as $r){
            $this->NAME = $core->aes($r['name'], 1);
            $roles      = $core->aes($r['roles'], 1);
        }
    
        $this->ROLES = $this->rolesComma($roles);
        return true;
    }
    
    private function rolesComma($roles){
        $output = '';
        $r_arr = explode('|', $roles);
        for($i = 0; $i < count($r_arr); $i++){
            if($i == 0)
                $output = trim($r_arr[$i]);
            else
                $output.= ', '.trim($r_arr[$i]);
        }
        return $output;
    }
    
    public function rolesVbars($roles){
        $output = '';
        $r_arr = explode(',', $roles);
        for($i = 0; $i < count($r_arr); $i++){
            if($i == 0)
                $output = trim($r_arr[$i]);
            else
                $output.= '|'.trim($r_arr[$i]);
        }
        return $output;
    }
    
    public function initTableArr(){
        global $core;
        $rows = $core->dbFetch('roles', null, 'ORDER BY created_at DESC', $this->CLOSE_DB, true);
        foreach($rows as $r){
            $output_arr = array(
                'id' => $r['id'],
                'name' => $core->aes($r['name'], 1),
                'roles' => $this->rolesComma($core->aes($r['roles'], 1))
            );
            array_push($this->TABLE_ARR, $output_arr);
        }
        return true;
    }
    
}

?>