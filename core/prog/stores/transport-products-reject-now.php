<?php
    $core->userChkRole('STORES-TRANSPORT-PRODUCTS-EDIT');
    $core->requireClass('transport-products-class', 'stores');
    $tp = new tp();

    $tp->chkMainTableId((isset($_GET['id'])) ? $_GET['id'] : null);
    
    if($tp->rejectTp($_GET['id']))
        $core->err(V_URLP.'stores-transport-products', true);
    else
        $core->err(V_URLP.'stores-transport-products', false);
?>