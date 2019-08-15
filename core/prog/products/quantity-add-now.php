<?php
    $core->userChkRole('PRODUCTS-QUANTITY-EDIT');
    
    if(!$core->chk_POST('product_id') || (!$core->chk_POST('add_quantity') && !$core->chk_POST('decrease_quantity')))
        $core->err(404);
    elseif($core->chk_POST(array('store_id', 'details'))){
        
        if($_POST['add_quantity'] != '')
            $quantity = $_POST['add_quantity'];
        else
            $quantity = '-'.$_POST['decrease_quantity'];

        if(!is_numeric($quantity) || $quantity == 0)
            $core->err(V_URLP.'products-quantity-edit&id='.$_POST['product_id'], false);
            
        if($core->dbI('products_quantities', array(
            'product_id'    => $_POST['product_id'],
            'store_id'      => $_POST['store_id'],
            'quantity'      => $core->aes($quantity),
            'details'       => $core->aes($_POST['details'])
        )))
            $core->err(V_URLP.'products-quantity-edit&id='.$_POST['product_id'], true);
        else 
            $core->err(V_URLP.'products-quantity-edit&id='.$_POST['product_id'], false);
        
    }else $core->err(V_URLP.'products-quantity-edit&id='.$_POST['product_id'], false);
?>