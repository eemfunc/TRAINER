<?php

    if(!empty($_POST)){
        if($core->chk_POST(array('invoice_buy_id', 'title'))){
            
            $id = $_POST['invoice_buy_id'];
            if(isset($_POST['importer_id']))$x0 = substr($_POST['importer_id'], -9, 8);else $x0 = '';
            $x1 = $core->aes($_POST['title']);
            $x2 = $core->aes($_POST['invoice_no']);
            $x3 = $core->aes($_POST['company']);
            $x4 = $core->aes($_POST['description']);
            
            $core->requireClass('payments');
            $pay = new payments();
            
            if(!$core->dbNumRows('invoices_buy', array('id' => $id))){
                if($x0 != ''){
                    $res = $core->dbI('invoices_buy', array(
                        'id'            => $id,
                        'importer_id'   => $x0,
                        'title'         => $x1,
                        'invoice_no'    => $x2,
                        'company'       => $x3,
                        'description'   => $x4,
                        'dollar_price'  => $core->aes($pay->USD_PRICE)
                    ));
                }else{
                    $res = $core->dbI('invoices_buy', array(
                        'id'            => $id,
                        'title'         => $x1,
                        'invoice_no'    => $x2,
                        'company'       => $x3,
                        'description'   => $x4,
                        'dollar_price'  => $core->aes($pay->USD_PRICE)
                    ));
                }
                if($res){
                    $core->dbU("invoices_buy_products", array('draft' => '0'), array("invoice_id" => $id));
                    $core->err(V_URLP.'invoices-buy', true);
                }else{
                    $core->err(V_URLP.'invoices-buy-add&id='.$id, false);
                }
            }else{
                if($x0 != ''){
                    $res = $core->dbU("invoices_buy", array(
                        'importer_id'   => $x0,
                        'title'         => $x1,
                        'invoice_no'    => $x2, 
                        'company'       => $x3, 
                        'description'   => $x4
                    ), array("id" => $id));
                }else{
                    $res = $core->dbU("invoices_buy", array(
                        'title'         => $x1,
                        'invoice_no'    => $x2, 
                        'company'       => $x3, 
                        'description'   => $x4
                    ), array("id" => $id));
                }
                if($res){
                    $core->dbU("invoices_buy_products", array('draft' => '0'), array("invoice_id" => $id));
                    $core->err(V_URLP.'invoices-buy', true);
                }else{
                    $core->err(V_URLP.'invoices-buy-add&id='.$id, false);
                }
            }
        }else{
            $core->err(V_URLP.'invoices-buy', false);
        }
    }

?>