<?php
    $core->userChkRole('REGISTRANTS-EDIT');
    if(!$core->chk_GET('id')){
        $core->err(404);
    }elseif(!$core->dbNumRows('courses', array('id' => $_GET['id']))){
        $core->err(404);
    }elseif(!$core->chk_POST('student')){
        $core->err(404);
    }elseif(!$core->dbNumRows('staff', array('id' => $_POST['student']))){
        $core->err(404);
    }

    if($core->dbI('registrants', array(
        'staff_id'      => $_POST['student'],
        'course_id'     => $_GET['id'],
        'payment'       => $core->aes('UNPAID'),
        'acceptance'    => $core->aes('UNACCEPTED')
    ))){
        $core->err(V_URLP.'registrants&id='.$_GET['id'], true);
    }else{
        $core->err(V_URLP.'registrants-add&id='.$_GET['id'], false);
    }
?>