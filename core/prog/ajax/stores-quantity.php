<?php

if($core->chk_POST(array('store_id', 'product_id'))){
    $quantity = 0;
    $rows = $core->dbFetch('products_quantities', array(
        'store_id'     => $_POST['store_id'],
        'product_id'    => $_POST['product_id']
    ));
    foreach($rows as $r)
        $quantity = $quantity + $core->aes($r['quantity'], 1);
    echo $quantity;
}else 
    die($core->txt('0001'));

?>