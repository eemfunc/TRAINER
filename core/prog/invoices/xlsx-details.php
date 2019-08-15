<?php
    $core->userChkRole('INVOICES-XLSX');

if(isset($_GET['id'])){
    $core->requireClass('xlsxvars');
    $xlsx = new xlsxvars($_GET['id']);
    if(!$xlsx->STATUS)
        $core->err(404);
}else
    $core->err(404);

echo $theme->getHeader();

?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="hb title-size center rtl"><?php echo $xlsx->INV_NAME; ?><br><br></h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th><?php echo $core->txt('0113'); ?></th>
                              <th><?php echo $core->txt('0050'); ?></th>
                              <th><?php echo $core->txt('0085'); ?></th>
                              <th><?php echo $core->txt('0089'); ?></th>
                              <th><?php echo $core->txt('0219'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

<?php
    if(count($xlsx->ARR)){
        for($i = 0; $i < count($xlsx->ARR); $i++){
            $red_bg = ($xlsx->ARR[$i][11])?" style='background-color:#fc7242;'":'';
            echo '<tr '.$red_bg.'>';
                echo "<td>".$xlsx->ARR[$i][0]."</td>";
                echo "<td>".$xlsx->ARR[$i][2]."</td>";
                echo "<td>".$xlsx->getImporterName($xlsx->ARR[$i][1])."</td>";
                echo "<td>".$core->nf($xlsx->ARR[$i][5])."</td>";
                echo "<td>"
                    .$core->txt('0055').': '.$core->nf($xlsx->ARR[$i][6]).' '.$core->txt('0121').'<br><br>'
                    .$core->txt('0201').': '.$core->nf($xlsx->ARR[$i][7]).' '.$core->txt('0135').'<br><br>'
                    .$core->txt('0112').': '.$core->nf($xlsx->ARR[$i][8]).' '.$core->txt('0135').'<br><br>'
                    .$core->txt('0111').': '.$core->nf($xlsx->ARR[$i][9]).' '.$core->txt('0134').'<br><br>'
                    .$core->txt('0110').': '.$core->nf($xlsx->ARR[$i][10]).' '.$core->txt('0134').'<br>'
                    ."</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    }else{
        echo "</tbody></table>";
        echo "<table class='table table-bordered'><tbody><tr><td class='center'>".$core->txt('0018')."</td></tr></tbody></table>";
    }
?>


                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $theme->getFooter(); ?>