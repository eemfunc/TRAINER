<?php 
    $core->userChkRole('STUDENTS-VIEW');
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0264'); ?></h4>
                        </div>
                        <div class="col-lg-10 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('STUDENTS-EDIT')){ ?><button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'students-add'; ?>')"><?php echo $core->txt('0006'); ?></button><?php } ?>
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
                                  <?php if($core->userHaveRole('STUDENTS-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('staff', array('type' => $core->aes('STUDENT')), 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    echo "<td>".$core->aes($r['job_title'], 1)."</td>";
                    echo "<td>".$core->aes($r['mobile'], 1)."</td>";
                    if($core->userHaveRole('STUDENTS-EDIT')){
                    echo "<td>";
                    echo "<a href='".V_URLP."students-add&id=".$r['id']."'>".$core->txt('0019')."</a> - ";
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'students-delete-now'; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('students', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>