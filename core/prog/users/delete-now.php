<?php
    $core->userChkRole('USERS-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('users', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('users', array('id' => $_GET['id'])))
        $core->err(V_URLP.'users', true);
    else 
        $core->err(V_URLP.'users', false);

?>