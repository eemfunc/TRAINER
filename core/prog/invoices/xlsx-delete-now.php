<?php
    $core->userChkRole('INVOICES-XLSX');

    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('invoices_xlsx', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('invoices_xlsx', array('id' => $_GET['id'])))
        $core->err(V_URLP.'invoices-xlsx', true);
    else
        $core->err(V_URLP.'invoices-xlsx', false);

?>