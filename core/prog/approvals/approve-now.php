<?php
    $core->userChkRole('APPROVAL-EDIT');
    if(!$core->chk_GET('id')){
        $core->err(404);
    }elseif(!$core->dbNumRows('registrants', array('id' => $_GET['id']))){
        $core->err(404);
    }else{
        if($core->dbU('registrants', array('acceptance' => $core->aes('ACCEPTED')), array('id' => $_GET['id'])))
            $core->err(V_URLP.'approvals', true);
        else 
            $core->err(V_URLP.'approvals', false);
    }
?>