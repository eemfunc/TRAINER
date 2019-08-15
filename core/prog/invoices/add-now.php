<?php 
    $core->userChkRole('INVOICES-EDIT');

    /* CHECK THE $_POST VALUES AND DEFINE VARIABLES */
    $e = false;
    $v = array();
    
    if(isset($_POST["invoice_id"])){
        if($_POST["invoice_id"] != '')
            if(!$core->dbNumRows('invoices_products', array('invoice_id' => $_POST["invoice_id"])))
                $e = true;
            if($core->dbNumRows('invoices', array('id' => $_POST["invoice_id"])))
                $e = true;
            if(!$core->dbNumRows('invoices_temp', array('invoice_id' => $_POST["invoice_id"])))
                $e = true;
        $v['invoice_id'] = $_POST["invoice_id"];
    }else $v['invoice_id'] = '';

    if($e)
        $core->err(V_URLP.'invoices', false);
    $e = false;

    if(!isset($_POST['currency']))$e = true;
    elseif($_POST['currency'] != 'USD' && $_POST['currency'] != 'IQD' && $_POST['currency'] != '')$e = true;
    if(isset($_POST['first_payment'])){
        if($_POST['first_payment'] != '' && !is_numeric($_POST['first_payment']))$e = true;
        elseif($_POST['first_payment'] != '' && $_POST['first_payment'] <= 0)$e = true;
        elseif(($_POST['first_payment'] != '' && $_POST['first_payment'] != 0) && $_POST['currency'] == '')$e = true;
        elseif($_POST['first_payment'] == '' || $_POST['first_payment'] == 0){
            $v['currency'] = '';
            $v['first_payment'] = '';
        }else{
            $v['currency'] = $_POST['currency'];
            $v['first_payment'] = $_POST['first_payment'];
        }
    }else{
        $v['currency'] = '';
        $v['first_payment'] = '';
    }

    if(!isset($_POST['delivery']))$e = true;
    elseif($_POST['delivery'] == '')$v['delivery'] = '';
    else $v['delivery'] = $core->aes($_POST['delivery']);

    if(!isset($_POST['details']))$e = true;
    elseif($_POST['details'] == '')$v['details'] = '';
    else $v['details'] = $core->aes($_POST['details']);

    if($e){
        $core->dbD("invoices_temp", array("invoice_id" => $v['invoice_id']));
        $core->err(V_URLP.'invoices-add&id='.$v['invoice_id'], false);
    }

    /* DATA PREPARATION */
    if($v['first_payment'] != ''){
        $v['first_payment'] = $core->aes($v['first_payment']);
    }
    $invoice_arr                    = $core->dbFetch('invoices_temp', array('invoice_id' => $v['invoice_id']));
    $v['user_id']                   = $invoice_arr[0]['user_id'];
    $v['invoice_total']             = $invoice_arr[0]['invoice_total'];
    $v['invoice_total_discount']    = $invoice_arr[0]['invoice_total_discount'];















    $core->requireClass('payments');
    $pay = new payments();

    /* CHECK THE CREDIT LIMIT */
    $ip_arr = $core->dbFetch('invoices_products', array('invoice_id' => $v['invoice_id']), 'ORDER BY created_at DESC LIMIT 1');
    $v['customer_id'] = $ip_arr[0]['customer_id'];
    $v['invoice_currency'] = $core->aes($ip_arr[0]['currency'], 1);
    $credit_limit = $core->aes($core->dbFetch('customers', array('id' => $v['customer_id']))[0]['credit_limit'], 1);
    if($credit_limit != '')
        if(is_numeric($credit_limit))
            if($credit_limit > 0 && $v['first_payment'] != ''){
                $inv_total = $core->aes($v['invoice_total_discount'], 1);
                $fp = $core->aes($v['first_payment'], 1);
                $fp_usd = 0;
                $fp_iqd = 0;
                $dt_usd = $pay->getDebts($v['customer_id'], 'USD');
                $dt_iqd = $pay->getDebts($v['customer_id'], 'IQD');
                $error_credit_limit = false;
                if($v['currency'] == 'USD'){
                    $fp_usd = $fp;
                    $fp_iqd = $fp * $pay->USD_PRICE;
                }else{
                    $fp_usd = $fp / $pay->USD_PRICE;
                    $fp_iqd = $fp;
                }
                if($v['invoice_currency'] == 'USD'){
                    if(($inv_total + $dt_usd - $fp_usd) > $credit_limit)
                        $error_credit_limit = true;
                }else{
                    if((($inv_total + $dt_iqd - $fp_iqd) / $pay->USD_PRICE) > $credit_limit)
                        $error_credit_limit = true;
                }
                if($error_credit_limit){
                    $core->dbD("invoices_temp", array("invoice_id" => $v['invoice_id']));
                    $core->err(V_URLP.'invoices-add&id='.$v['invoice_id'], 'f_credit_limit');
                }
                
            }

    /* ADD TO DB */
    if($core->dbD('invoices_temp', array('invoice_id' => $v['invoice_id']))){

        if($core->dbI('invoices', array(
            'id'                        => $v['invoice_id'],
            'invoice_total'             => $v['invoice_total'],
            'invoice_total_discount'    => $v['invoice_total_discount'],
            'first_payment'             => $v['first_payment'],
            'delivery'                  => $v['delivery'],
            'details'                   => $v['details'],
            'customer_id'               => $v['customer_id'],
            'branch_id'                 => $core->userData('branch_id')
        )))
            $core->dbU('invoices_products', array('draft' => '0'), array('invoice_id' => $v['invoice_id']));
            
            /* PROCESS DEBTS */
            if($v['invoice_currency'] == 'USD'){
                $credit_iqd = '';
                $credit_usd = $v['invoice_total_discount'];
            }else{
                $credit_iqd = $v['invoice_total_discount'];
                $credit_usd = '';
            }
            $core->dbI('transactions', array(
                'customer_id'   => $v['customer_id'],
                'invoice_id'    => $v['invoice_id'],
                'credit_iqd'    => $core->aes($credit_iqd),
                'credit_usd'    => $core->aes($credit_usd),
                'dollar_price'  => $core->aes($pay->USD_PRICE)
            ));
            $customer_arr = $core->dbFetch('customers', array('id' => $v['customer_id']));
            $debts_usd = $core->aes($customer_arr[0]['debts_usd'], 1);
            $debts_iqd = $core->aes($customer_arr[0]['debts_iqd'], 1);
            if($debts_usd == '' || !is_numeric($debts_usd))
                $debts_usd = 0;
            if($debts_iqd == '' || !is_numeric($debts_iqd))
                $debts_iqd = 0;
            if($v['invoice_currency'] == 'USD')
                $debts_usd += $core->aes($v['invoice_total_discount'], 1);
            else
                $debts_iqd += $core->aes($v['invoice_total_discount'], 1);
            if($v['first_payment'] != ''){
                if($v['currency'] == 'USD'){
                    $debit_iqd = '';
                    $debit_usd = $v['first_payment'];
                    
                    if($debts_usd >= $_POST['first_payment'])
                        $debts_usd -= $_POST['first_payment'];
                    else{
                        $debts_usd_diff = $_POST['first_payment'] - $debts_usd;
                        $debts_usd = 0;
                        $debts_usd_diff_to_iqd = $debts_usd_diff * $pay->USD_PRICE;
                        if($debts_iqd >= $debts_usd_diff_to_iqd)
                            $debts_iqd -= $debts_usd_diff_to_iqd;
                        else{
                            $debts_iqd_diff = $debts_usd_diff_to_iqd - $debts_iqd;
                            $debts_iqd = 0;
                            $debts_iqd_diff_to_usd = $debts_iqd_diff / $pay->USD_PRICE;
                            $debts_usd = $debts_iqd_diff_to_usd * -1;
                        }
                    }
                }else{
                    $debit_iqd = $v['first_payment'];
                    $debit_usd = '';
                    
                    if($debts_iqd >= $_POST['first_payment'])
                        $debts_iqd -= $_POST['first_payment'];
                    else{
                        $debts_iqd_diff = $_POST['first_payment'] - $debts_iqd;
                        $debts_iqd = 0;
                        $debts_iqd_diff_to_usd = $debts_iqd_diff / $pay->USD_PRICE;
                        if($debts_usd >= $debts_iqd_diff_to_usd)
                            $debts_usd -= $debts_iqd_diff_to_usd;
                        else{
                            $debts_usd_diff = $debts_iqd_diff_to_usd - $debts_usd;
                            $debts_usd = 0;
                            $debts_usd_diff_to_iqd = $debts_usd_diff * $pay->USD_PRICE;
                            $debts_iqd = $debts_usd_diff_to_iqd * -1;
                        }
                    }
                }
                $core->dbI('transactions', array(
                    'customer_id'   => $v['customer_id'],
                    'invoice_id'    => $v['invoice_id'],
                    'debit_iqd'     => $core->aes($debit_iqd),
                    'debit_usd'     => $core->aes($debit_usd),
                    'dollar_price'  => $core->aes($pay->USD_PRICE)
                ));
            }
            $core->dbU("customers", array(
                'debts_iqd'     => $core->aes($debts_iqd),
                'debts_usd'     => $core->aes($debts_usd)
            ), array("id" => $v['customer_id']));
            $core->err(V_URLP.'invoices-add&id='.$v['invoice_id'], true);
        }else{
            $core->err(V_URLP.'invoices-add&id='.$v['invoice_id'], false);
        }

?>