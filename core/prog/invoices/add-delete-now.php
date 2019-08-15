<?php
    $core->userChkRole('INVOICES-EDIT');
    if(!isset($_GET['invoice_id']))
        $core->err(404);
    elseif(!$core->dbNumRows('invoices', array('id' => $_GET['invoice_id'])))
        $core->err(404);
    elseif($core->dbD('invoices', array('id' => $_GET['invoice_id'])))
        $core->err(V_URLP.'invoices-add&id='.$_GET['invoice_id'], true);
    else 
        $core->err(V_URLP.'invoices-add&id='.$_GET['invoice_id'], false);
?>