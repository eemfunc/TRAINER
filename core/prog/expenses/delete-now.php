<?php
    $core->userChkRole('EXPENSES-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('expenses', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('expenses', array('id' => $_GET['id']))){
        $status = true;
    }else{
        $status = false;
    }
    $core->err(V_URLP.'expenses', $status);
?>