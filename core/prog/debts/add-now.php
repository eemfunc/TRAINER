<?php 

    $core->userChkRole('DEBTS-ADD');

    $url = ($core->chk_POST('customer_id')) ? 'debts-subtract&id='.$_POST['customer_id'] : 'debts-add';

    if(!$core->chk_POST(array('customer_id', 'currency', 'amount'))){
        $core->err(V_URLP.$url, false);
    }elseif(!is_numeric($_POST['amount'])){
        $core->err(V_URLP.$url, false);
    }

    $core->requireClass('payments');
    $pay = new payments();
    
    if($pay->addDebts($_POST['customer_id'], $_POST['currency'], $_POST['amount'])){
        $core->err(V_URLP.$url, true);
    }else{
        $core->err(V_URLP.$url, false);
    }

?>