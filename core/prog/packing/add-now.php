<?php
    $core->userChkRole('PACKING-EDIT');

    if(!$core->chk_GET('id') || !$core->chk_POST('quantity'))
        $core->err(404);
    elseif(!$core->dbNumRows('products', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($_POST['quantity'] < 2)
        $core->err(V_URLP.'packing-add&id='.$_GET['id'], false);

    if($core->dbI('packing', array(
        'name'          => $core->aes($_POST['name']),
        'quantity'      => $core->aes($_POST['quantity']),
        'product_id'    => $_POST['product_id']
    )))
        $core->err(V_URLP.'packing&id='.$_GET['id'], true);
    else
        $core->err(V_URLP.'packing-add&id='.$_GET['id'], false);

?>