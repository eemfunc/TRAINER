<?php
$core->userChkRole('INVOICES-VIEW');
if(isset($_GET['id'])){
    if(!$core->dbNumRows('invoices_products', array('invoice_id' => $_GET['id'])))
        $core->err(404);
    else define('ID', $_GET['id']);
    
    if($core->dbNumRows('invoices', array('id' => ID))){
        define('EDIT', false);
        define('EDIT_DISABLED', 'disabled');
    }else{
        if(!$core->userChkRole('INVOICES-EDIT'))
            $core->err(404);
        define('EDIT', true);
        define('EDIT_DISABLED', '');
    }
    
    $price_type = $core->aes($core->dbFetch('invoices_products', array('invoice_id' => ID), 'ORDER BY created_at DESC LIMIT 1')[0]['price_type'], 1);
    if($price_type == 'RETAIL'){
        define('RETAIL_SELECTED', 'selected');
        define('WHOLESALE_SELECTED', '');
        define('DISTRIBUTION_SELECTED', '');
    }elseif($price_type == 'WHOLESALE'){
        define('RETAIL_SELECTED', '');
        define('WHOLESALE_SELECTED', 'selected');
        define('DISTRIBUTION_SELECTED', '');
    }else{
        define('RETAIL_SELECTED', '');
        define('WHOLESALE_SELECTED', '');
        define('DISTRIBUTION_SELECTED', 'selected');
    }
    
    $doSecondCus = true;
    if(isset($_GET['cus'])){
        if(strlen($_GET['cus']) == 8){
            if($core->dbNumRows('customers', array('id' => $_GET['cus']))){
                $customer_id = $_GET['cus'];
                $doSecondCus = false;
                $core->dbU('invoices_products', array('customer_id' => $customer_id), array('invoice_id' => ID));
            }
        }
    }
    if($doSecondCus){
        $customer_id = $core->dbFetch('invoices_products', array('invoice_id' => ID), 'ORDER BY created_at DESC LIMIT 1')[0]['customer_id'];
    }
    if($customer_id != null){
        define('CUSTOMER_ID',       $customer_id);
        $customer_arr =             $core->dbFetch('customers', array('id' => CUSTOMER_ID));
        define('CUSTOMER_NAME',     $core->aes($customer_arr[0]['name'], 1));
        define('CUSTOMER_CITY',     $core->aes($customer_arr[0]['city'], 1));
        define('CUSTOMER_REGION',   $core->aes($customer_arr[0]['region'], 1));
    }

    
}else{
    if(!$core->userChkRole('INVOICES-EDIT'))
        $core->err(404);
    define('ID', '');
    define('EDIT', true);
    define('EDIT_DISABLED', '');
    
    if(isset($_GET['cus'])){
        if(strlen($_GET['cus']) == 8){
            if($core->dbNumRows('customers', array('id' => $_GET['cus']))){
                define('CUSTOMER_ID', $_GET['cus']);
                $customer_arr = $core->dbFetch('customers', array('id' => CUSTOMER_ID));
                define('CUSTOMER_NAME', $core->aes($customer_arr[0]['name'], 1));
                define('CUSTOMER_CITY', $core->aes($customer_arr[0]['city'], 1));
                define('CUSTOMER_REGION', $core->aes($customer_arr[0]['region'], 1));
            }
        }
    }
    
    $ptype_allow = true;
    $ptype_arr = array('RETAIL', 'WHOLESALE', 'DISTRIBUTION');
    if(isset($_GET['ptype']))
        if(in_array($_GET['ptype'], $ptype_arr)){
            $ptype_allow = false;
            if($_GET['ptype'] == $ptype_arr[0]){
                define('RETAIL_SELECTED', 'selected');
                define('WHOLESALE_SELECTED', '');
                define('DISTRIBUTION_SELECTED', '');
            }elseif($_GET['ptype'] == $ptype_arr[1]){
                define('RETAIL_SELECTED', '');
                define('WHOLESALE_SELECTED', 'selected');
                define('DISTRIBUTION_SELECTED', '');
            }elseif($_GET['ptype'] == $ptype_arr[2]){
                define('RETAIL_SELECTED', '');
                define('WHOLESALE_SELECTED', '');
                define('DISTRIBUTION_SELECTED', 'selected');
            }else $ptype_allow = true;
        }
    if($ptype_allow){
        define('RETAIL_SELECTED', '');
        define('WHOLESALE_SELECTED', 'selected');
        define('DISTRIBUTION_SELECTED', '');
    }
    
    define('ADD_NEW_CUSTOMER', ' - <a href="'.V_URLP.'customers-add" target="_blank">'.$core->txt('0042').'</a>');
}

$updateDefaultCur = true;
if(isset($_GET['useLastCur']) && !isset($_GET['id'])){
    if($core->dbNumRows('invoices_products', array('customer_id' => $_GET['cus']))){
        define('CUR', $core->aes($core->dbFetch('invoices_products', array('customer_id' => $_GET['cus']), 'ORDER BY created_at DESC LIMIT 1')[0]['currency'], 1));
        $updateDefaultCur = false;
    }
}
if($updateDefaultCur){
    if(isset($_GET['cur'])){
        if($_GET['cur'] == 'USD'){
            define('CUR', 'USD');
        }elseif($_GET['cur'] == 'IQD'){
            define('CUR', 'IQD');
        }else{
            $core->err(404);
        }
        if(ID != ''){
            $core->dbU("invoices_products", array('currency' => $core->aes($_GET['cur'])), array("invoice_id" => ID));
        }
    }else{
        if(ID != ''){
            define('CUR', $core->aes($core->dbFetch('invoices_products', array('invoice_id' => ID), 'ORDER BY created_at DESC LIMIT 1')[0]['currency'], 1));
        }else{
            define('CUR', '');
        }
    }
}
if(CUR == 'USD'){
    define('IQD_SELECTED', '');
    define('USD_SELECTED', 'selected');
    define('TOTAL_CUR', '$');
}else{
    define('IQD_SELECTED', 'selected');
    define('USD_SELECTED', '');
    define('TOTAL_CUR', $core->txt('0114'));
}

if(isset($_GET['dis'])){
    if($core->dbNumRows('discounts', array('id' => $_GET['dis']))){
        define('DIS', $_GET['dis']);
        define('DIS_PERCENTAGE', $core->aes($core->dbFetch('discounts', array('id' => DIS))[0]["percentage"], 1));
    }elseif($_GET['dis'] == '' || $_GET['dis'] == 0){
        define('DIS', '');
    }else $core->err(); 
    if(ID != '')
        $core->dbU("invoices_products", array('discount_id' => DIS), array("invoice_id" => ID));
}else{
    if(ID != ''){
        define('DIS', $core->dbFetch('invoices_products', array('invoice_id' => ID), 'ORDER BY created_at DESC LIMIT 1')[0]['discount_id']);
        if(DIS != '')define('DIS_PERCENTAGE', $core->aes($core->dbFetch('discounts', array('id' => DIS))[0]["percentage"], 1));
    }else define('DIS', '');
}
if(DIS == '')define('DISCOUNT_SELECTED', 'selected');
else define('DISCOUNT_SELECTED', '');

if(ID != null){
    if($core->dbNumRows('invoices', array('id' => ID))){
        $invoice_total = $core->nf($core->aes($core->dbFetch('invoices', array('id' => ID))[0]['invoice_total_discount'], 1));
    }else{
        $x = 0;
        $rows = $core->dbFetch('invoices_products', array('invoice_id' => ID));
        foreach($rows as $r){
            if(CUR == 'USD'){
                $x += $core->aes($r['total_price_usd'], 1);
            }else{
                $x += $core->aes($r['total_price_iqd'], 1);
            }
            $discount_id = $r['discount_id'];
        }
        $discount = ($discount_id == null) ? 0 : $core->aes($core->dbFetch('discounts', array('id' => $discount_id))[0]['percentage'], 1);
        $x -= $x * $discount / 100;
        $invoice_total = $core->nf($x);
    }
}else{
    $invoice_total = '0';
}

echo $theme->getHeader('select2');

$url_link_p="invoices";
$url_link_p_add_now='invoices-add-save';
$url_link_p_delete_now='invoices-products-delete-now';

?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.$url_link_p_add_now; ?>">
                      
<div class="col-lg-12 row" style="padding:0;margin:0;">
    <div class="col-sm-1 invoiceBG" style="padding-top:25px;">
        <input name="invoice_id" id="invoice_id" type="hidden" value="<?php echo ID; ?>">
        <h4 class="hb title-size center"><?php echo $core->txt('0100'); ?></h4>
    </div>
    <div class="col-sm-5 invoiceBG">
        <div class="form-group">
            <label class="col-form-label"><?php echo $core->txt('0096');if(defined('ADD_NEW_CUSTOMER'))echo ADD_NEW_CUSTOMER; ?></label>
            <div class="select2-div">
            <select name="customer_id" id="customer_id" class="title-size form-control js-example-rtl-2" <?php echo EDIT_DISABLED; ?>>
                <?php
                if(defined('CUSTOMER_ID')){
                        $c = "";
                        if(CUSTOMER_CITY == "بغداد" || CUSTOMER_CITY == ""){
                            if(CUSTOMER_REGION != "")
                                $c = " (".CUSTOMER_REGION.")";
                        }else $c = " (".CUSTOMER_CITY.")";
                        echo "<option value='".CUSTOMER_NAME." (".CUSTOMER_ID.")'>".CUSTOMER_NAME.$c."</option>";
                    }
                ?>
            </select>
            </div>
        </div>
    </div>
    <div class="col-sm-2 invoiceBG">
        <div class="form-group">
            <label class="col-form-label"><?php echo $core->txt('0101'); ?></label>
            <select name="price_type" id="price_type" class="form-control" style="margin-top: 0px;" <?php echo EDIT_DISABLED; ?>>
                <?php
                echo "<option value='RETAIL' ".RETAIL_SELECTED.">".$core->txt('0131')."</option>";
                echo "<option value='WHOLESALE' ".WHOLESALE_SELECTED.">".$core->txt('0132')."</option>";
                echo "<option value='DISTRIBUTION' ".DISTRIBUTION_SELECTED.">".$core->txt('0133')."</option>";
                ?>
            </select>
        </div>
    </div>
    <div class="col-sm-2 invoiceBG">
        <div class="form-group">
            <label class="col-form-label"><?php echo $core->txt('0102'); ?></label>
            <select name="currency" id="currency" class="form-control" style="margin-top: 0px;" <?php echo EDIT_DISABLED; ?>>
                <option value="IQD" <?php echo IQD_SELECTED; ?>><?php echo $core->txt('0047'); ?></option>
                <option value="USD" <?php echo USD_SELECTED; ?>><?php echo $core->txt('0048'); ?></option>
            </select>
        </div>
    </div>
    <div class="col-sm-2 invoiceBG">
        <div class="form-group">
            <label class="col-form-label"><?php echo $core->txt('0103'); ?></label>
            <select name="discount_id" id="discount_id" class="form-control" style="margin-top: 0px;" <?php echo EDIT_DISABLED; ?>>
                <?php
                    echo '<option value="" '.DISCOUNT_SELECTED.'>'.$core->txt('0109').'</option>';
                    $discounts = array();
                    $selected_key = '';
                    $rows = $core->dbFetch('discounts', null, 'ORDER BY created_at ASC');
                    foreach($rows as $r)
                        $discounts[$r['id']] = $core->aes($r['percentage'], 1);
                    asort($discounts);
                    foreach($discounts as $key => $value){
                        echo "<option value='".$key."'";
                        if($key == DIS)echo " selected";
                        echo ">".$value." %</option>";
                    }
                ?>
            </select>
        </div>
    </div>
</div>

<br>
<?php if(EDIT){ ?>
    <div class="col-lg-12 row">
        <div class="col-sm-5">
            <div class="form-group">
                <label class="col-form-label"><?php echo $core->txt('0050'); ?></label>
                <div class="select2-div">
                <select name="product_id" id="product_id" class="title-size form-control js-example-rtl"></select>
                </div>
                <label style="margin-top:10px;" id="product_prices"><?php echo $core->txt('0205'); ?></label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
              <label class="col-form-label"><?php echo $core->txt('0065'); ?></label>
                <select name="store_id" id="store_id" class="form-control" style="margin-top:1px;"></select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="col-form-label"><?php echo $core->txt('0127'); ?></label>
                <select name="packing_id" id="packing_id" class="form-control" style="margin-top: 1px;"></select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
              <label class="col-form-label"><?php echo $core->txt('0066'); ?></label>
              <input name="quantity" id="quantity" type="number" class="form-control form-control-sm" style="margin-top: 0px;" value="0">
            </div>
        </div>
        <div class="col-sm-1" style="padding-top:35px;">
            <div class="form-group">
              <button id="addProduct" type="button" class="btn btn-primary btn-sm hr button-size rtl" style="vertical-align: bottom;"><?php echo $core->txt('0088'); ?></button>
            </div>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="table-responsive">
        <table id="invoice_products" class="table table-bordered">
            <thead>
                <tr>
                  <th><?php echo $core->txt('0050'); ?></th>
                  <th><?php echo $core->txt('0065'); ?></th>
                  <th><?php echo $core->txt('0179'); ?></th>
                  <th><?php echo $core->txt('0087'); ?></th>
                  <th><?php echo $core->txt('0090'); ?></th>
                  <?php if(EDIT)echo '<th>'.$core->txt('0026').'</th>'; ?>
                </tr>
            </thead>
            <tbody>
            <?php
                if(ID != ''){
                    $rows = $core->dbFetch('invoices_products', array('invoice_id' => ID), 'ORDER BY created_at ASC');
                    foreach($rows as $r){
                        echo "<tr>";
                                $product_arr = $core->dbFetch('products', array('id' => $r['product_id']));
                                $product_name = $core->aes($product_arr[0]['name'], 1);
                                $product_item_no = $core->aes($product_arr[0]['item_no'], 1);
                            echo "<td>".$product_name." (<span>&#x200F;".$product_item_no."</span>)</td>";
                                $store_name = $core->aes($core->dbFetch('stores', array('id' => $r['store_id']))[0]["name"], 1);
                            echo "<td>".$store_name."</td>";
                                $quantity = $core->aes($r['quantity'], 1);
                                if($r['packing_id'] == 1){
                                    $packing = $core->txt('0129').' (1)';
                                }else{
                                    $packing_arr = $core->dbFetch('packing', array('id' => $r['packing_id']));
                                    $packing = $core->aes($packing_arr[0]['name'], 1).' ('.$core->aes($packing_arr[0]['quantity'], 1).')';
                                }
                            echo "<td>".$core->nf($quantity).' '.$packing."</td>";
                                if($core->aes($r['currency'], 1) == 'USD'){
                                    $unit_price = $core->aes($r['unit_price_usd'], 1);
                                    $total_price = $core->aes($r['total_price_usd'], 1);
                                }else{
                                    $unit_price = $core->aes($r['unit_price_iqd'], 1);
                                    $total_price = $core->aes($r['total_price_iqd'], 1);
                                }
                                if($core->aes($r['price_type'], 1) == 'RETAIL')
                                    $pt = ' ('.$core->txt('0110').')';
                                elseif($core->aes($r['price_type'], 1) == 'WHOLESALE')
                                    $pt = ' ('.$core->txt('0111').')';
                                else $pt = ' ('.$core->txt('0112').')';
                                if($core->aes($r['currency'], 1) == 'IQD')$c = ' '.$core->txt('0134');
                                else $c = ' '.$core->txt('0135');
                            echo "<td>".$core->nf($unit_price).$c.$pt."</td>";
                            echo "<td>".$core->nf($total_price).$c."</td>";
                            if(EDIT){
                                echo "<td>";
                                ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p_delete_now.'&id='.$r['id'].'&invoice_id='; ?>' + document.getElementById('invoice_id').value, '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                                echo "</td>";
                            }
                        echo "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<br><br>
                      
                    <?php if(EDIT){ ?>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0138'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    <?php }else{ ?>     
                        <a href="<?php echo V_URLP."invoices-print&id=".ID; ?>" target="_blank"><button type="button" class="btn btn-primary"><?php echo $core->txt('0203'); ?></button></a>
                        <a href="<?php echo V_URLP."invoices-print-delivery&id=".ID; ?>" target="_blank"><button type="button" class="btn btn-primary"><?php echo $core->txt('0204'); ?></button></a>
                        <a href="javascript:void(0);" onclick="window.close()"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0150'); ?></button></a>
                    <?php } ?>
                    <label><?php echo '&nbsp;&nbsp;'.$core->txt('0084').': '; ?></label>
                    <label id="invoice_total"><?php echo $invoice_total; ?></label>
                    <label><?php echo ' '.TOTAL_CUR; ?></label>
                  </form>
                </div>
            </div>
        </div>
    </div>

<?php echo $theme->getFooter('select2'); ?>

<script type="text/javascript">
    (function ($) {
        
        <?php if(defined('CUSTOMER_ID')){ 
            $c = "";
            if(CUSTOMER_CITY == "بغداد" || CUSTOMER_CITY == ""){
                if(CUSTOMER_REGION != "")
                    $c = " (".CUSTOMER_REGION.")";
            }else $c = " (".CUSTOMER_CITY.")";
        ?>
            $('#select2-customer_id-container').empty();
            $('#select2-customer_id-container').append('<?php echo CUSTOMER_NAME.$c; ?>');
        <?php } ?>
        
        $('#currency').on('change', function(){
            var url_args = '';
            if($('#invoice_id').val() != ''){
                url_args += '&id=' + $('#invoice_id').val();
            }
            if($('#currency').val() != ''){
                url_args += '&cur=' + $('#currency').val();
            }
            if($('#price_type').val() != ''){
                url_args += '&ptype=' + $('#price_type').val();
            }
            url_args += '&dis=' + $('#discount_id').val();
            if($('#customer_id').val() != ''){
                try{
                    var cus = $('#customer_id').val();
                    var cus_len = cus.length;
                    var cus_arg = cus.substr(cus_len - 9, 8);
                    if(cus_arg.length == 8)
                        url_args += '&cus=' + cus_arg;
                }catch(err){}
            }
            goto('<?php 
                $url = $core->removeParamFromUrl(V_FULL_URL_PATH, 'id');
                $url = $core->removeParamFromUrl($url, 'cur');
                $url = $core->removeParamFromUrl($url, 'cus');
                $url = $core->removeParamFromUrl($url, 'dis');
                $url = $core->removeParamFromUrl($url, 'ptype');
                $url = $core->removeParamFromUrl($url, 'useLastCur');
                echo $url;
                ?>' + url_args
            );
        });

        $('#customer_id').on('change', function(){
            var url_args = '';
            if($('#invoice_id').val() != ''){
                url_args += '&id=' + $('#invoice_id').val();
            }
            if($('#currency').val() != ''){
                url_args += '&cur=' + $('#currency').val();
            }
            if($('#price_type').val() != ''){
                url_args += '&ptype=' + $('#price_type').val();
            }
            url_args += '&dis=' + $('#discount_id').val();
            if($('#customer_id').val() != ''){
                try{
                    var cus = $('#customer_id').val();
                    var cus_len = cus.length;
                    var cus_arg = cus.substr(cus_len - 9, 8);
                    if(cus_arg.length == 8)
                        url_args += '&cus=' + cus_arg + '&useLastCur=1';
                }catch(err){}
            }
            goto('<?php 
                $url = $core->removeParamFromUrl(V_FULL_URL_PATH, 'id');
                $url = $core->removeParamFromUrl($url, 'cur');
                $url = $core->removeParamFromUrl($url, 'cus');
                $url = $core->removeParamFromUrl($url, 'dis');
                $url = $core->removeParamFromUrl($url, 'ptype');
                $url = $core->removeParamFromUrl($url, 'useLastCur');
                echo $url;
                ?>' + url_args
            );
        });
        
        $('#discount_id').on('change', function(){
            var url_args = '';
            if($('#invoice_id').val() != ''){
                url_args += '&id=' + $('#invoice_id').val();
            }
            if($('#currency').val() != ''){
                url_args += '&cur=' + $('#currency').val();
            }
            if($('#price_type').val() != ''){
                url_args += '&ptype=' + $('#price_type').val();
            }
            url_args += '&dis=' + $('#discount_id').val();
            if($('#customer_id').val() != ''){
                try{
                    var cus = $('#customer_id').val();
                    var cus_len = cus.length;
                    var cus_arg = cus.substr(cus_len - 9, 8);
                    if(cus_arg.length == 8)
                        url_args += '&cus=' + cus_arg;
                }catch(err){}
            }
            goto('<?php 
                $url = $core->removeParamFromUrl(V_FULL_URL_PATH, 'id');
                $url = $core->removeParamFromUrl($url, 'cur');
                $url = $core->removeParamFromUrl($url, 'cus');
                $url = $core->removeParamFromUrl($url, 'dis');
                $url = $core->removeParamFromUrl($url, 'ptype');
                $url = $core->removeParamFromUrl($url, 'useLastCur');
                echo $url;
                ?>' + url_args
            );
        });
        
        $('#product_id').on('change',function(){
            var v = document.getElementById("product_id").value;
            if(v!=null&&v!=''){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo V_URLP; ?>ajax-invoice-products-stores-quantities',
                    data: {
                        product_id: v
                    },
                    success: function (response){
                        document.getElementById("store_id").innerHTML = response;
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo V_URLP; ?>ajax-invoice-products-packing',
                    data: {
                        product_id: v
                    },
                    success: function (response){
                        document.getElementById("packing_id").innerHTML=response;
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo V_URLP; ?>ajax-invoice-products-prices',
                    data: {
                        product_id: v
                    },
                    success: function (response){
                        document.getElementById("product_prices").innerHTML=response;
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo V_URLP; ?>ajax-invoice-products-prices-update',
                    data: {
                        product_id: v
                    },
                    success: function (response){
                        if(response == 1){
                            var product_name_id = $('#product_id').val();
                            var product_name_id_len = product_name_id.length;
                            var product_id = product_name_id.substr(product_name_id_len - 9, 8);
                            window.open('<?php echo V_URLP."products-add&id="; ?>' + product_id, '_blank');
                        }
                    }
                });
            }else{
                document.getElementById("store_id").innerHTML='';
                document.getElementById("packing_id").innerHTML='';
                document.getElementById("product_prices").innerHTML='<?php echo $core->txt('0205'); ?>';
            }
        });
        
        $("#addProduct").click(function(){
            $.ajax({
                url: "<?php echo V_URLP; ?>ajax-invoice-add-product",
                method: "POST",
                data: {
                    "invoice_id"    : $('#invoice_id').val(),
                    "customer_id"   : $('#customer_id').val(),
                    "price_type"    : $('#price_type').val(),
                    "currency"      : $('#currency').val(),
                    "discount_id"   : $('#discount_id').val(),
                    "product_id"    : $('#product_id').val(),
                    "store_id"      : $('#store_id').val(),
                    "packing_id"    : $('#packing_id').val(),
                    "quantity"      : $('#quantity').val()
                },
                success: function(data){
                    var out = JSON.parse(data);
                    if(out.status != "success"){
                        alert(out.message);
                    }else{
                        $('#invoice_id').val(out.data.invoice_id);
                        document.getElementById("invoice_total").innerHTML = out.data.invoice_total;
                        $('#invoice_products').append(
                            '<tr>' +
                                '<td>' + out.data.product_name + '</td>' +
                                '<td>' + out.data.store_name + '</td>' +
                                '<td>' + out.data.quantity + '</td>' +
                                '<td>' + out.data.unit_price + '</td>' +
                                '<td>' + out.data.total_price + '</td>' +
                                '<td><a href="javascript:void(0);" onclick="doAlr(\'<?php echo V_URLP.$url_link_p_delete_now; ?>&id=' + out.data.invoice_product_id + '&invoice_id=' + document.getElementById('invoice_id').value + '\', \'<?php echo $core->txt("0030"); ?>\')"><?php echo $core->txt("0026"); ?></a></td>' +
                            '</tr>'
                        );
                        $('#product_id').val('');
                        $('#select2-product_id-container').attr('title', '');
                        $('#select2-product_id-container').empty();
                        $('#select2-product_id-container').append('<?php echo $core->txt('0068'); ?>');
                        document.getElementById("product_prices").innerHTML='<?php echo $core->txt('0205'); ?>';
                        document.getElementById("store_id").innerHTML='';
                        document.getElementById("packing_id").innerHTML='';
                        $('#quantity').val('0');
                    }
                },
                fail: function(xhr, textStatus, errorThrown){
                    alert('<?php echo $core->txt('0001'); ?>');
                }
            });
            $("#addProduct").attr("disabled", false);
        });
        
        $('.js-example-rtl').select2({
            placeholder: "<?php echo $core->txt('0068'); ?>",language:{errorLoading:function(){return"<?php echo $core->txt('0069'); ?>";},inputTooLong:function(e){var t=e.input.length-e.maximum;return"<?php echo $core->txt('0070'); ?>"+t+"<?php echo $core->txt('0071'); ?>";},inputTooShort:function(e){var t=e.minimum-e.input.length;return"<?php echo $core->txt('0072'); ?>"+t+"<?php echo $core->txt('0076'); ?>";},loadingMore:function(){return"<?php echo $core->txt('0073'); ?>";},maximumSelected:function(e){return"<?php echo $core->txt('0074'); ?>"+e.maximum+"<?php echo $core->txt('0075'); ?>";},noResults:function(){return"<?php echo $core->txt('0077'); ?>";},searching:function(){return"<?php echo $core->txt('0078'); ?>";}},dir: '<?php echo V_SELECT2_DIR; ?>',minimumInputLength: <?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>,
            
            ajax: {url: "<?php echo V_MAIN_FOLDER_PATH; ?>",dataType: "json",delay: 250,data: function (params) {return {
                <?php echo V_PROG_QUERY; ?>: 'ajax-search-products-v1',
                <?php echo V_SEARCH_QUERY; ?>: params.term,
                <?php echo V_PAGE_QUERY; ?>: params.page
            };},processResults: function (data, params) {params.page = params.page || 1;return {results: data.matches,pagination: {more: (params.page * <?php echo V_ROWS_PER_PAGE_SELECT2; ?>) < data.total_count}};},cache: true}});
        
        $('.js-example-rtl-2').select2({
            placeholder: "<?php echo $core->txt('0068'); ?>",language:{errorLoading:function(){return"<?php echo $core->txt('0069'); ?>";},inputTooLong:function(e){var t=e.input.length-e.maximum;return"<?php echo $core->txt('0070'); ?>"+t+"<?php echo $core->txt('0071'); ?>";},inputTooShort:function(e){var t=e.minimum-e.input.length;return"<?php echo $core->txt('0072'); ?>"+t+"<?php echo $core->txt('0076'); ?>";},loadingMore:function(){return"<?php echo $core->txt('0073'); ?>";},maximumSelected:function(e){return"<?php echo $core->txt('0074'); ?>"+e.maximum+"<?php echo $core->txt('0075'); ?>";},noResults:function(){return"<?php echo $core->txt('0077'); ?>";},searching:function(){return"<?php echo $core->txt('0078'); ?>";}},dir: '<?php echo V_SELECT2_DIR; ?>',minimumInputLength: <?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>,
            
            ajax: {url: "<?php echo V_MAIN_FOLDER_PATH; ?>",dataType: "json",delay: 250,data: function (params) {return {
                <?php echo V_PROG_QUERY; ?>: 'ajax-search-customers',
                <?php echo V_SEARCH_QUERY; ?>: params.term,
                <?php echo V_PAGE_QUERY; ?>: params.page
            };},processResults: function (data, params) {params.page = params.page || 1;return {results: data.matches,pagination: {more: (params.page * <?php echo V_ROWS_PER_PAGE_SELECT2; ?>) < data.total_count}};},cache: true}});
        
    })(jQuery);
    
</script>