<?php
    $core->userChkRole('STORES-TRANSPORT-PRODUCTS-EDIT');
    $core->requireClass('transport-products-class', 'stores');
    $tp = new tp();

    $tp->chkSTPI((isset($_GET['id'])) ? $_GET['id'] : null);
    $tp->chkSubTableId((isset($_GET['stores_transport_id'])) ? $_GET['stores_transport_id'] : null);

    if($tp->deleteProductFromTp($_GET['id'], $_GET['stores_transport_id']))
        $core->err(V_URLP.'stores-transport-products-add&id='.$_GET['stores_transport_id'], true);
    else
        $core->err(V_URLP.'stores-transport-products-add&id='.$_GET['stores_transport_id'], false);
?>