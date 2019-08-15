<?php

if($core->chk_POST('product_id')){
    $output = '';
    $rows = $core->dbFetch('stores', null, 'ORDER BY created_at ASC');
    foreach($rows as $r){
        if($core->userHaveRole('STORES-ALL-ACCESS') || 
        ($r['branch_id'] == $core->userData('branch_id') && $core->userData('branch_type') != 'REPRESENTATIVES-BRANCH') || 
        ($r['id'] == $core->userData('user-access-store-id') && $core->userData('branch_type') == 'REPRESENTATIVES-BRANCH')){
            $quantity = 0;
            $rows1 = $core->dbFetch('products_quantities', array(
                'store_id'      => $r['id'],
                'product_id'    => substr($_POST["product_id"], -9, -1)
            ));
            foreach($rows1 as $r1)
                $quantity += $core->aes($r1['quantity'], 1);
            $output .= '<option value="'.$r['id'].'">'.$core->aes($r['name'], 1).' ('.$quantity.')</option>';
        }
    }
    die($output);
}else{
    $core->err(404);
}

?>