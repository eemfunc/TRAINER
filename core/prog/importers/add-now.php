<?php
    $core->userChkRole('IMPORTERS-EDIT');
    if(!$core->chk_POST('name'))
        $core->err(404);
    elseif($core->dbI('importers', array('name' => $core->aes($_POST['name']))))
        $core->err(V_URLP.'importers', true);
    else
        $core->err(V_URLP.'importers-add', false);
?>