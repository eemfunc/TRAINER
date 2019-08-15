<?php
    
    /* CHECK THE $_POST VALUES AND DEFINE VARIABLES */
    $e = false;
    $v = array();
    $chk_arr = array('price_type', 'currency', 'product_id', 'store_id', 'packing_id', 'quantity');
    
    if(!$core->chk_POST($chk_arr))
        $e = true;
    
    if(isset($_POST["invoice_id"])){
        if($_POST["invoice_id"] != '')
            if(!$core->dbNumRows('invoices_products', array('invoice_id' => $_POST["invoice_id"])))
                $e = true;
        $v['invoice_id'] = $_POST["invoice_id"];
    }else $v['invoice_id'] = '';
    
    if(isset($_POST["customer_id"])){
        if($_POST['customer_id'] != ''){
            $customer_id = substr($_POST["customer_id"], -9, -1);
            if(!$core->dbNumRows('customers', array('id' => $customer_id)))
                $e = true;
            $v['customer_id'] = $customer_id;
        }else $v['customer_id'] = '';
    }else $v['customer_id'] = '';
    
    if(isset($_POST["discount_id"])){
        if($_POST['discount_id'] != 0 && $_POST['discount_id'] != ''){
            if(strlen($_POST["discount_id"]) != 8)
                $e = true;
            if(!$core->dbNumRows('discounts', array('id' => $_POST["discount_id"])))
                $e = true;
            $v['discount_id'] = $_POST["discount_id"];
        }else $v['discount_id'] = '';
    }else $v['discount_id'] = '';
    
    $product_id = substr($_POST["product_id"], -9, -1);
    if(!$core->dbNumRows('products', array('id' => $product_id)))
        $e = true;
    else{
        $product_sql_arr = $core->dbFetch('products', array('id' => $product_id));
        $v['product_id']                = $product_id;
        $v['product_name']              = $core->aes($product_sql_arr[0]['name'], 1);
        $v['product_item_no']           = $core->aes($product_sql_arr[0]['item_no'], 1);
        $v['product_retail_usd']        = $core->aes($product_sql_arr[0]['price_retail'], 1);
        $v['product_retail_iqd']        = $core->aes($product_sql_arr[0]['price_retail_iqd'], 1);
        $v['product_wholesale_usd']     = $core->aes($product_sql_arr[0]['price_wholesale'], 1);
        $v['product_wholesale_iqd']     = $core->aes($product_sql_arr[0]['price_wholesale_iqd'], 1);
        $v['product_distribution_usd']  = $core->aes($product_sql_arr[0]['price_distribution'], 1);
        $v['product_distribution_iqd']  = $core->aes($product_sql_arr[0]['price_distribution_iqd'], 1);
    }
    
    if(strlen($_POST["store_id"]) != 8)
        $e = true;
    elseif(!$core->dbNumRows('stores', array('id' => $_POST["store_id"])))
        $e = true;
    else{
        $v['store_id'] = $_POST['store_id'];
        $v['store_name'] = $core->aes($core->dbFetch('stores', array('id' => $_POST["store_id"]))[0]["name"], 1);
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
    
    if($_POST['price_type'] != 'RETAIL' && $_POST['price_type'] != 'WHOLESALE' &&
      $_POST['price_type'] != 'DISTRIBUTION')
        $e = true;
    else 
        $v['price_type'] = $_POST['price_type'];
    
    if($_POST['currency'] != 'IQD' && $_POST['currency'] != 'USD')
        $e = true;
    else 
        $v['currency'] = $_POST['currency'];
    
    $v['quantity'] = 0;
    if(!is_numeric($_POST['quantity']) || $_POST['quantity'] < 1)
        $e = true;
    else
        $v['quantity'] = $_POST['quantity'];

    $q = 0;

    $rows = $core->dbFetch('products_quantities', array(
        'store_id'      => $v['store_id'],
        'product_id'    => $v['product_id']
    ));
    foreach($rows as $r)
        $q += $core->aes($r['quantity'], 1);

    if(($v['quantity'] * $v['packing_quantity']) > $q)
        die($core->mkJson(false, $core->txt('0136')));
    
    if($e)
        die($core->mkJson(false, $core->txt('0001')));

    /* TO CHECK THE invoice_id AND MAKE A NEW ONE IF NEEDED */
    if($v['invoice_id'] == ''){
        $invoice_id = $core->randStr(8, "A-a-0");
        while($core->dbNumRows('invoices_products', array('invoice_id' => $invoice_id)))
            $invoice_id = $core->randStr(8, "A-a-0");
        $v['invoice_id'] = $invoice_id;
    }
    
    $core->requireClass('payments');
    $pay = new payments();
    
    /* FIND THE PRICES */
    if($v['currency'] == 'IQD'){
        if($v['price_type'] == 'RETAIL'){
            if($v['product_retail_iqd'] != '' && $v['product_retail_iqd'] != 0){
                $v['unit_price_iqd'] = $v['product_retail_iqd'];
                if($v['product_retail_usd'] != '' && $v['product_retail_usd'] != 0){
                    $v['unit_price_usd'] = $v['product_retail_usd'];
                }else{
                    $v['unit_price_usd'] = $v['product_retail_iqd'] / $pay->USD_PRICE;
                }
            }elseif($v['product_retail_usd'] != '' && $v['product_retail_usd'] != 0){
                $v['unit_price_iqd'] = $v['product_retail_usd'] * $pay->USD_PRICE;
                $v['unit_price_usd'] = $v['product_retail_usd'];
            }else{
                $v['unit_price_iqd'] = 0;
                $v['unit_price_usd'] = 0;
            }
        }elseif($v['price_type'] == 'WHOLESALE'){
            if($v['product_wholesale_iqd'] != '' && $v['product_wholesale_iqd'] != 0){
                $v['unit_price_iqd'] = $v['product_wholesale_iqd'];
                if($v['product_wholesale_usd'] != '' && $v['product_wholesale_usd'] != 0){
                    $v['unit_price_usd'] = $v['product_wholesale_usd'];
                }else{
                    $v['unit_price_usd'] = $v['product_wholesale_iqd'] / $pay->USD_PRICE;
                }
            }elseif($v['product_wholesale_usd'] != '' && $v['product_wholesale_usd'] != 0){
                $v['unit_price_iqd'] = $v['product_wholesale_usd'] * $pay->USD_PRICE;
                $v['unit_price_usd'] = $v['product_wholesale_usd'];
            }else{
                $v['unit_price_iqd'] = 0;
                $v['unit_price_usd'] = 0;
            }
        }else{
            if($v['product_distribution_iqd'] != '' && $v['product_distribution_iqd'] != 0){
                $v['unit_price_iqd'] = $v['product_distribution_iqd'];
                if($v['product_distribution_usd'] != '' && $v['product_distribution_usd'] != 0){
                    $v['unit_price_usd'] = $v['product_distribution_usd'];
                }else{
                    $v['unit_price_usd'] = $v['product_distribution_iqd'] / $pay->USD_PRICE;
                }
            }elseif($v['product_distribution_usd'] != '' && $v['product_distribution_usd'] != 0){
                $v['unit_price_iqd'] = $v['product_distribution_usd'] * $pay->USD_PRICE;
                $v['unit_price_usd'] = $v['product_distribution_usd'];
            }else{
                $v['unit_price_iqd'] = 0;
                $v['unit_price_usd'] = 0;
            }
        }
        
        $v['unit_price_usd'] = $core->nf($v['unit_price_usd'], false);
        $v['unit_price'] = $core->nf($v['unit_price_iqd']);
        $v['total_price_iqd'] = $core->nf($v['quantity'] * $v['packing_quantity'] * $v['unit_price_iqd'], false);
        $v['total_price_usd'] = $core->nf($v['quantity'] * $v['packing_quantity'] * $v['unit_price_usd'], false);
        $v['total_price'] = $core->nf($v['total_price_iqd']);
        
    }else{
        if($v['price_type'] == 'RETAIL'){
            if($v['product_retail_usd'] != '' && $v['product_retail_usd'] != 0){
                $v['unit_price_usd'] = $v['product_retail_usd'];
                if($v['product_retail_iqd'] != '' && $v['product_retail_iqd'] != 0){
                    $v['unit_price_iqd'] = $v['product_retail_iqd'];
                }else{
                    $v['unit_price_iqd'] = $v['product_retail_usd'] * $pay->USD_PRICE;
                }
            }elseif($v['product_retail_iqd'] != '' && $v['product_retail_iqd'] != 0){
                $v['unit_price_usd'] = $v['product_retail_iqd'] / $pay->USD_PRICE;
                $v['unit_price_iqd'] = $v['product_retail_iqd'];
            }else{
                $v['unit_price_iqd'] = 0;
                $v['unit_price_usd'] = 0;
            }
        }elseif($v['price_type'] == 'WHOLESALE'){
            if($v['product_wholesale_usd'] != '' && $v['product_wholesale_usd'] != 0){
                $v['unit_price_usd'] = $v['product_wholesale_usd'];
                if($v['product_wholesale_iqd'] != '' && $v['product_wholesale_iqd'] != 0){
                    $v['unit_price_iqd'] = $v['product_wholesale_iqd'];
                }else{
                    $v['unit_price_iqd'] = $v['product_wholesale_usd'] * $pay->USD_PRICE;
                }
            }elseif($v['product_wholesale_iqd'] != '' && $v['product_wholesale_iqd'] != 0){
                $v['unit_price_usd'] = $v['product_wholesale_iqd'] / $pay->USD_PRICE;
                $v['unit_price_iqd'] = $v['product_wholesale_iqd'];
            }else{
                $v['unit_price_iqd'] = 0;
                $v['unit_price_usd'] = 0;
            }
        }else{
            if($v['product_distribution_usd'] != '' && $v['product_distribution_usd'] != 0){
                $v['unit_price_usd'] = $v['product_distribution_usd'];
                if($v['product_distribution_iqd'] != '' && $v['product_distribution_iqd'] != 0){
                    $v['unit_price_iqd'] = $v['product_distribution_iqd'];
                }else{
                    $v['unit_price_iqd'] = $v['product_distribution_usd'] * $pay->USD_PRICE;
                }
            }elseif($v['product_distribution_iqd'] != '' && $v['product_distribution_iqd'] != 0){
                $v['unit_price_usd'] = $v['product_distribution_iqd'] / $pay->USD_PRICE;
                $v['unit_price_iqd'] = $v['product_distribution_iqd'];
            }else{
                $v['unit_price_iqd'] = 0;
                $v['unit_price_usd'] = 0;
            }
        }
        
        $v['unit_price_usd'] = $core->nf($v['unit_price_usd']);
        $v['unit_price'] = $core->nf($v['unit_price_usd']);
        $v['total_price_iqd'] = $core->nf($v['quantity'] * $v['packing_quantity'] * $v['unit_price_iqd'], false);
        $v['total_price_usd'] = $core->nf($v['quantity'] * $v['packing_quantity'] * $v['unit_price_usd'], false);
        $v['total_price'] = $core->nf($v['total_price_usd']);
    
    }

    /* ADD ROW TO DATABASE */
    if($core->dbI('invoices_products', array(
        'invoice_id'        => $v['invoice_id'],
        'customer_id'       => $v['customer_id'],
        'price_type'        => $core->aes($v['price_type']),
        'currency'          => $core->aes($v['currency']),
        'discount_id'       => $v['discount_id'],
        'product_id'        => $v['product_id'],
        'store_id'          => $v['store_id'],
        'packing_id'        => $v['packing_id'],
        'quantity'          => $core->aes($v['quantity']),
        'dollar_price'      => $core->aes($pay->USD_PRICE),
        'unit_price_iqd'    => $core->aes($v['unit_price_iqd']),
        'unit_price_usd'    => $core->aes($v['unit_price_usd']),
        'total_price_iqd'   => $core->aes($v['total_price_iqd']),
        'total_price_usd'   => $core->aes($v['total_price_usd'])
    ))){
        $v['invoice_product_id'] = $core->dbFetch('invoices_products', array(
            'invoice_id'    => $v['invoice_id'],
            'product_id'     => $v['product_id'],
            'user_id'       => $core->userData('id')
        ), 'ORDER BY created_at DESC LIMIT 1')[0]["id"];
        if($core->dbNumRows('invoices', array('id' => $v['invoice_id']))){
            $core->dbU("invoices_products", array('draft' => '0'), array('invoice_id' => $v['invoice_id']));
        }
        if($v['price_type'] == 'RETAIL')$pt = ' ('.$core->txt('0110').')';
        elseif($v['price_type'] == 'WHOLESALE')$pt = ' ('.$core->txt('0111').')';
        else $pt = ' ('.$core->txt('0112').')';
        if($v['currency'] == 'IQD')$c = ' '.$core->txt('0134');
        else $c = ' '.$core->txt('0135');
        if($v['customer_id'] != ''){
            $uData = array('customer_id' => $v['customer_id']);
            $core->dbU("invoices_products", $uData, array("invoice_id" => $v['invoice_id']));
        }
        
        $core->dbI('products_quantities', array(
            'product_id'    => $v['product_id'],
            'store_id'      => $v['store_id'],
            'quantity'      => $core->aes($v['quantity'] * $v['packing_quantity'] * -1),
            'invoice_id'    => $v['invoice_id']
        ));
        


        /* The following is to calculate the discounted invoice total at the bottom of invoices-add */
        $x = 0;
        $rows = $core->dbFetch('invoices_products', array('invoice_id' => $v['invoice_id']));
        foreach($rows as $r){
            if($v['currency'] == 'USD'){
                $x += $core->aes($r['total_price_usd'], 1);
            }else{
                $x += $core->aes($r['total_price_iqd'], 1);
            }
            $discount_id = $r['discount_id'];
        }
        $discount = ($discount_id == null) ? 0 : $core->aes($core->dbFetch('discounts', array('id' => $discount_id))[0]['percentage'], 1);
        $x -= $x * $discount / 100;
        $invoice_total = $core->nf($x);


        die($core->mkJson(true, "", array(
            'invoice_id'            => $v['invoice_id'],
            'product_name'          => $v['product_name'].' (<span>&#x200F;'.$v['product_item_no'].'</span>)',
            'store_name'            => $v['store_name'],
            'quantity'              => $core->nf($v['quantity']).' '.$v['packing_name'].' ('.$v['packing_quantity'].')',
            'unit_price'            => $v['unit_price'].$c.$pt,
            'total_price'           => $v['total_price'].$c,
            'invoice_product_id'    => $v['invoice_product_id'],
            'invoice_total'         => $invoice_total
        )));
    }else{
        die($core->mkJson(false, $core->txt('0002')));
    }
    
?>