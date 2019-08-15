<?php
    $core->userChkRole('DISCOUNTS-EDIT');
    if(!$core->chk_GET('id'))
        $core->err();
    elseif(!$core->dbNumRows('discounts', array('id' => $_GET['id'])))
        $core->err();
    elseif($core->dbD('discounts', array('id' => $_GET['id'])))
        $core->err(V_URLP.'discounts', true);
    else
        $core->err(V_URLP.'discounts', false);
?>