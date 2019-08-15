<?php

    /* CHECK THE $_POST VALUES AND DEFINE VARIABLES */
    $e = false;
    $v = array();

    if(!$core->userHaveRole('STORES-TRANSPORT-PRODUCTS-EDIT'))
        $e = true;
    
    if(!$core->chk_POST(array('product_id', 'packing_id', 'quantity')))
        $e = true;
    
    if(isset($_POST["stores_transport_id"])){
        if($_POST["stores_transport_id"] != '')
            if(!$core->dbNumRows('stores_transport_products', array('stores_transport_id' => $_POST["stores_transport_id"])))
                $e = true;
        $v['stores_transport_id'] = $_POST["stores_transport_id"];
    }else
        $v['stores_transport_id'] = '';

    $product_id = substr($_POST["product_id"], -9, -1);
    if(!$core->dbNumRows('products', array('id' => $product_id)))
        $e = true;
    else{
        $product_sql_arr = $core->dbFetch('products', array('id' => $product_id));
        $v['product_id']        = $product_id;
        $v['product_name']      = $core->aes($product_sql_arr[0]['name'], 1);
        $v['product_item_no']   = $core->aes($product_sql_arr[0]['item_no'], 1);
    }
    
    if(strlen($_POST["store_id_from"]) != 8)
        $e = true;
    elseif(!$core->dbNumRows('stores', array('id' => $_POST["store_id_from"])))
        $e = true;
    else{
        $v['store_id_from'] = $_POST['store_id_from'];
        $v['store_name'] = $core->aes($core->dbFetch('stores', array('id' => $_POST["store_id_from"]))[0]["name"], 1);
    }

    if(strlen($_POST["store_id_to"]) != 8)
        $e = true;
    elseif(!$core->dbNumRows('stores', array('id' => $_POST["store_id_to"])))
        $e = true;
    else{
        $v['store_id_to'] = $_POST['store_id_to'];
        $v['store_name'] = $core->aes($core->dbFetch('stores', array('id' => $_POST["store_id_to"]))[0]["name"], 1);
    }

    if($_POST["packing_id"] == 1){
        $v['packing_id']        = 1;
        $v['packing_name']      = $core->txt('0129');
        $v['packing_quantity']  = 1;
    }elseif(strlen($_POST["packing_id"]) != 8)
        $e = true;
    elseif(!$core->dbNumRows('packing', array('id' => $_POST["packing_id"])))
        $e = true;
    else{
        $packing_sql_arr = $core->dbFetch('packing', array('id' => $_POST['packing_id']));
        $v['packing_id']        = $_POST['packing_id'];
        $v['packing_name']      = $core->aes($packing_sql_arr[0]['name'], 1);
        $v['packing_quantity']  = $core->aes($packing_sql_arr[0]['quantity'], 1);
    }
    
    $v['quantity'] = 0;
    if(!is_numeric($_POST['quantity']) || $_POST['quantity'] < 1)
        $e = true;
    else
        $v['quantity'] = $_POST['quantity'];

    $q = 0;
    $rows = $core->dbFetch('products_quantities', array(
        'store_id'      => $v['store_id_from'],
        'product_id'    => $v['product_id']
    ));
    foreach($rows as $r){
        $q+= $core->aes($r['quantity'], 1);
    }
    if(($v['quantity'] * $v['packing_quantity']) > $q){
        die($core->mkJson(false, $core->txt('0136')));
    }
    if($e){
        die($core->mkJson(false, $core->txt('0001')));
    }

    /* TO CHECK THE stores_transport_id AND MAKE A NEW ONE IF NEEDED */
    if($v['stores_transport_id'] == ''){
        $stores_transport_id = $core->randStr(8, "A-a-0");
        while($core->dbNumRows('stores_transport_products', array('stores_transport_id' => $stores_transport_id)))
            $stores_transport_id = $core->randStr(8, "A-a-0");
        $v['stores_transport_id'] = $stores_transport_id;
    }

    /* ADD ROW TO DATABASE */
    $v['stores_transport_product_id'] = $core->newRandomID('stores_transport_products');

    $res = $core->dbI('stores_transport_products', array(
        'stores_transport_id'   => $v['stores_transport_id'],
        'product_id'            => $v['product_id'],
        'store_id_from'         => $v['store_id_from'],
        'store_id_to'           => $v['store_id_to'],
        'packing_id'            => $v['packing_id'],
        'quantity'              => $core->aes($v['quantity'])
    ));

    if($res){
        
        if($core->dbNumRows('stores_transport', array('id' => $v['stores_transport_id'])))
            $core->dbU("stores_transport_products", array('draft' => '0'), array("stores_transport_id" => $v['stores_transport_id']));
        
        if($v['store_id_from'] != null)
            $core->dbU("stores_transport_products", array('store_id_to' => $v['store_id_from']), array("stores_transport_id" => $v['stores_transport_id']));
        
        if($v['store_id_to'] != null)
            $core->dbU("stores_transport_products", array('store_id_to' => $v['store_id_to']), array("stores_transport_id" => $v['stores_transport_id']));
        
        $core->dbI('products_quantities', array(
            'product_id'                    => $v['product_id'],
            'store_id'                      => $v['store_id_from'],
            'quantity'                      => $core->aes($v['quantity'] * $v['packing_quantity'] * -1),
            'stores_transport_id'           => $v['stores_transport_id'],
            'stores_transport_product_id'   => $v['stores_transport_product_id']
        ));
        
        die($core->mkJson(true, '', array(
            'stores_transport_id' => $v['stores_transport_id'],
            'product_name' => $v['product_name'].' (<span>&#x200F;'.$v['product_item_no'].'</span>)',
            'quantity' => $core->nf($v['quantity']).' '.$v['packing_name'].' ('.$v['packing_quantity'].')',
            'stores_transport_product_id' => $v['stores_transport_product_id']
        )));
    }else{
        die($core->mkJson(false, $core->txt('0002')));
    }
    
?>