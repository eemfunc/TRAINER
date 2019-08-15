<?php
    $core->userChkRole('EXPENSES-EDIT');
    echo $theme->getHeader();
    $id             = (isset($_GET['id'])) ? $_GET['id'] : null;
    $data_arr       = $core->dbFetch('expenses', array('id' => $id));
    $exp_cat_id     = (!isset($_GET['id'])) ? null : $data_arr[0]['expenses_categories_id'];
    $details        = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['details'], 1);
    $amount         = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['amount'], 1);
    $currency       = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['currency'], 1);
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo ($id == null) ? $core->txt('0265') : $core->txt('0266'); ?><br><br></h4>
                    <form class="forms-sample" method="post" action="<?php echo V_URLP.'expenses-add-now'; ?>">
                        <input name="id" type="hidden" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="expenses_category"><?php echo $core->txt('0267'); ?> *</label>
                            <select name="expenses_category" id="expenses_category" class="form-control">
                                <?php 
                                if($id == null){
                                    echo '<option value="">'.$core->txt('0068').'</option>';
                                }
                                $rows = $core->dbFetch('expenses_categories', null, 'ORDER BY created_at DESC');
                                foreach($rows as $r){
                                    $selected = ($id != null && $exp_cat_id == $r['id']) ? ' selected' : null;
                                    echo '<option value="'.$r['id'].'"'.$selected.'>'.$core->aes($r['name'], 1).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="currency"><?php echo $core->txt('0102'); ?> *</label>
                            <select name="currency" id="currency" class="form-control">
                                <option value=""><?php echo $core->txt('0068'); ?></option>
                                <option value="IQD"<?php echo ($currency == 'IQD') ? ' selected' : null; ?>><?php echo $core->txt('0047'); ?></option>
                                <option value="USD"<?php echo ($currency == 'USD') ? ' selected' : null; ?>><?php echo $core->txt('0048'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount"><?php echo $core->txt('0175'); ?> *</label>
                            <input name="amount" value="<?php echo $amount; ?>" type="text" class="form-control form-control-sm" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="details"><?php echo $core->txt('0053'); ?> *</label>
                            <input name="details" value="<?php echo $details; ?>" type="text" class="form-control form-control-sm" id="details">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'expenses'; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>