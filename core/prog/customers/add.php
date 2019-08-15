<?php

if(isset($_GET['id'])){
    $core->userChkRole('CUSTOMERS-VIEW');
    if($_GET['id'] != null)
        if($core->dbNumRows('customers', array('id' => $_GET['id'])))
            define('ID', $_GET['id']);
        else $core->err(404);
    else $core->err(404);
}else
    $core->userChkRole('CUSTOMERS-EDIT');

echo $theme->getHeader();

$v = array('', '', '', '', '', '', '', '');
if(defined('ID')){
    $rows = $core->dbFetch('customers', array('id' => ID));
    foreach($rows as $r){
        $v[0] = $core->aes($r['name'], 1);
        $v[1] = $core->aes($r['company'], 1);
        $v[2] = $core->aes($r['mobile_1'], 1);
        $v[3] = $core->aes($r['mobile_2'], 1);
        $v[4] = $core->aes($r['city'], 1);
        $v[5] = $core->aes($r['region'], 1);
        $v[6] = $core->aes($r['address'], 1);
        $v[7] = $core->aes($r['credit_limit'], 1);
    }
}

?>

    <?php if(defined('ID')){ ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div>
                        <div class="col-lg-12 row">
                            <div class="col-lg-3" style="top:5px;padding-left:25px;">
                                <h4 class="hb title-size"><?php echo $core->txt('0255'); ?></h4>
                            </div>
                            
                            <div class="col-lg-9 rtl" style="margin-bottom:0;padding:0;">
                                <?php if($core->userHaveRole('CUSTOMERS-EDIT')){ ?>
                                    <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP; ?>customers-add')"><?php echo $core->txt('0259'); ?></button>
                                <?php } ?>
                                <?php if($core->userHaveRole('DEBTS-SUBTRACT')){ ?>
                                    <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'debts-subtract&id='.ID; ?>')"><?php echo $core->txt('0170'); ?></button>
                                <?php } ?>
                                <?php if($core->userHaveRole('CUSTOMERS-DELETE')){ ?>
                                    <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:doAlr('<?php echo V_URLP.'customers-delete-now&id='.ID; ?>', '<?php echo $core->txt('0199'); ?>')"><?php echo $core->txt('0200'); ?></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row">
            <div class="col-lg-3"></div>
                
            <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php if(defined('ID'))echo $core->txt('0188');else echo $core->txt('0042'); ?><br><br></h4>
                  <form autocomplete="off" class="forms-sample" method="post" action="<?php echo V_URLP.'customers-add-now';if(defined('ID'))echo '&id='.ID; ?>">
                    <input autocomplete="false" name="hidden" type="text" style="display:none;">
                    <div class="form-group">
                      <label for="name"><?php echo $core->txt('0015'); ?> *</label>
                      <input name="name" value="<?php echo $v[0]; ?>" type="text" class="form-control form-control-sm" id="name" <?php if(defined('ID'))echo 'disabled'; ?>>
                    </div>
                    <div class="form-group">
                      <label for="company"><?php echo $core->txt('0039'); ?></label>
                      <input name="company" value="<?php echo $v[1]; ?>" type="text" class="form-control form-control-sm" id="company" <?php if(defined('ID'))echo 'disabled'; ?>>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <label for="mobile_1"><?php echo $core->txt('0040'); ?> 1</label>
                          <input name="mobile_1" value="<?php echo $v[2]; ?>" type="text" class="form-control form-control-sm" id="mobile_1" <?php if(defined('ID'))echo 'disabled'; ?>>
                        </div>
                        <div class="col-sm-6">
                          <label for="mobile_2"><?php echo $core->txt('0040'); ?> 2</label>
                          <input name="mobile_2" value="<?php echo $v[3]; ?>" type="text" class="form-control form-control-sm" id="mobile_2" <?php if(defined('ID'))echo 'disabled'; ?>>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                    <div class="row">
                    <div class="col-sm-4">
                      <label for="city"><?php echo $core->txt('0169'); ?></label>
                      <select name="city" class="form-control" id="city" <?php if(defined('ID'))echo 'disabled'; ?>>
            <option value="<?php echo $core->txt('0151'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0151'))echo 'selected'; ?>><?php echo $core->txt('0151'); ?></option>
            <option value="<?php echo $core->txt('0152'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0152'))echo 'selected'; ?>><?php echo $core->txt('0152'); ?></option>
            <option value="<?php echo $core->txt('0168'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0168'))echo 'selected'; ?>><?php echo $core->txt('0168'); ?></option>
            <option value="<?php echo $core->txt('0153'); ?>"<?php if($v[4] != ''){if($v[4] == $core->txt('0153'))echo 'selected';}else echo 'selected'; ?>><?php echo $core->txt('0153'); ?></option>
            <option value="<?php echo $core->txt('0154'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0154'))echo 'selected'; ?>><?php echo $core->txt('0154'); ?></option>
            <option value="<?php echo $core->txt('0155'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0155'))echo 'selected'; ?>><?php echo $core->txt('0155'); ?></option>
            <option value="<?php echo $core->txt('0156'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0156'))echo 'selected'; ?>><?php echo $core->txt('0156'); ?></option>
            <option value="<?php echo $core->txt('0157'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0157'))echo 'selected'; ?>><?php echo $core->txt('0157'); ?></option>
            <option value="<?php echo $core->txt('0158'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0158'))echo 'selected'; ?>><?php echo $core->txt('0158'); ?></option>
            <option value="<?php echo $core->txt('0159'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0159'))echo 'selected'; ?>><?php echo $core->txt('0159'); ?></option>
            <option value="<?php echo $core->txt('0160'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0160'))echo 'selected'; ?>><?php echo $core->txt('0160'); ?></option>
            <option value="<?php echo $core->txt('0161'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0161'))echo 'selected'; ?>><?php echo $core->txt('0161'); ?></option>
            <option value="<?php echo $core->txt('0162'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0162'))echo 'selected'; ?>><?php echo $core->txt('0162'); ?></option>
            <option value="<?php echo $core->txt('0163'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0163'))echo 'selected'; ?>><?php echo $core->txt('0163'); ?></option>
            <option value="<?php echo $core->txt('0164'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0164'))echo 'selected'; ?>><?php echo $core->txt('0164'); ?></option>
            <option value="<?php echo $core->txt('0165'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0165'))echo 'selected'; ?>><?php echo $core->txt('0165'); ?></option>
            <option value="<?php echo $core->txt('0166'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0166'))echo 'selected'; ?>><?php echo $core->txt('0166'); ?></option>
            <option value="<?php echo $core->txt('0167'); ?>"<?php if($v[4] != '')if($v[4] == $core->txt('0167'))echo 'selected'; ?>><?php echo $core->txt('0167'); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                      <label for="region"><?php echo $core->txt('0045'); ?></label>
                      <input name="region" value="<?php echo $v[5]; ?>" type="text" class="form-control form-control-sm" id="region" <?php if(defined('ID'))echo 'disabled'; ?>>
                    </div>
                    <div class="col-sm-4">
                      <label for="address"><?php echo $core->txt('0041'); ?></label>
                      <input name="address" value="<?php echo $v[6]; ?>" type="text" class="form-control form-control-sm" id="address" <?php if(defined('ID'))echo 'disabled'; ?>>
                    </div>
                  </div>
                </div> 
                        
                    <div class="form-group">
                      <label for="credit_limit"><?php echo $core->txt('0046').' ('.$core->txt('0048').')'; ?></label>
                      <input name="credit_limit" value="<?php echo $v[7]; ?>" type="number" class="form-control form-control-sm" id="credit_limit" <?php if(defined('ID'))echo 'disabled'; ?>>
                    </div>

                    <?php if($core->userHaveRole('CUSTOMERS-EDIT')){ ?>
                    <?php if(defined('ID')){ ?>
                        <div id="edit_buttons"><a href="javascript:void(0);" onclick="editCustomer()" style="font-size:14px;"><?php echo $core->txt('0172'); ?></a></div>
                    <?php }else{ ?>
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>'customers, '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    <?php } ?>
                    <?php } ?>
                </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3"></div>
        
    </div>

    <?php if(defined('ID')){ ?>
    <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="hb title-size center"><?php echo $core->txt('0178'); ?><br><br></h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                      <th><?php echo $core->txt('0096'); ?></th>
                      <th><?php echo $core->txt('0149'); ?></th>
                      <th><?php echo $core->txt('0061'); ?></th>
                      <th><?php echo $core->txt('0084'); ?></th>
                      <th><?php echo $core->txt('0097'); ?></th>
                      <th><?php echo $core->txt('0019'); ?></th>
                    </tr>
                </thead>
                <tbody>

    <?php
        $rows = $core->dbFetch('invoices', array('customer_id' => ID), 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                $invoices_products_arr = $core->dbFetch('invoices_products', array('invoice_id' => $r['id']), 'ORDER BY created_at DESC LIMIT 1');
                echo "<tr>";
                    echo "<td>";
                        $customer_id = $invoices_products_arr[0]["customer_id"];
                        echo $core->aes($core->dbFetch('customers', array('id' => $customer_id))[0]["name"], 1);
                    echo "</td>";
                    echo "<td>";
                        $user_id = $invoices_products_arr[0]["user_id"];
                        echo $core->aes($core->dbFetch('users', array('id' => $user_id))[0]["name"], 1);
                    echo "</td>";
                    echo "<td>";
                        $branch_id = $r["branch_id"];
                        echo ($branch_id) ? $core->aes($core->dbFetch('branches', array('id' => $branch_id))[0]["name"], 1) : '';
                    echo "</td>";
                    echo "<td>";
                        echo $core->nf($core->aes($r['invoice_total'], 1)).' ';
                        if($core->aes($invoices_products_arr[0]["currency"], 1) == 'USD')echo $core->txt('0135');
                        else echo $core->txt('0134');
                    echo "</td>";
                    echo "<td>".explode(' ', $r['created_at'])[0]."</td>";
                    echo "<td>";
                        echo '<a href="'.V_URLP."invoices-add&id=".$r['id'].'" target="_blank">'.$core->txt('0147')."</a>";
                    echo "&nbsp;-&nbsp;";
                    ?><a href="#"><?php echo $core->txt('0148')."</a>";
                    echo "</td>";
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('invoices', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);                     
    ?>
    </div></div></div></div></div>
    <?php } ?>


<?php echo $theme->getFooter(); ?>

<script type="text/javascript">
                                                                                                    
    function editCustomer(){
        $("#name").attr("disabled", false);
        $("#company").attr("disabled", false);
        $("#mobile_1").attr("disabled", false);
        $("#mobile_2").attr("disabled", false);
        $("#city").attr("disabled", false);
        $("#region").attr("disabled", false);
        $("#address").attr("disabled", false);
        $("#credit_limit").attr("disabled", false);
        document.getElementById("edit_buttons").innerHTML='<button type="submit" class="btn btn-primary"><?php echo $core->txt('0138'); ?></button>';
    }
    
</script>