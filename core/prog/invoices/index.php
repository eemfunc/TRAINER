<?php 
    $core->userChkRole('INVOICES-VIEW');
    echo $theme->getHeader(); 

$db_table="invoices";
$url_link_p="invoices";
$url_link_p_delete="invoices-delete-now";
$url_link_p_delete_products="invoices-invoice-products-delete-now";
$url_link_p_add="invoices-add";
/*$url_link_p_activation="";*/

?>
    <?php if($core->userHaveRole('INVOICES-EDIT')){ ?>
    <?php
        /* DRAFT TABLE */
        $draft_arr = array();
        $rows = $core->dbFetch('invoices_products', array('draft' => '1'));
        foreach($rows as $r){
            if($r['branch_id'] == $core->userData('branch_id') || $core->userHaveRole('INVOICES-ALL-ACCESS')){
                if(!$core->in_array_v1($r['invoice_id'], $draft_arr)){
                    array_push($draft_arr, array($r['invoice_id'], explode(' ', $r['created_at'])[0]));
                }
            }
        }
        if(count($draft_arr) > 0){
    ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                        <h4 class="hb title-size center"><?php echo $core->txt('0099'); ?><br><br></h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th><?php echo $core->txt('0137'); ?></th>
                                  <th><?php echo $core->txt('0097'); ?></th>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for($i = 0; $i < count($draft_arr); $i++){
                                    $customer_id = $core->dbFetch('invoices_products', array('invoice_id' => $draft_arr[$i][0]), 'ORDER BY created_at DESC LIMIT 1')[0]['customer_id'];
                                    if($customer_id != '')
                                        $customer_name = $core->aes($core->dbFetch('customers', array('id' => $customer_id))[0]['name'], 1);
                                    else $customer_name = '';
                                    $txt = ($customer_name == '') ? $draft_arr[$i][0] : $customer_name;
                                    echo "<tr>";
                                    echo "<td>".$txt."</td>";
                                    echo "<td>".$draft_arr[$i][1]."</td>";
                                    echo "<td>"
                                            ."<a href='".V_URLP.$url_link_p_add."&id=".$draft_arr[$i][0]."' target='_blank'>"
                                                .$core->txt('0027')
                                            ."</a> - ";
                                            ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p_delete_products; ?>&id=<?php echo $draft_arr[$i][0]; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
                    
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-3" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0098'); ?></h4>
                        </div>
                        
                        <div class="col-lg-9 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('INVOICES-EDIT')){ ?><button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:window.open('<?php echo V_URLP.$url_link_p_add; ?>')"><?php echo $core->txt('0006'); ?></button><?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
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
        $rows = $core->dbFetch('invoices', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits($r['branch_id'] == $core->userData('branch_id') || $core->userHaveRole('INVOICES-ALL-ACCESS'))){
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
                        echo $core->nf($core->aes($r['invoice_total_discount'], 1)).' ';
                        if($core->aes($invoices_products_arr[0]["currency"], 1) == 'USD')echo $core->txt('0135');
                        else echo $core->txt('0134');
                    echo "</td>";
                    echo "<td>".explode(' ', $r['created_at'])[0]."</td>";
                    echo "<td>";
                        echo '<a href="'.V_URLP.$url_link_p_add."&id=".$r['id'].'" target="_blank">'.$core->txt('0147')."</a>";
                    echo "<br><br>";
                        echo '<a href="'.V_URLP.'invoices-print&id='.$r['id'].'" target="_blank">'.$core->txt('0203')."</a>";
                    echo "<br><br>";
                        echo '<a href="'.V_URLP.'invoices-print-delivery&id='.$r['id'].'" target="_blank">'.$core->txt('0204')."</a>";
                    echo "</td>";
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('invoices', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>