<?php
    $core->userChkRole('CUSTOMERS-DELETE');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('customers', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('customers', array('id' => $_GET['id'])))
        $core->err(V_URLP.'customers', true);
    else 
        $core->err(V_URLP.'customers', false);
?>