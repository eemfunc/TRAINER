<?php 
    $core->requireClass('roles-class', 'roles');
    $roles = new roles();
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-3" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0244'); ?></h4>
                        </div>
                        
                        <div class="col-lg-9 rtl" style="margin-bottom:0;padding:0;">
                            <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="goto('<?php echo V_URLP; ?>roles-add')"><?php echo $core->txt('0006'); ?></button>
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
                                  <th><?php echo $core->txt('0244'); ?></th>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $roles->initTableArr();
                                    if(!count($roles->TABLE_ARR)){
                                        echo $theme->noTableData();
                                    }else{
                                        for($i = 0; $i < count($roles->TABLE_ARR); $i++){ ?>
                                <tr>
                                    <td><?php echo $roles->TABLE_ARR[$i]['name']; ?></td>
                                    <td><?php echo $core->minStr($roles->TABLE_ARR[$i]['roles']); ?></td>
                                    <td><a href="javascript:void(0)" onclick="goto('<?php echo V_URLP; ?>roles-add&id=<?php echo $roles->TABLE_ARR[$i]['id']; ?>')"><?php echo $core->txt('0019'); ?></a> - <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>roles-delete-now&id=<?php echo $roles->TABLE_ARR[$i]['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026'); ?></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br>
                        <div class='row' style='width:100%;'>
                            <?php echo $theme->tablePagination($roles->PAGE, $roles->TOTAL_PAGES, 'roles'); ?>
                            <?php echo $theme->tableCountersInfo($roles->START_FROM, $roles->START_TO, $roles->TOTAL_ROWS); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $theme->getFooter(); ?>