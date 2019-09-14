<?php 
    $core->userChkRole('REGISTRANTS-VIEW');
    if(!$core->chk_GET('id')){
        $core->err(404);
    }elseif(!$core->dbNumRows('courses', array('id' => $_GET['id']))){
        $core->err(404);
    }
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="col-lg-12" style="text-align: center;padding-top:7px;">
                    <h4 class="hb title-size"><?php echo $core->aes($core->dbFetch('courses', array('id' => $_GET['id']))[0]['name'], 1); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0298'); ?></h4>
                        </div>
                        <div class="col-lg-10 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('REGISTRANTS-EDIT')){ ?><button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'registrants-add&id='.$_GET['id']; ?>')"><?php echo $core->txt('0006'); ?></button><?php } ?>
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
                                  <th><?php echo $core->txt('0269'); ?></th>
                                  <th><?php echo $core->txt('0040'); ?></th>
                                  <th><?php echo $core->txt('0175'); ?></th>
                                  <th><?php echo $core->txt('0300'); ?></th>
                                  <?php if($core->userHaveRole('REGISTRANTS-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('registrants', array('course_id' => $_GET['id']), 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    $reg_data = $core->dbFetch('staff', array('id' => $r['staff_id']))[0];
                    echo "<td>".$core->aes($reg_data['name'], 1)."</td>";
                    echo "<td>".$core->aes($reg_data['job_title'], 1)."</td>";
                    echo "<td>".$core->aes($reg_data['mobile'], 1)."</td>";
                    echo "<td>";
                        if($core->aes($r['payment'], 1) != 'PAID'){
                            echo "<div class='badge badge-success badge-pill'>".$core->txt('0301')."</div>";
                        }else{
                            echo "<div class='badge badge-danger badge-pill'>".$core->txt('0302')."</div>";
                        }
                    echo "</td>";
                    echo "<td>";
                        if($core->aes($r['acceptance'], 1) == 'ACCEPTED'){
                            echo "<div class='badge badge-success badge-pill'>".$core->txt('0303')."</div>";
                        }elseif($core->aes($r['acceptance'], 1) == 'REJECTED'){
                            echo "<div class='badge badge-danger badge-pill'>".$core->txt('0305')."</div>";
                        }else{
                            echo "<div class='badge badge-danger badge-pill'>".$core->txt('0304')."</div>";
                        }
                    echo "</td>";
                    if($core->userHaveRole('REGISTRANTS-EDIT')){
                    echo "<td>";
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'registrants-delete-now'; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('registrants', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>