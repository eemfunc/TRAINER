<?php
    $core->userChkRole('LECTURERS-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('staff', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('staff', array('id' => $_GET['id']))){
        $status = true;
    }else{
        $status = false;
    }
    $core->err(V_URLP.'lecturers', $status);
?>