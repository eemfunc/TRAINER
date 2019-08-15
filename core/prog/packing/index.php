<?php 
    $core->userChkRole('PACKING-VIEW');
    echo $theme->getHeader(); 

if(!isset($_GET['id']))
    $core->err(404);
if(!$core->dbNumRows('products', array('id' => $_GET['id'])))
    $core->err(404);

$db_table="packing";
$url_link_p="packing&id=".$_GET['id'];
$url_link_p_delete="packing-delete-now&product_id=".$_GET['id'];
$url_link_p_add="packing-add&id=".$_GET['id'];

?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php
                        $p_data = $core->dbFetch('products', array('id' => $_GET['id']));
                        $p_txt = $core->aes($p_data[0]['name'], 1);
                        $p_txt .= '&nbsp;<span>&#x200F;'.$core->aes($p_data[0]['item_no'], 1).'</span>';
                    ?>
                    <h4 class="hb title-size center"><?php echo $core->txt('0128').' - '.$p_txt; ?><br><br></h4>
                    <?php if($core->userHaveRole('PACKING-EDIT')){ ?>
                    <p class="card-description rtl">
                        <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.$url_link_p_add; ?>')"><?php echo $core->txt('0006'); ?></button>
                    </p>
                    <?php } ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th><?php echo $core->txt('0057'); ?></th>
                                  <th><?php echo $core->txt('0066'); ?></th>
                                  <?php if($core->userHaveRole('PACKING-EDIT')){ ?><th><?php echo $core->txt('0026'); ?></th><?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $core->txt('0129'); ?></td>
                                    <td>1</td>
                                    <?php if($core->userHaveRole('PACKING-EDIT')){ ?><td></td><?php } ?>
                                </tr>

    <?php
        $rows = $core->dbFetch('packing', array('product_id' => $_GET['id']), 'ORDER BY created_at ASC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    echo "<td>".$core->aes($r['quantity'], 1)."</td>";
                    if($core->userHaveRole('PACKING-EDIT')){
                    echo "<td>";
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p_delete; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        define('HIDE_EMPTY_TABLE_INFO', true);
        echo $theme->fetchFooter('packing', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>