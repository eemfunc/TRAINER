<?php
    $core->userChkRole('STORES-TRANSPORT-PRODUCTS-EDIT');
    $core->requireClass('transport-products-class', 'stores');
    $tp = new tp();

    $tp->chkSubTableId((isset($_POST['stores_transport_id'])) ? $_POST['stores_transport_id'] : null);

    if($tp->tpAddNow($_POST['stores_transport_id']))
        $core->err(V_URLP.'stores-transport-products', true);
    else
        $core->err(V_URLP.'stores-transport-products-add&id='.$_POST['stores_transport_id'], false);
?>