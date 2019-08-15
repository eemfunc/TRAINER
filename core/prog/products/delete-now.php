<?php
    $core->userChkRole('PRODUCTS-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('products', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('products', array('id' => $_GET['id'])))
        $core->err(V_URLP.'products', true);
    else
        $core->err(V_URLP.'products', false);
?>