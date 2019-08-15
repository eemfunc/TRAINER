<?php
    
class branches{
    
    public $ID = null;
    public $NAME = null;
    public $LOCATION = null;
    public $MOBILE = null;
    public $ADMIN_USER_ID;
    public $ADMIN_USER_NAME;
    public $TYPE_ARR = array('MAIN-BRANCH', 'OTHER-BRANCH', 'REPRESENTATIVES-BRANCH');
    private $CLOSE_DB;
    private $TYPE = null;
    
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
        
        if(!$core->dbNumRows('branches', array('id' => $this->ID), null, $this->CLOSE_DB)){
            $core->err(404);
            return false;
        }else
            return true;
    }
    
    public function adminUserOptions(){
        global $core;
        $txt = ($this->ID == null || $this->ADMIN_USER_ID == null) ? '<option value="" selected>'.$core->txt('0068').'</option>' : null;
        $rows = $core->dbFetch('users', null, 'ORDER BY created_at ASC', $this->CLOSE_DB);
        foreach($rows as $r){
            $exist = false;
            $rows1 = $core->dbFetch('branches', null, 'ORDER BY created_at ASC', $this->CLOSE_DB);
            foreach($rows1 as $r1){
                if($r1['id'] != $this->ID && $r1['admin_user_id'] == $r['id'])
                    $exist = true;
                if(!$exist){
                    $txt.= "<option value='".$r['id']."'";
                    if($this->ADMIN_USER_ID != '' && $this->ADMIN_USER_ID == $r['id'])
                        $txt.= 'selected';
                    $txt.= ">".$core->aes($r['name'], 1)."</option>";
                }
            }
        }
        return $txt;
    }
    
    public function prepareVars(){
        global $core;
        
        $rows = $core->dbFetch('branches', array('id' => $this->ID), null, $this->CLOSE_DB);
        foreach($rows as $r){
            $this->NAME             = ($r['name']) ? $core->aes($r['name'], 1) : null;
            $this->LOCATION         = ($r['location']) ? $core->aes($r['location'], 1) : null;
            $this->MOBILE           = ($r['mobile']) ? $core->aes($r['mobile'], 1) : null;
            $this->TYPE             = ($r['type']) ? $core->aes($r['type'], 1) : null;
            $this->ADMIN_USER_ID    = ($r['admin_user_id']) ? $r['admin_user_id'] : null;
        }
        
        $this->ADMIN_USER_NAME = ($this->ADMIN_USER_ID != null) ? $core->aes($core->dbFetch('users', array('id' => $this->ADMIN_USER_ID), null, $this->CLOSE_DB)[0]['name'], 1) : '';
        
        return true;
    }
    
    public function branchTypeOptions(){
        global $core;
        
        $txt = ($this->ID == null || $this->TYPE == null) ? '<option value="" selected>'.$core->txt('0068').'</option>' : null;
        
        foreach($this->TYPE_ARR as $branch_type){
            $txt.= '<option value="'.$branch_type.'"';
            if($branch_type == $this->TYPE)
                $txt.= ' selected';
            $txt.= '>'.$branch_type.'</option>';
        }
        
        return $txt;
    }
}

?>