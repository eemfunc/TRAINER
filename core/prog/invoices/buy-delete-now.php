<?php

    $db_table="invoices_buy";
    $url_link_p="invoices-buy";

    if(!$core->chk_GET('id'))
        $core->err(V_URLP.$url_link_p, false);
    elseif(!$core->dbNumRows('invoices_buy', array('id' => $_GET['id'])))
        $core->err(V_URLP.$url_link_p, false);
    elseif($core->dbD($db_table, array('id' => $_GET['id']))){
        $core->dbD("invoices_buy_products", array("invoice_id" => $_GET['id']));
        $core->err(V_URLP.$url_link_p, true);
    }
    else $core->err(V_URLP.$url_link_p, false);

?>