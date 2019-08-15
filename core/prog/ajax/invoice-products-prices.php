<?php

if($core->chk_POST('product_id')){
    
    $core->requireClass('payments');
    $pay = new payments();
    
    $product_arr = $core->dbFetch('products', array('id' => substr($_POST['product_id'], -9, -1)));
    
    define('R_USD', $core->aes($product_arr[0]['price_retail'], 1));
    define('R_IQD', $core->aes($product_arr[0]['price_retail_iqd'], 1));
    define('W_USD', $core->aes($product_arr[0]['price_wholesale'], 1));
    define('W_IQD', $core->aes($product_arr[0]['price_wholesale_iqd'], 1));
    define('D_USD', $core->aes($product_arr[0]['price_distribution'], 1));
    define('D_IQD', $core->aes($product_arr[0]['price_distribution_iqd'], 1));
    define('USD_PRICE', $pay->USD_PRICE);
    
    if(R_IQD != '' && R_IQD != 0)
        define('PR', R_IQD);
    elseif(R_USD != '' && R_USD != 0)
        define('PR', R_USD * USD_PRICE);
    else define('PR', 0);
    $pr_prefix = $core->txt('0110');
    if(PR == 0)$pr = $pr_prefix.': 0 ';
    else $pr = $pr_prefix.': '.$core->nf(PR).' '.$core->txt('0134');
    
    if(W_IQD != '' && W_IQD != 0)
        define('PW', W_IQD);
    elseif(W_USD != '' && W_USD != 0)
        define('PW', W_USD * USD_PRICE);
    else define('PW', 0);
    $pw_prefix = $core->txt('0111');
    if(PW == 0)$pw = $pw_prefix.': 0 ';
    else $pw = $pw_prefix.': '.$core->nf(PW).' '.$core->txt('0134');
    
    if(D_USD != '' && D_USD != 0)
        define('PD', D_USD);
    elseif(D_IQD != '' && D_IQD != 0)
        define('PD', D_IQD / USD_PRICE);
    else define('PD', 0);
    $pd_prefix = $core->txt('0112');
    if(PD == 0)$pd = $pd_prefix.': 0 ';
    else $pd = $pd_prefix.': '.$core->nf(PD).' '.$core->txt('0135');
    
    echo $pd.' - '.$pw.' - '.$pr;
        
    exit;
}

?>