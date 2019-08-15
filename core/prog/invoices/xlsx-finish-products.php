<?php
    $core->userChkRole('INVOICES-XLSX');
if(isset($_GET['id'])){
    $core->requireClass('xlsxvars');
    $xlsx = new xlsxvars($_GET['id']);
    if(!$xlsx->STATUS)
        $core->err(404);
    elseif($xlsx->finishProducts())
        $core->err(V_URLP.'invoices-xlsx', true);
    else
        $core->err(V_URLP.'invoices-xlsx', false);
}else
    $core->err(404);

?>