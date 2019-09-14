<?php 
    $core->userChkRole('APPROVAL-VIEW');
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0312'); ?></h4>
                        </div>
                        <div class="col-lg-10 rtl" style="margin-bottom:0;padding:0;"></div>
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
                                  <th><?php echo $core->txt('0309'); ?></th>
                                  <th><?php echo $core->txt('0310'); ?></th>
                                  <th><?php echo $core->txt('0175'); ?></th>
                                  <th><?php echo $core->txt('0308'); ?></th>
                                  <?php if($core->userHaveRole('APPROVAL-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('registrants', array(
            'acceptance'    => $core->aes('UNACCEPTED'),
            'payment'       => $core->aes('PAID')
        ), 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($core->dbFetch('staff', array('id' => $r['staff_id']))[0]['name'], 1)."</td>";
                    $course_arr = $core->dbFetch('courses', array('id' => $r['course_id']))[0];
                    echo "<td>".$core->aes($course_arr['name'], 1)."</td>";
                    echo "<td>".explode(' ', $r['created_at'])[0]."</td>";
                    echo "<td>".$core->nf($core->aes($course_arr['price'], 1))."</td>";
                    echo "<td>";
                        if($core->aes($r['payment'], 1) == 'PAID'){
                            echo "<div class='badge badge-success badge-pill'>".$core->txt('0301')."</div>";
                        }else{
                            echo "<div class='badge badge-danger badge-pill'>".$core->txt('0302')."</div>";
                        }
                    echo "</td>";
                    if($core->userHaveRole('APPROVAL-EDIT')){
                    echo "<td>";
                    echo "<a href='".V_URLP."students-view&id=".$r['staff_id']."' target='_blank'>".$core->txt('0011')."</a> - ";
                    echo "<a href='javascript:void(0);' onclick='goto(\"".V_URLP."approvals-approve-now&id=".$r['id']."\")'>".$core->txt('0313')."</a> - ";
                    echo "<a href='javascript:void(0);' onclick='doAlr(\"".V_URLP."approvals-reject-now&id=".$r['id']."\", \"".$core->txt('0030')."\")'>".$core->txt('0314')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('registrants', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>
<?php echo $theme->getFooter(); ?>