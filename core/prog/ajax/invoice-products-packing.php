<?php

if($core->chk_POST('product_id')){
    $output = '<option value="1">'.$core->txt('0129').' (1)</option>';
    $rows = $core->dbFetch('packing', array('product_id' => substr($_POST['product_id'], -9, -1)), 'ORDER BY created_at ASC');
    foreach($rows as $r)
        $output .= '<option value="'.$r['id'].'">'.$core->aes($r['name'], 1).' ('.$core->aes($r['quantity'], 1).')</option>';
    die($output);
}else die();

?>