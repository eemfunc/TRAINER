<?php
    $core->userChkRole('BRANCHES-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('branches', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('branches', array('id' => $_GET['id'])))
        $core->err(V_URLP.'branches', true);
    else 
        $core->err(V_URLP.'branches', false);
?>