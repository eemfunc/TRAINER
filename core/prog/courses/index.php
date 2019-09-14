<?php 
    $core->userChkRole('COURSES-VIEW');
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0283'); ?></h4>
                        </div>
                        <div class="col-lg-10 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('COURSES-EDIT')){ ?><button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'courses-add'; ?>')"><?php echo $core->txt('0006'); ?></button><?php } ?>
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
                                  <th><?php echo $core->txt('0284'); ?></th>
                                  <th><?php echo $core->txt('0286'); ?></th>
                                  <th><?php echo $core->txt('0287'); ?></th>
                                  <?php if($core->userHaveRole('COURSES-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('courses', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    $t = $core->aes($r['type'], 1);
                    $txt = null;
                    if($t == "COURSE01"){
                        $txt = $core->txt("0288");
                    }elseif($t == "COURSE02"){
                        $txt = $core->txt("0289");
                    }elseif($t == "COURSE03"){
                        $txt = $core->txt("0290");
                    }elseif($t == "COURSE04"){
                        $txt = $core->txt("0291");
                    }
                    echo "<td>".$txt."</td>";
                    echo "<td>".$core->aes($r['start_date'], 1)."</td>";
                    $num_reg = $core->dbNumRows('registrants', array(
                        'course_id'     => $r['id'],
                        'payment'       => $core->aes('PAID'),
                        'acceptance'    => $core->aes('ACCEPTED')
                    ));
                    echo "<td>".$num_reg."</td>";
                    if($core->userHaveRole('COURSES-EDIT')){
                    echo "<td>";
                    echo "<a href='".V_URLP."registrants&id=".$r['id']."'>".$core->txt('0298')."</a> - ";
                    echo "<a href='".V_URLP."courses-add&id=".$r['id']."'>".$core->txt('0019')."</a> - ";
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'courses-delete-now'; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('courses', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>