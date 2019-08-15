<?php
    $core->userChkRole('DOLLARPRICE-EDIT');

    $e = false;
    if(!$core->chk_POST('update_dollar_price'))
        $e = true;
    elseif(!is_numeric($_POST['update_dollar_price']))
        $e = true;
    elseif($_POST['update_dollar_price'] < 0)
        $e = true;

    if($e)
        $core->err(V_URLP.'dashboard', false);
    
    if($core->dbI('dollar', array(
        'price' => $core->aes($_POST['update_dollar_price'])
    )))
        $core->err(V_URLP.'dashboard', true);
    else
        $core->err(V_URLP.'dashboard', false);
    
?>