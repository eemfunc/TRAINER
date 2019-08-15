<?php 

    $core->userChkRole('DEBTS-SUBTRACT');

    $url = ($core->chk_POST('customer_id')) ? 'debts-subtract&id='.$_POST['customer_id'] : 'debts-subtract-for';

    if(!$core->chk_POST(array('customer_id', 'currency', 'amount'))){
        $core->err(V_URLP.$url, false);
    }elseif(!is_numeric($_POST['amount'])){
        $core->err(V_URLP.$url, false);
    }

    $core->requireClass('payments');
    $pay = new payments();

    $transId = $core->newRandomID('transactions');
    
    if($pay->makePayment($_POST['customer_id'], $_POST['currency'], $_POST['amount'], true, $transId)){
        $core->err(V_URLP.'debts-print&id='.$transId, true);
    }else{
        $core->err(V_URLP.$url, false);
    }

?>