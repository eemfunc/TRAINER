<?php
    $core->userChkRole('USERS-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('users', array('id' => $_GET['id'])))
        $core->err(404);
    else{
        if($core->chk_GET('v'))
            if($_GET['v'] == 1)
                $v = 1;
            else
                $v = 0;
        if($core->dbU("users", array('activated' => $v), array('id' => $_GET['id'])))
            $core->err(V_URLP.'users', true);
        else 
            $core->err(V_URLP.'users', false);
    }
?>