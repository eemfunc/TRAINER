<?php
    $core->userChkRole('STORES-EDIT');

    $e = false;
        
    if(!isset($_POST['name']) || !isset($_POST['branch_id']))
        $e = true;
    elseif(!strlen($_POST['name']) || strlen($_POST['branch_id']) < 8)
        $e = true;
    elseif(!$core->dbNumRows('branches', array('id' => $_POST['branch_id'])))
        $e = true;

    if($e){
        $url_txt = '';
        if(isset($_GET['id']))  
            if($core->dbNumRows('stores', array('id' => $_GET['id'])))
                $url_txt = '&id='.$_GET['id'];
        $core->err(V_URLP.'stores-add'.$url_txt, false);
    }

    if(isset($_GET['id'])){
        if(!$core->dbNumRows('stores', array('id' => $_GET['id'])))
            $core->err(404);
        
        if($core->dbU("stores", array(
            'name'      => $core->aes($_POST['name']), 
            'location'  => $core->aes($_POST['location']), 
            'branch_id' => $_POST['branch_id']
        ), array("id" => $_GET['id'])))
            $core->err(V_URLP.'stores-add&id='.ID, true);
        else
            $core->err(V_URLP.'stores-add&id='.ID, false);
    }else
        if($core->dbI('stores', array(
            'name'      => $core->aes($_POST['name']),
            'location'  => $core->aes($_POST['location']),
            'branch_id' => $_POST['branch_id']
        )))
            $core->err(V_URLP.'stores', true);
        else
            $core->err(V_URLP.'stores-add', false);

?>