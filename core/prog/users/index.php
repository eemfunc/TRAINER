<?php 
    $core->userChkRole('USERS-VIEW');
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-3" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0005'); ?></h4>
                        </div>
                        
                        <div class="col-lg-9 rtl" style="margin-bottom:0;padding:0;">
                            <?php if($core->userHaveRole('USERS-EDIT')){ ?>
                            <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP.'users-add'; ?>')"><?php echo $core->txt('0006'); ?></button>
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
                                  <th><?php echo $core->txt('0015'); ?></th>
                                  <th><?php echo $core->txt('0016'); ?></th>
                                  <th><?php echo $core->txt('0061'); ?></th>
                                  <th><?php echo $core->txt('0244'); ?></th>
                                  <th><?php echo $core->txt('0017'); ?></th>
                                  <?php if($core->userHaveRole('USERS-EDIT')){ ?>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                  <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
               
    <?php
        $rows = $core->dbFetch('users', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    echo "<td>".$core->aes($r['email'], 1)."</td>";
                    
                    $branch_name = ($r['branch_id'] != null) ? $core->aes($core->dbFetch('branches', array('id' => $r['branch_id']))[0]['name'], 1) : '';
                    echo "<td>".$branch_name."</td>";
                
                    $role_name = ($r['roles_id'] != null) ? $core->aes($core->dbFetch('roles', array('id' => $r['roles_id']))[0]['name'], 1) : '';
                    echo "<td>".$role_name."</td>";
                
                    echo "<td>";
                        if($r['activated'])
                            echo "<div class='badge badge-success badge-pill'>".$core->txt('0028')."</div>";
                        else echo "<div class='badge badge-danger badge-pill'>".$core->txt('0029')."</div>";
                    echo "</td>";
                    if($core->userHaveRole('USERS-EDIT')){
                    echo "<td>";
                        echo "<a href=\"javascript:void(0);\" onclick=\"javascript:goto('".V_URLP."users-add&id=".$r['id']."')\">".$core->txt('0027')."</a>";
                        echo "&nbsp;-&nbsp;";
                        echo "<a href=\"javascript:void(0);\" onclick=\"javascript:goto('".V_URLP."users-activation-now&id=".$r['id']."&v=".!$r['activated']."')\">";
                            if($r['activated'])
                                echo $core->txt('0031');
                            else
                                echo $core->txt('0022');
                        echo "</a>";
                        echo "&nbsp;-&nbsp;";
                        echo "<a href=\"javascript:void(0);\" onclick=\"doAlr('".V_URLP."users-delete-now&id=".$r['id']."', '".$core->txt('0030')."')\">".$core->txt('0026')."</a>";
                    echo "</td>";
                    }
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('users', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>

<?php echo $theme->getFooter(); ?>