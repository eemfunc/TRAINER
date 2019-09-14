<?php
    $core->userChkRole('REGISTRANTS-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('registrants', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('registrants', array('id' => $_GET['id']))){
        $status = true;
    }else{
        $status = false;
    }
    $core->err(V_URLP.'students', $status);
?>