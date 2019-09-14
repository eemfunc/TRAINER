<?php
    $core->userChkRole('ACCOUNTANT-EDIT');
    if(!$core->chk_GET('id')){
        $core->err(404);
    }elseif(!$core->dbNumRows('registrants', array('id' => $_GET['id']))){
        $core->err(404);
    }else{
        if($core->dbU('registrants', array('payment' => $core->aes('PAID')), array('id' => $_GET['id'])))
            $core->err(V_URLP.'accountant', true);
        else 
            $core->err(V_URLP.'accountant', false);
    }
?>