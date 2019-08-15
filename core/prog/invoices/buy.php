<?php echo $theme->getHeader(); 

$db_table="invoices_buy";
$url_link_p="invoices-buy";
$url_link_p_delete="invoices-buy-delete-now";
$url_link_p_delete_products="invoices-buy-products-delete-now";
$url_link_p_add="invoices-buy-add";
/*$url_link_p_activation="";*/

?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php
                    /* DRAFT TABLE */
                    $draft_arr = array(); 
                    $rows = $core->dbFetch('invoices_buy_products', array('draft' => '1'));
                    foreach($rows as $r)
                        if(!in_array($r['invoice_id'], $draft_arr))
                            array_push($draft_arr, $r['invoice_id']);
                    if(count($draft_arr)>0){
                        ?>
                        <h4 class="hb title-size center"><?php echo $core->txt('0094'); ?><br><br></h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th><?php echo $core->txt('0013'); ?></th>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for($i=0;$i<count($draft_arr);$i++){
                                    echo "<tr>";
                                    echo "<td>".$draft_arr[$i]."</td>";
                                    echo "<td>"
                                            ."<a href='".V_URLP.$url_link_p_add."&id=".$draft_arr[$i]."'>"
                                                .$core->txt('0027')
                                            ."</a>&nbsp;-&nbsp;";
                                            ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p_delete_products; ?>&id=<?php echo $draft_arr[$i]; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <br><br><br><br>
                        <?php
                    }
                    ?>
                    
                    
                    <h4 class="hb title-size center"><?php echo $core->txt('0079'); ?><br><br></h4>
                    <p class="card-description rtl">
                        <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.$url_link_p_add; ?>')"><?php echo $core->txt('0006'); ?></button>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th><?php echo $core->txt('0013'); ?></th>
                                  <th><?php echo $core->txt('0083'); ?></th>
                                  <th><?php echo $core->txt('0085'); ?></th>
                                  <th><?php echo $core->txt('0039'); ?></th>
                                  <th><?php echo $core->txt('0084'); ?></th>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('invoices_buy', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$r['id']."</td>";
                    echo "<td>".$core->aes($r['invoice_no'], 1)."</td>";
                    echo "<td>".
                        $core->aes($core->dbFetch('importers', array('id' => $r['importer_id']))[0]["name"], 1)
                        ."</td>";
                    echo "<td>".$core->aes($r['company'], 1)."</td>";
                    echo "<td>";
                        $total_price = 0;
                        $rows1 = $core->dbFetch('invoices_buy_products', array('invoice_id' => $r['id']));
                        foreach($rows1 as $r1){
                            $r1_q = $core->aes($r1['quantity'], 1);
                            $r1_p = $core->aes($r1['price'], 1);
                            $total_price = $total_price + ($r1_q * $r1_p);
                        }
                        echo number_format($total_price, 2, '.', ',').' $';
                    echo "</td>";
                    echo "<td>";
                    ?><a href="<?php echo V_URLP.$url_link_p_add; ?>&id=<?php echo $r['id']; ?>"><?php echo $core->txt('0027')."</a>";
                    echo "&nbsp;-&nbsp;";
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p_delete; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    echo "</td>";
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('invoices_buy', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);                  
    ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>