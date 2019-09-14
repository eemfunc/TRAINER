<?php
    $core->userChkRole('REGISTRANTS-EDIT');
    if(!$core->chk_POST(array('name', 'type', 'lecturer_id', 'course_var_id', 'start_date', 'end_date', 'lectures_no', 'price', 'rewards'))){
        $core->err(V_URLP.'registrants-add', false);
    }elseif(strlen($_POST['name']) < 3){
        $core->err(V_URLP.'registrants-add', false);
    }

    // Here to update some error conditions!

    if($core->dbI('registrants', array(
        'name'          => $core->aes($_POST['name']),
        'type'          => $core->aes($_POST['type']),
        'lecturer_id'   => $_POST['lecturer_id'],
        'course_var_id' => $core->aes($_POST['course_var_id']),
        'start_date'    => $core->aes($_POST['start_date']),
        'end_date'      => $core->aes($_POST['end_date']),
        'lectures_no'   => $core->aes($_POST['lectures_no']),
        'price'         => $core->aes($_POST['price']),
        'rewards'       => $core->aes($_POST['rewards']),
        'details'       => $core->aes($_POST['details'])
    ))){
        $core->err(V_URLP.'registrants', true);
    }else{
        $core->err(V_URLP.'registrants-add', false);
    }
?>