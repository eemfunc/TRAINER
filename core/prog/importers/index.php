<?php 
    $core->userChkRole('IMPORTERS-VIEW');
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0092'); ?></h4>
                        </div>
                        <div class="col-lg-10 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('IMPORTERS-EDIT')){ ?><button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'importers-add'; ?>')"><?php echo $core->txt('0006'); ?></button><?php } ?>
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
                                  <?php if($core->userHaveRole('IMPORTERS-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('importers', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    if($core->userHaveRole('IMPORTERS-EDIT')){
                    echo "<td>";
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'importers-delete-now'; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('importers', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>