<?php
    $core->userChkRole('CUSTOMERS-EDIT');
    
    if(isset($_GET['id']))
        if($_GET['id'] != null)
            if($core->dbNumRows('customers', array('id' => $_GET['id'])))
                define('ID', $_GET['id']);
            else $core->err(404);
        else $core->err(404);

    $e = false;
    if(!isset($_POST['name']))
        $e = true;
    elseif(strlen($_POST['name']) < 3)
        $e = true;
    elseif(isset($_POST['credit_limit']))
        if($_POST['credit_limit'] != null)
            if(!is_numeric($_POST['credit_limit']))
                $e = true;
            elseif($_POST['credit_limit'] < 0)
                $e = true;

    if($e)
        $core->err(V_URLP.'customers-add', false);

    if(defined('ID')){
        if($core->dbU('customers', array(
                'name'          => $core->aes($_POST['name']),
                'company'       => $core->aes($_POST['company']),
                'mobile_1'      => $core->aes($_POST['mobile_1']), 
                'mobile_2'      => $core->aes($_POST['mobile_2']), 
                'city'          => $core->aes($_POST['city']),
                'region'        => $core->aes($_POST['region']),
                'address'       => $core->aes($_POST['address']),
                'credit_limit'  => $core->aes($_POST['credit_limit'])
        ), array("id" => ID)))
            $core->err(V_URLP.'customers-add&id='.ID, true);
        else 
            $core->err(V_URLP.'customers-add&id='.ID, false);
    }else{
        if($core->dbI('customers', array(
            'name'          => $core->aes($_POST['name']),
            'company'       => $core->aes($_POST['company']),
            'mobile_1'      => $core->aes($_POST['mobile_1']), 
            'mobile_2'      => $core->aes($_POST['mobile_2']), 
            'city'          => $core->aes($_POST['city']),
            'region'        => $core->aes($_POST['region']),
            'address'       => $core->aes($_POST['address']),
            'credit_limit'  => $core->aes($_POST['credit_limit'])
        )))
            $core->err(V_URLP.'customers', true);
        else
            $core->err(V_URLP.'customers-add', false);
    }
?>