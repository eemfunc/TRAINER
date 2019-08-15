<?php 
    $core->userChkRole('STORES-TRANSPORT-PRODUCTS-EDIT');
    $core->requireClass('transport-products-class', 'stores');
    $tp = new tp();
    echo $theme->getHeader();
?>
    <!-- DRAFT TABLE -->
    <?php $tp->initDraftArr(); ?>
    <?php if(count($tp->DRAFT_ARR)){ ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo $core->txt('0229'); ?><br><br></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th><?php echo $core->txt('0137'); ?></th>
                              <th><?php echo $core->txt('0231'); ?></th>
                              <th><?php echo $core->txt('0097'); ?></th>
                              <th><?php echo $core->txt('0019'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 0; $i < count($tp->DRAFT_ARR); $i++){ ?>
                            <tr>
                                <td><?php echo $core->txt('0227'); ?> <b><?php echo $tp->DRAFT_ARR[$i]['sf']; ?></b> <?php echo $core->txt('0228'); ?> <b><?php echo $tp->DRAFT_ARR[$i]['st']; ?></b></td>
                                <td><?php echo $tp->DRAFT_ARR[$i]['un']; ?></td>
                                <td><?php echo $tp->DRAFT_ARR[$i]['da']; ?></td>
                                <td>
                                    <a href='<?php echo V_URLP; ?>stores-transport-products-add&id=<?php echo $tp->DRAFT_ARR[$i]['id']; ?>' target='_blank'><?php echo $core->txt('0027'); ?></a> - <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>stores-transport-products-delete-now&id=<?php echo $tp->DRAFT_ARR[$i]['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026'); ?></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-3" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0230'); ?></h4>
                        </div>
                        
                        <div class="col-lg-9 rtl" style="margin-bottom:0;padding:0;">
                            <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="goto('<?php echo V_URLP; ?>stores-transport-products-add')"><?php echo $core->txt('0223'); ?></button>
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
                                  <th><?php echo $core->txt('0225'); ?></th>
                                  <th><?php echo $core->txt('0226'); ?></th>
                                  <th><?php echo $core->txt('0231'); ?></th>
                                  <th><?php echo $core->txt('0252'); ?></th>
                                  <th><?php echo $core->txt('0017'); ?></th>
                                  <th><?php echo $core->txt('0232'); ?></th>
                                  <th><?php echo $core->txt('0233'); ?></th>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tp->initTableArr();
                                    if(!count($tp->TABLE_ARR)){
                                        echo $theme->noTableData();
                                    }else{
                                        for($i = 0; $i < count($tp->TABLE_ARR); $i++){ ?>
                                <tr>
                                    <td><?php echo $tp->TABLE_ARR[$i]['sf']; ?></td>
                                    <td><?php echo $tp->TABLE_ARR[$i]['st']; ?></td>
                                    <td><?php echo $tp->TABLE_ARR[$i]['u_name']; ?></td>
                                    <td><?php echo $tp->TABLE_ARR[$i]['dbun']; ?></td>
                                    <?php if($tp->TABLE_ARR[$i]['status'] == 0){ ?>
                                        <td><div class='badge badge-warning badge-pill'><?php echo $core->txt('0234'); ?></div></td>
                                    <?php }elseif($tp->TABLE_ARR[$i]['status'] == 1){ ?>
                                        <td><div class='badge badge-success badge-pill'><?php echo $core->txt('0235'); ?></div></td>
                                    <?php }else{ ?>
                                        <td><div class='badge badge-danger badge-pill'><?php echo $core->txt('0242'); ?></div></td>
                                    <?php } ?>
                                    <td><?php echo $tp->TABLE_ARR[$i]['created_date']; ?></td>
                                    <td><?php echo $tp->TABLE_ARR[$i]['arrival_date']; ?></td>
                                    <td><a href="<?php echo V_URLP; ?>stores-transport-products-add&id=<?php echo $tp->TABLE_ARR[$i]['id']; ?>" target="_blank"><?php echo $core->txt('0147'); ?></a><?php if($tp->TABLE_ARR[$i]['status'] == 0 && $core->userHaveRole('STORES-TRANSPORT-PRODUCTS-EDIT') && $tp->TABLE_ARR[$i]['st_b_to'] == $core->userData('branch_id')){ ?><br><br><a href="<?php echo V_URLP; ?>stores-transport-products-accept-now&id=<?php echo $tp->TABLE_ARR[$i]['id']; ?>"><?php echo $core->txt('0250'); ?></a><br><br><a href="<?php echo V_URLP; ?>stores-transport-products-reject-now&id=<?php echo $tp->TABLE_ARR[$i]['id']; ?>"><?php echo $core->txt('0251'); ?></a><?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br>
                        <div class='row' style='width:100%;'>
                            <?php echo $theme->tablePagination($tp->PAGE, $tp->TOTAL_PAGES, 'stores-transport-products'); ?>
                            <?php echo $theme->tableCountersInfo($tp->START_FROM, $tp->START_TO, $tp->TOTAL_ROWS); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $theme->getFooter(); ?>