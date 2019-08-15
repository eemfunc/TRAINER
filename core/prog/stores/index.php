<?php 
    $core->userChkRole('STORES-VIEW');
    echo $theme->getHeader(); 

$url_link_p="stores";

?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0060'); ?></h4>
                        </div>
                        
                        <div class="col-lg-10 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('STORES-EDIT')){ ?><button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'stores-add'; ?>')"><?php echo $core->txt('0006'); ?></button><?php } ?>
                        
                            <?php if($core->userHaveRole('STORES-TRANSPORT-PRODUCTS-VIEW')){ ?><button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'stores-transport-products'; ?>')"><?php echo $core->txt('0223'); ?></button><?php } ?>
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
                                  <th><?php echo $core->txt('0057'); ?></th>
                                  <th><?php echo $core->txt('0061'); ?></th>
                                  <th><?php echo $core->txt('0062'); ?></th>
                                  <?php if($core->userHaveRole('STORES-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('stores', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    
                    $branch_name = ($r['branch_id'] != null) ? $core->aes($core->dbFetch('branches', array('id' => $r['branch_id']))[0]['name'], 1) : '';
                    echo "<td>".$branch_name."</td>";
                    
                    echo "<td>".$core->aes($r['location'], 1)."</td>";
                    if($core->userHaveRole('STORES-EDIT')){
                    echo "<td>";
                    echo "<a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP."stores-add&id=".$r['id']."')\">".$core->txt('0027')."</a>";
                    echo ' - ';
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'stores-delete-now'; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('stores', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>