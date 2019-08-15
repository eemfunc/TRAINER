<?php
$core->userChkRole('DEBTS-SUBTRACT');

if($core->chk_GET('id')){
    if($core->dbNumRows('customers', array('id' => $_GET['id']))){
        define('ID', $_GET['id']);
    }else{
        $core->err(404);
    }
}else{
    $core->err(404);
}

echo $theme->getHeader();

$core->requireClass('payments');
$pay = new payments();
$total_credit = $pay->getDebts(ID);
if($pay->getDebts(ID, 'IQD') <= 0){
    $total_credit_color = '#00c689';
}else{
    $total_credit_color = '#fc7242';
}

?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="center" style="padding-top:8px;">
                    <?php $customer_name = $core->aes($core->dbFetch('customers', array('id' => ID))[0]['name'], 1); ?>
                    <h4 class="hb title-size"><?php echo $core->txt('0096').': '.$customer_name; ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
                
            <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php echo $core->txt('0173'); ?><br><br></h4>
                  <br>
                  <hr>
                  <div style="text-align:center;font-size:35px;color:<?php echo $total_credit_color; ?>;">
                    <?php echo $total_credit; ?>
                  </div>
                  <hr>
                </div>
            </div>
        </div>
         
        <div class="col-lg-6 grid-margin stretch-card rtl">
            <div class="card">
                <div class="card-body">
                <form autocomplete="off" target="_blank" class="forms-sample" method="post" action="<?php echo V_URLP.'debts-subtract-now'; ?>">
                  <input autocomplete="false" name="hidden" type="text" style="display:none;">
                  
                  <h4 class="hb title-size center"><?php echo $core->txt('0260'); ?><br></h4>
                  <br>
                  <div class="row">
                    <div class="col-lg-4 form-group">
                        <label class="col-form-label"><?php echo $core->txt('0102'); ?> *</label>
                        <input name="customer_id" value="<?php echo ID; ?>" type="hidden">
                        <select name="currency" id="currency" class="form-control" style="margin-top: 0px;">
                            <option value="IQD" selected><?php echo $core->txt('0047'); ?></option>
                            <option value="USD"><?php echo $core->txt('0048'); ?></option>
                        </select>
                    </div>
                    <div class="col-lg-8 form-group"  style="top:10px;">
                        <label for="amount"><?php echo $core->txt('0175'); ?> *</label>
                        <input name="amount" type="number" class="form-control form-control-sm" id="amount">
                    </div>
                  </div>
                    <br>
                  <button type="submit" class="btn btn-primary"><?php echo $core->txt('0176'); ?></button>
                </form>
                </div>
            </div>
        </div>
        
    </div>

<?php echo $theme->getFooter(); ?>