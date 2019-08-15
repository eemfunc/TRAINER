<?php 
    $core->userChkRole('INVOICES-XLSX');
    echo $theme->getHeader();

    $url_link_p = "invoices-xlsx";

?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card rtl">
        <div class="card">
            <div>
                <form autocomplete="off" class="forms-sample" method="post" action="<?php echo V_URLP.'invoices-xlsx-upload-now'; ?>"  enctype="multipart/form-data">
                    <div class="form-group" style="margin:0;">
                        <div class="row">
                            
                            <div class="col-lg-3" style="padding-right:45px;">
                                <label for="xlfile"><?php echo $core->txt('0192'); ?></label>
                                <input type="file" name="xlfile" id="xlfile" class="form-control form-control-sm  btm-sm" accept=".xlsx">
                                <input type="hidden" name="xlfile_to_json" id="xlfile_to_json">
                            </div>
                            <div class="col-lg-1" style="padding-right:0;">
                                <button type="submit" class="btn btn-primary btm-sm mr-2 rtl" style="margin-top:25px;"><?php echo $core->txt('0122'); ?></button>
                            </div>
                            
                            <div class="col-lg-5"></div>
                                
                            <div class="col-lg-3 ltr" style="top:22px;padding-left:45px;">
                                <h4 class="hb title-size"><?php echo $core->txt('0079'); ?></h4>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="hb title-size center"><?php echo $core->txt('0079'); ?><br><br></h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th><?php echo $core->txt('0057'); ?></th>
                              <th><?php echo $core->txt('0210'); ?></th>
                              <th><?php echo $core->txt('0097'); ?></th>
                              <th><?php echo $core->txt('0220'); ?></th>
                              <th><?php echo $core->txt('0211'); ?></th>
                              <th><?php echo $core->txt('0017'); ?></th>
                              <th><?php echo $core->txt('0019'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

<?php
    $core->requireClass('xlsxvars');
    $rows = $core->dbFetch('invoices_xlsx', null, 'ORDER BY created_at DESC', true, true);
    foreach($rows as $r){
        if($core->chkFilterLimits()){
            echo "<tr>";
                
                $xlsx = new xlsxvars($r['id']);
            
                echo "<td>".$core->aes($r['name'], 1)."</td>";
            
                echo "<td>".$xlsx->getUserName($r['user_id'])."</td>";
            
                echo "<td>".$core->txt('0208').':<br><br>'.explode(' ', $r['created_at'])[0];
                    if($core->aes($r['arrival_date'], 1) != null)
                        echo '<br><br><br>'.$core->txt('0209').':<br><br>'.$core->aes($r['arrival_date'], 1);
                echo "</td>";
                
                echo "<td>".$core->txt('0217').': '.$core->nf($xlsx->REPEATED_PRODUCTS)
                    ."<br><br>".$core->txt('0218').': '.$core->nf($xlsx->NEW_PRODUCTS);
                echo "</td>";
                
                if($core->aes($r['errors'], 1) == 0)
                    echo "<td><div class='badge badge-success badge-pill'>".$core->txt('0215')."</div></td>";
                else
                    echo "<td><div class='badge badge-danger badge-pill'>".$core->txt('0214')."</div></td>";
                
                echo "<td>";
                    if($r['done'] == 2)
                        echo "<div class='badge badge-success badge-pill'>".$core->txt('0194')."</div>";
                    elseif($r['done'])
                        echo "<div class='badge badge-warning badge-pill'>".$core->txt('0194')."</div>";
                    else 
                        echo "<div class='badge badge-danger badge-pill'>".$core->txt('0195')."</div>";
            
                echo "</td>";
            
                echo "<td>";
                    echo "<a href='".V_URLP.'invoices-xlsx-details&id='.$r['id']."'>".$core->txt('0206')."</a><br><br>";
                    if($r['done'] == 0){
                        echo "<a href='".V_URLP.'invoices-xlsx-finish-products&id='.$r['id']."'>".$core->txt('0213')."</a><br><br>";
                        echo "<a href='".V_URLP.'invoices-xlsx-finish-quantities&id='.$r['id']."'>".$core->txt('0212')."</a><br><br>";
                    }elseif($r['done'] == 1){
                        echo "<a href='".V_URLP.'invoices-xlsx-finish-quantities&id='.$r['id']."'>".$core->txt('0221')."</a><br><br>";
                    }
                    echo "<a href='".$core->aes($r['url'], 1)."'>".$core->txt('0196')."</a><br><br>";
                    if(!$r['done']){
                        echo "<a href=\"javascript:void(0);\" onclick=\"doAlr('".V_URLP."invoices-xlsx-delete-now&id=".$r['id']."', '".$core->txt('0216')."')\">".$core->txt('0026')."</a>";
                    }
                echo "</td>";
            
            echo "</tr>";
        }
    }
    echo $theme->fetchFooter('invoices_xlsx', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
    ?>
</div></div></div></div></div>
    
<script src="<?php echo V_THEME_FOLDER_PATH; ?>assets/vendors/xlsx/cpexcel.js"></script>
<script src="<?php echo V_THEME_FOLDER_PATH; ?>assets/vendors/xlsx/shim.min.js"></script>
<script src="<?php echo V_THEME_FOLDER_PATH; ?>assets/vendors/xlsx/jszip.js"></script>
<script src="<?php echo V_THEME_FOLDER_PATH; ?>assets/vendors/xlsx/xlsx.min.js"></script>
<script src="<?php echo V_THEME_FOLDER_PATH; ?>assets/vendors/xlsx/xlfile.js"></script>

<?php echo $theme->getFooter(); ?>