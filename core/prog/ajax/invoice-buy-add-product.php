<?php

$chk_arr = array("product_id", "quantity", "price");

if($core->chk_GET($chk_arr)){
        
    /* TO CHECK THE $_GET VALUES */
    if(strlen($_GET[$chk_arr[0]])<1 || !is_numeric($_GET[$chk_arr[1]]) || !is_numeric($_GET[$chk_arr[2]]))
        die($core->mkJson(false, $core->txt('0001')));
    
    /* ADD OR EDIT */
    $update = false;
    
    /* TO CHECK THE invoice_buy_id AND MAKE A NEW ONE IF NEEDED */
    if(isset($_GET["invoice_buy_id"]))
        if($_GET["invoice_buy_id"] != ""){
            $invoice_buy_id = $_GET["invoice_buy_id"];
            $update = true;
        }
    if(!$update){
        $invoice_buy_id = $core->randStr(8, "A-a-0");
        while($core->dbNumRows('invoices_buy', array('id' => $invoice_buy_id)) > 0)
            $invoice_buy_id = $core->randStr(8, "A-a-0");
    }
    
    /* ADD ROW TO DATABASE */
    if($core->dbNumRows('invoices_buy', array('id' => $invoice_buy_id))){
        $data_arr = array(
            'invoice_id'    => $invoice_buy_id,
            'product_id'    => substr($_GET["product_id"], -9, -1),
            'quantity'      => $core->aes($_GET["quantity"]),
            'price'         => $core->aes($_GET["price"]),
            'draft'         => 0
        );
    }else{
        $data_arr = array(
            'invoice_id'    => $invoice_buy_id,
            'product_id'    => substr($_GET["product_id"], -9, -1),
            'quantity'      => $core->aes($_GET["quantity"]),
            'price'         => $core->aes($_GET["price"])
        );
    }
    if($core->dbI('invoices_buy_products', $data_arr))
        die($core->mkJson(true, "", array("invoice_buy_id" => $invoice_buy_id)));
    else die($core->mkJson(false, $core->txt('0001')));
    
}else die($core->mkJson(false, $core->txt('0001')));

?>