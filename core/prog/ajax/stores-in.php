<?php

if($core->chk_POST('store_id_from')){
    if(!$core->dbNumRows('stores', array('id<>' => $_POST['store_id_from'])))
        $core->err(404);
    else{
        $output = "<option value=''></option>";
        $rows = $core->dbFetch('stores', array('id<>' => $_POST['store_id_from']), 'ORDER BY created_at ASC');
        foreach($rows as $r)
            $output.= "<option value='".$r['id']."'>".$core->aes($r['name'], 1)."</option>";
        die($output);
    }
}

?>