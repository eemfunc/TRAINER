<?php

class payments{
    
    public $USD_PRICE = 0;
    
    function __construct(){
        $this->getUsdPriceFromDB();
    }
    
    private function getUsdPriceFromDB(){
        global $core;
        if($core->dbNumRows('dollar', null, 'ORDER BY created_at DESC LIMIT 1'))
            $this->USD_PRICE = $core->aes($core->dbFetch('dollar', null, 'ORDER BY created_at DESC LIMIT 1')[0]['price'], 1);
        else $this->USD_PRICE = 0;
        return true;
    }
    
    public function getDebts($customerID, $type = 'DEFAULT'){
        global $core;
        $customer_arr = $core->dbFetch('customers', array('id' => $customerID));
        $debts_usd_sql = $core->aes($customer_arr[0]['debts_usd'], 1);
        $debts_iqd_sql = $core->aes($customer_arr[0]['debts_iqd'], 1);
        if($debts_usd_sql == '' || !is_numeric($debts_usd_sql))
            $debts_usd_only = 0;
        else
            $debts_usd_only = $debts_usd_sql;
        if($debts_iqd_sql == '' || !is_numeric($debts_iqd_sql))
            $debts_iqd_only = 0;
        else
            $debts_iqd_only = $debts_iqd_sql;
        $total_debts_usd = $debts_usd_sql + ($debts_iqd_sql / $this->USD_PRICE);
        $total_debts_iqd = $debts_iqd_sql + ($debts_usd_sql * $this->USD_PRICE);
        if($total_debts_iqd == 0)
            $total_debts_iqd_view = 0;
        else $total_debts_iqd_view = $core->nf($total_debts_iqd).' '.$core->txt('0134');
        if($total_debts_usd == 0)
            $total_debts_usd_view = 0;
        else $total_debts_usd_view = $core->nf($total_debts_usd).' '.$core->txt('0135');
        if($total_debts_iqd_view == 0)
            $total_debts_view = 0;
        else $total_debts_view = $total_debts_iqd_view.' ( '.$total_debts_usd_view.' )';
        switch($type){
            case 'IQD':
                return $total_debts_iqd;
                break;
            case 'IQD-CUR':
                return $total_debts_iqd_view;
                break;
            case 'IQD-ONLY':
                return $debts_iqd_only;
                break;
            case 'USD':
                return $total_debts_usd;
                break;
            case 'USD-CUR':
                return $total_debts_usd_view;
                break;
            case 'USD-ONLY':
                return $debts_usd_only;
                break;
            case 'DEFAULT':
            case 'IQD-CUR-USD-CUR':
            default:
                return $total_debts_view;
        }
    }
    
    public function makePayment($customerID, $currency, $amount, $oc = true, $transId = null){
        global $core;
        $e = false;
        if($customerID == null){
            $e = true;
        }elseif(!$core->dbNumRows('customers', array('id' => $customerID), null, $oc)){
            $e = true;
        }elseif($currency != 'USD' && $currency != 'IQD'){
            $e = true;
        }elseif(!is_numeric($amount)){
            $e = true;
        }
        /* IN CASE HE HAS MONEY TO TAKE BACK, THE SYSTEM SHOULD ACCEPT NEGATIVE $amount */
        /* elseif($amount <= 0)$e = true; */
        if($e){
            return false;
        }
        /* CHECK IF THE DEBTS ARE LESS THAN THE PAYMENT AMOUNT */
        /*
        if($this->getDebts($customerID, 'IQD') == 0)
            $e = true;
        elseif($currency == 'IQD' && $this->getDebts($customerID, 'IQD') < $amount)
            $e = true;
        elseif($currency == 'USD' && $this->getDebts($customerID, 'USD') < $amount)
            $e = true;
        if($e)
            return false;
        */
        $debts_usd = $this->getDebts($customerID, 'USD-ONLY');
        $debts_iqd = $this->getDebts($customerID, 'IQD-ONLY');
        if($currency == 'USD'){
            $debit_iqd = '';
            $debit_usd = $amount;
            if($debts_usd >= $amount)
                $debts_usd -= $amount;
            else{
                $debts_usd_diff = $amount - $debts_usd;
                $debts_usd = 0;
                $debts_usd_diff_to_iqd = $debts_usd_diff * $this->USD_PRICE;
                if($debts_iqd >= $debts_usd_diff_to_iqd)
                    $debts_iqd -= $debts_usd_diff_to_iqd;
                else{
                    $debts_iqd_diff = $debts_usd_diff_to_iqd - $debts_iqd;
                    $debts_iqd = 0;
                    $debts_iqd_diff_to_usd = $debts_iqd_diff / $this->USD_PRICE;
                    $debts_usd = $debts_iqd_diff_to_usd * -1;
                }
            }
        }else{
            $debit_iqd = $amount;
            $debit_usd = '';
            if($debts_iqd >= $amount)
                $debts_iqd -= $amount;
            else{
                $debts_iqd_diff = $amount - $debts_iqd;
                $debts_iqd = 0;
                $debts_iqd_diff_to_usd = $debts_iqd_diff / $this->USD_PRICE;
                if($debts_usd >= $debts_iqd_diff_to_usd)
                    $debts_usd -= $debts_iqd_diff_to_usd;
                else{
                    $debts_usd_diff = $debts_iqd_diff_to_usd - $debts_usd;
                    $debts_usd = 0;
                    $debts_usd_diff_to_iqd = $debts_usd_diff * $this->USD_PRICE;
                    $debts_iqd = $debts_usd_diff_to_iqd * -1;
                }
            }
        }
        $dbI_arr = array(
            'customer_id'   => $customerID, 
            'debit_iqd'     => $core->aes($debit_iqd),
            'debit_usd'     => $core->aes($debit_usd),
            'dollar_price'  => $core->aes($this->USD_PRICE),
            'currency'      => $core->aes($currency),
            'branch_id'     => $core->userData('branch_id')
        );
        if($transId != null){
            $dbI_arr['id'] = $transId;
        }
        if(!$core->dbI('transactions', $dbI_arr, $oc))
            return false;
        elseif(!$core->dbU('customers', array(
            'debts_iqd' => $core->aes($debts_iqd),
            'debts_usd' => $core->aes($debts_usd)
        ), array('id' => $customerID), $oc))
            return false;
        else
            return true;
    }

    public function addDebts($customerID, $currency, $amount, $oc = true){
        global $core;
        $e = false;
        if($customerID == null){
            $e = true;
        }elseif(!$core->dbNumRows('customers', array('id' => $customerID), null, $oc)){
            $e = true;
        }elseif($currency != 'USD' && $currency != 'IQD'){
            $e = true;
        }elseif(!is_numeric($amount)){
            $e = true;
        }
        if($e){
            return false;
        }
        
        $debts_usd = $this->getDebts($customerID, 'USD-ONLY');
        $debts_iqd = $this->getDebts($customerID, 'IQD-ONLY');
        if($currency == 'USD'){
            $credit_iqd = '';
            $credit_usd = $amount;
            $debts_usd += $amount;
        }else{
            $credit_iqd = $amount;
            $credit_usd = '';
            $debts_iqd += $amount;
        }
        if(!$core->dbI('transactions', array(
            'customer_id'   => $customerID,
            'credit_iqd'    => $core->aes($credit_iqd),
            'credit_usd'    => $core->aes($credit_usd),
            'dollar_price'  => $core->aes($this->USD_PRICE),
            'currency'      => $core->aes($currency),
            'branch_id'     => $core->userData('branch_id'),
            'details'       => $core->aes('PREVIOUS-DEBTS')
        ), $oc)){
            return false;
        }elseif(!$core->dbU('customers', array(
            'debts_iqd' => $core->aes($debts_iqd),
            'debts_usd' => $core->aes($debts_usd)
        ), array('id' => $customerID), $oc)){
            return false;
        }else{
            return true;
        }
    }
    
}

?>