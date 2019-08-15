<?php 
    $core->userChkRole('INVOICES-EDIT');
    /* CHECK THE $_POST VALUES AND DEFINE VARIABLES */
    $e = false;
    $v = array();
    $chk_arr = array('invoice_id', 'customer_id');
    
    if(!$core->chk_POST($chk_arr))$e = true;
    
    if(isset($_POST["invoice_id"])){
        if($_POST["invoice_id"] != '')
            if(!$core->dbNumRows('invoices_products', array('invoice_id' => $_POST["invoice_id"])))
                $e = true;
            if($core->dbNumRows('invoices', array('id' => $_POST["invoice_id"])))
                $e = true;
        $v['invoice_id'] = $_POST["invoice_id"];
    }else $v['invoice_id'] = '';

    if(isset($_POST["customer_id"])){
        if($_POST['customer_id'] != ''){
            $customer_id = substr($_POST["customer_id"], -9, -1);
            if(!$core->dbNumRows('customers', array('id' => $customer_id)))
                $e = true;
            $v['customer_id'] = $customer_id;
        }else $v['customer_id'] = '';
    }else $v['customer_id'] = '';

    if($e)$core->err(V_URLP.'invoices-add&id='.$v['invoice_id'], false);

    /* TO UPDATE SOME INFORMATION IN DB */
    $core->dbU("invoices_products", array('customer_id' => $v['customer_id']), array("invoice_id" => $v['invoice_id']));

    /* FIND SOME CONSTANTS BEFORE COUNTING */
    $ip_arr = $core->dbFetch('invoices_products', array('invoice_id' => $v['invoice_id']), 'ORDER BY created_at DESC LIMIT 1');
    $v['discount_id'] = $ip_arr[0]['discount_id'];
    $v['currency'] = $core->aes($ip_arr[0]['currency'], 1);
    if($v['discount_id'] == '')$v['discount_percentage'] = 0;
    else $v['discount_percentage'] = $core->aes($core->dbFetch('discounts', array('id' => $v['discount_id']))[0]['percentage'], 1);
    $customer_arr = $core->dbFetch('customers', array('id' => $v['customer_id']));
    $v['customer_name'] = $core->aes($customer_arr[0]['name'], 1);
    $v['debts_usd'] = $core->aes($customer_arr[0]['debts_usd'], 1);
    $v['debts_iqd'] = $core->aes($customer_arr[0]['debts_iqd'], 1);
    if($v['currency'] == 'USD')$v['cur'] = $core->txt('0135');
    else $v['cur'] = $core->txt('0134');

    $core->requireClass('payments');
    $pay = new payments();

    /* FIND THE PRICES */
    $x = 0;
    $rows = $core->dbFetch('invoices_products', array('invoice_id' => $v['invoice_id']));
    foreach($rows as $r){
        if($v['currency'] == 'USD')$x += $core->aes($r['total_price_usd'], 1);
        else $x += $core->aes($r['total_price_iqd'], 1);
    }
    if($v['currency'] == 'USD'){
        $v['invoice_total_usd'] = $x;
        $v['invoice_total_iqd'] = $x * $pay->USD_PRICE;
    }else{
        $v['invoice_total_usd'] = $x / $pay->USD_PRICE;
        $v['invoice_total_iqd'] = $x;
    }
    $v['invoice_total_discount_usd'] = $v['invoice_total_usd'] - ($v['invoice_total_usd'] * $v['discount_percentage'] / 100);
    $v['invoice_total_discount_iqd'] = $v['invoice_total_iqd'] - ($v['invoice_total_iqd'] * $v['discount_percentage'] / 100);
    $v['invoice_total_discount_view'] = $core->nf($v['invoice_total_discount_iqd']).' '.$core->txt('0134').' ( '.$core->nf($v['invoice_total_discount_usd']).' '.$core->txt('0135').' )';
    if($v['currency'] == 'USD'){
        $v['invoice_total'] = $v['invoice_total_usd'];
        $v['invoice_total_discount'] = $v['invoice_total_discount_usd'];
    }else{
        $v['invoice_total'] = $v['invoice_total_iqd'];
        $v['invoice_total_discount'] = $v['invoice_total_discount_iqd'];
    }

    /* CREATE A NEW ID FOR invoices_temp TABLE */
    $v['invoice_temp_id'] = $core->newRandomID('invoices_temp');
    
    /* ADD TO DB */
    if($core->dbNumRows('invoices_temp', array('invoice_id' => $v['invoice_id'])))
        $core->dbD("invoices_temp", array("invoice_id" => $v['invoice_id'], "removed" => '0'));
    if(!$core->dbI('invoices_temp', array(
        'invoice_id'                => $v['invoice_id'],
        'invoice_total'             => $core->aes($v['invoice_total']),
        'invoice_total_discount'    => $core->aes($v['invoice_total_discount']),
        'branch_id'                 => $core->userData('branch_id')
    )))
        $core->err(V_URLP.'invoices-add&id='.$v['invoice_id'], false);

    /* FIND THE DEBTS */
    /*
    $total_debts_usd = 0;
    $total_debts_iqd = 0;
    if($v['debts_usd'] != 0 && $v['debts_usd'] != ''){
        $total_debts_usd += $v['debts_usd'];
        $total_debts_iqd += $v['debts_usd'] * $pay->USD_PRICE;
    }
    if($v['debts_iqd'] != 0 && $v['debts_iqd'] != ''){
        $total_debts_usd += $v['debts_iqd'] / $pay->USD_PRICE;
        $total_debts_iqd += $v['debts_iqd'];
    }
    $total_debts_iqd_view = $core->nf($total_debts_iqd).' '.$core->txt('0134');
    $total_debts_usd_view = $core->nf($total_debts_usd).' '.$core->txt('0135');
    if($total_debts_iqd_view == 0)$v['total_debts'] = 0;
    else $v['total_debts'] = $total_debts_iqd_view.' ( '.$total_debts_usd_view.' )';
    */
    $v['total_debts'] = $pay->getDebts($v['customer_id']);
    $total_debts_usd = $pay->getDebts($v['customer_id'], 'USD');
    $total_debts_iqd = $pay->getDebts($v['customer_id'], 'IQD');
    
    /* TOTAL WITH DEBETS */
    if($v['currency'] == 'USD'){
        $p_usd = $v['invoice_total_discount'] + $total_debts_usd;
        $p_iqd = ($v['invoice_total_discount'] * $pay->USD_PRICE) + $total_debts_iqd;
    }else{
        $p_usd = ($v['invoice_total_discount'] / $pay->USD_PRICE) + $total_debts_usd;
        $p_iqd = $v['invoice_total_discount'] + $total_debts_iqd;
    }
    $v['total_with_debts'] = $core->nf($p_iqd).' '.$core->txt('0134').' ( '.$core->nf($p_usd).' '.$core->txt('0135').' )';

echo $theme->getHeader(); 

$url_link_p="invoices";
$url_link_p_delete="invoices-add-delete-now";
$url_link_p_add_now='invoices-add-now';

?>

    <form class="forms-sample" method="post" action="<?php echo V_URLP.$url_link_p_add_now; ?>">
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php echo $core->txt('0185'); ?><br><br><br></h4>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="x1"><?php echo $core->txt('0140'); ?></label>
                                <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $v['invoice_id']; ?>">
                                <input name="invoice_total" type="text" class="form-control form-control-sm" id="x1" value="<?php echo $core->nf($v['invoice_total']).' '.$v['cur']; ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label for="x2"><?php echo $core->txt('0141'); ?></label>
                                <input name="discount" type="text" class="form-control form-control-sm" id="x2" value="<?php echo $core->nf($v['discount_percentage']).' %'; ?>" disabled>
                            </div>
                            <div class="col-sm-4">
                                <label for="dollar_price"><?php echo $core->txt('0182'); ?></label>
                                <input name="dollar_price" type="number" class="form-control form-control-sm" id="dollar_price" value="<?php echo $pay->USD_PRICE; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="debts"><?php echo $core->txt('0170'); ?></label>
                        <input name="debts" type="text" class="form-control form-control-sm" id="debts" value="<?php echo $v['total_debts']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="invoice_total_discount"><?php echo $core->txt('0183'); ?></label>
                                <input name="invoice_total_discount" type="text" class="form-control form-control-sm" id="invoice_total_discount" value="<?php echo $v['invoice_total_discount_view']; ?>" disabled>
                            </div>
                            <div class="col-sm-6">
                                <label for="invoice_total_debts"><?php echo $core->txt('0184'); ?></label>
                                <input name="invoice_total_debts" type="text" class="form-control form-control-sm" id="invoice_total_debts" value="<?php echo $v['total_with_debts']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 grid-margin stretch-card rtl">
            <div class="card">
                <div class="card-body">
                <h4 class="hb title-size center"><?php echo $core->txt('0139').' - '.$v['customer_name']; ?><br><br><br></h4>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="currency"><?php echo $core->txt('0102'); ?></label>
                                <select name="currency" class="form-control" id="currency">
                                    <option value="" selected><?php echo $core->txt('0068'); ?></option>
                                    <option value="IQD"><?php echo $core->txt('0047'); ?></option>
                                    <option value="USD"><?php echo $core->txt('0048'); ?></option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                                <label for="first_payment"><?php echo $core->txt('0174'); ?></label>
                                <input type="text" name="first_payment" class="form-control form-control-sm" id="first_payment" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="delivery"><?php echo $core->txt('0180'); ?></label>
                        <input name="delivery" type="text" class="form-control form-control-sm" id="delivery">
                    </div>
                    <div class="form-group">
                        <label for="details"><?php echo $core->txt('0181'); ?></label>
                        <input name="details" type="text" class="form-control form-control-sm" id="details">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p_delete; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                </div>
            </div>
        </div>
    </div>
    </form>

<?php echo $theme->getFooter(); ?>

<script type="text/javascript">
    (function ($) {
        
        $('#currency').on('change',function(){
            if($('#currency').val() == 'USD' || $('#currency').val() == 'IQD')
                $('#first_payment').prop('disabled', false);
            else{
                $('#first_payment').val('');
                $('#first_payment').prop('disabled', 'disabled');
            }
        });
        
    })(jQuery);
    
</script>