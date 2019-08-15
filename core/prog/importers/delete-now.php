<?php
    $core->userChkRole('IMPORTERS-EDIT');
    if(!$core->chk_GET('id'))
        $core->err(404);
    elseif(!$core->dbNumRows('importers', array('id' => $_GET['id'])))
        $core->err(404);
    elseif($core->dbD('importers', array('id' => $_GET['id'])))
        $core->err(V_URLP.'importers', true);
    else
        $core->err(V_URLP.'importers', false);
?>