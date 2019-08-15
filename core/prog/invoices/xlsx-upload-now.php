<?php
    $core->userChkRole('INVOICES-XLSX');
    
if(!isset($_POST['xlfile_to_json']))
    $core->err(V_URLP.'invoices-xlsx', false);
elseif(strlen($_POST['xlfile_to_json']) < 1)
    $core->err(V_URLP.'invoices-xlsx', false);

if(isset($_FILES['xlfile'])){

    $core->requireClass('files');
    $file = new files($_FILES['xlfile'], array('xlsx'), V_INVOICES_XLSX_FOLDER);
    
    if($file->EXT_ERR || $file->SIZ_ERR)
        $core->err(V_URLP.'invoices-xlsx', false);

    if($file->uploadNow()){
        if($core->dbI('invoices_xlsx', array(
            'name'          => $core->aes($file->NAME),
            'url'           => $core->aes($file->FILE_URL),
            'json_content'  => $core->aes($_POST['xlfile_to_json'])
        ))){
            $core->err(V_URLP.'invoices-xlsx', true);
        }else{
            $core->err(V_URLP.'invoices-xlsx', false);
        }
    }else{
        $core->err(V_URLP.'invoices-xlsx', false);
    }

}else $core->err(V_URLP.'invoices-xlsx', false);

?>