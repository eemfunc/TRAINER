<?php
    $core->userChkRole('COURSES-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('courses', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('courses', array('id' => $_GET['id']))){
        $status = true;
    }else{
        $status = false;
    }
    $core->err(V_URLP.'courses', $status);
?>