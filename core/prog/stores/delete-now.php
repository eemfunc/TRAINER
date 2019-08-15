<?php
    $core->userChkRole('STORES-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('stores', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('stores', array('id' => $_GET['id'])))
        $core->err(V_URLP.'stores', true);
    else 
        $core->err(V_URLP.'stores', false);

?>