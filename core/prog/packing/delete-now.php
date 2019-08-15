<?php
    $core->userChkRole('PACKING-EDIT');
    if(!$core->chk_GET(array('id', 'product_id')))
        $core->err(404);
    elseif(!$core->dbNumRows('products', array('id' => $_GET['product_id'])))
        $core->err(404);
    elseif(!$core->dbNumRows('packing', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('packing', array('id' => $_GET['id'])))
        $core->err(V_URLP.'packing&id='.$_GET['product_id'], true);
    else
        $core->err(V_URLP.'packing&id='.$_GET['product_id'], false);
?>