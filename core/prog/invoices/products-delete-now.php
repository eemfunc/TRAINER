<?php
    $core->userChkRole('INVOICES-EDIT');
    if(!$core->chk_GET(array('id', 'invoice_id'))){
        $core->err(404);
    }
    
    if(!$core->dbNumRows('invoices_products', array('id' => $_GET['id']))){
        $core->err(404);
    }else{
        $ip_arr = $core->dbFetch('invoices_products', array('id' => $_GET['id']));
        $quantity   = $core->aes($ip_arr[0]['quantity'], 1);
        $packing_id = $ip_arr[0]['packing_id'];
        $store_id   = $ip_arr[0]['store_id'];
        if($core->dbD('invoices_products', array('id' => $_GET['id']))){
            if($packing_id == 1)
                $p_q = 1;
            else $p_q = $core->aes($core->dbFetch('packing', array('id' => $packing_id))[0]['quantity'], 1);
            $q = $quantity * $p_q * -1;
            if($core->dbD('products_quantities', array(
                'invoice_id'    => $_GET['invoice_id'],
                'quantity'      => $core->aes($q),
                'store_id'      => $store_id
            ))){
                if(!$core->dbNumRows('invoices_products', array('invoice_id' => $_GET['invoice_id']))){
                    $core->err(V_URLP.'invoices-add', true);
                }else{
                    $core->err(V_URLP.'invoices-add&id='.$_GET['invoice_id'], true);
                }
            }else{
                $core->err(V_URLP.'invoices-add&id='.$_GET['invoice_id'], false);
            }
        }else{
            $core->err(V_URLP.'invoices-add&id='.$_GET['invoice_id'], false);
        }    
    }

?>