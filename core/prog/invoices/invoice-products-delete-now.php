<?php
    $core->userChkRole('INVOICES-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('invoices_products', array('invoice_id' => $_GET["id"])))
        $core->err(404);
    elseif($core->dbD('invoices_products', array('invoice_id' => $_GET["id"])))
        if($core->dbD('products_quantities', array('invoice_id' => $_GET["id"])))
            $core->err(V_URLP.'invoices', true);
        else 
            $core->err(V_URLP.'invoices', false);
    else 
        $core->err(V_URLP.'invoices', false);

?>