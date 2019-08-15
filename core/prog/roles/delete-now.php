<?php
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('roles', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('roles', array('id' => $_GET['id'])))
        $core->err(V_URLP.'roles', true);
    else 
        $core->err(V_URLP.'roles', false);
?>