<?php 
    $core->userChkRole('BRANCHES-VIEW');
    echo $theme->getHeader(); 
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0058'); ?></h4>
                        </div>
                        
                        <div class="col-lg-10 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('BRANCHES-EDIT')){ ?>
                            <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'branches-add'; ?>')"><?php echo $core->txt('0006'); ?></button>
                            <?php } ?>
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
                                  <th><?php echo $core->txt('0062'); ?></th>
                                  <th><?php echo $core->txt('0253'); ?></th>
                                  <th><?php echo $core->txt('0243'); ?></th>
                                  <?php if($core->userHaveRole('BRANCHES-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
               
    <?php
        $rows = $core->dbFetch('branches', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    echo "<td>".$core->aes($r['location'], 1)."</td>";
                    echo "<td>".$core->aes($r['type'], 1)."</td>";
                    echo "<td>";
                        if($r['admin_user_id'])
                            echo $core->aes($core->dbFetch('users', array('id' => $r['admin_user_id']))[0]['name'], 1);
                    echo "</td>";
                    if($core->userHaveRole('BRANCHES-EDIT')){
                    echo "<td>";
                        echo "<a href='".V_URLP."branches-add&id=".$r['id']."'>".$core->txt('0027')."</a>";
                        echo ' - ';
                        echo "<a href=\"javascript:void(0);\" onclick=\"doAlr('".V_URLP."branches-delete-now&id=".$r['id']."', '".$core->txt('0030')."')\">".$core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('branches', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
    ?>
</div></div></div></div></div>

<?php echo $theme->getFooter(); ?>