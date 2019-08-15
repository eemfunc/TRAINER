<?php
    $core->userChkRole('EXPENSES-CATEGORIES-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('expenses_categories', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('expenses_categories', array('id' => $_GET['id']))){
        $status = true;
    }else{
        $status = false;
    }
    $core->err(V_URLP.'expenses-categories', $status);
?>