<?php
    $core->userChkRole('DISCOUNTS-EDIT');
    $e = false;
    if(!$core->chk_POST('percentage'))
        $e = true;
    elseif(!is_numeric($_POST['percentage']))
        $e = true;
    elseif($_POST['percentage'] <= 0 || $_POST['percentage'] >= 100)
        $e = true;
    elseif($core->dbNumRows('discounts', array('percentage' => $core->aes($_POST['percentage']))))
        $e = true;
    if($e)
        $core->err(V_URLP.'discounts-add', false);

    if($core->dbI('discounts', array('percentage' => $core->aes($_POST['percentage']))))
        $core->err(V_URLP.'discounts', true);
    else
        $core->err(V_URLP.'discounts-add', false);

?>